<?php

namespace App\Authentication;

use CodeIgniter\Events\Events;
use CodeIgniter\Model;

use App\Config\Auth as AuthConfig;
use App\Entities\User;
use App\Exceptions\AuthException;
use App\Exceptions\UserNotFoundException;
use App\Models\LoginModel;

class AuthenticationBase {
  /**
   * @var User|null
   */
  protected $user;

  /**
   * @var Model
   */
  protected $userModel;

  /**
   * @var LoginModel
   */
  protected $loginModel;

  /**
   * @var string
   */
  protected $error;

  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   *
   */
  public function __construct($config) {
    $this->config = $config;
  }

  /**
   * --------------------------------------------------------------------------
   * Error.
   * --------------------------------------------------------------------------
   *
   * Returns the current error, if any.
   *
   * @return string
   */
  public function error(): string {
    return $this->error;
  }

  /**
   * --------------------------------------------------------------------------
   * Silent.
   * --------------------------------------------------------------------------
   *
   * Whether to continue instead of throwing exceptions, as defined in config.
   *
   * @return bool
   */
  public function silent(): bool {
    return (bool)$this->config->silent;
  }

  /**
   * --------------------------------------------------------------------------
   * Login.
   * --------------------------------------------------------------------------
   *
   * Logs a user into the system.
   * NOTE: does not perform validation. All validation should be done prior to
   * using the login method, incl. 2FA.
   *
   * @param User $user
   * @param bool $remember
   *
   * @return bool
   * @throws \Exception
   */
  public function login(User $user = null, bool $remember = false): bool {
    if (empty($user)) {
      $this->user = null;
      return false;
    }

    $this->user = $user;

    //
    // Always record a login attempt
    //
    $ipAddress = service('request')->getIPAddress();
    $this->recordLoginAttempt($user->email, true, 'Success', $ipAddress, $user->id ?? null);

    //
    // Regenerate the session ID to help protect against session fixation
    //
    if (ENVIRONMENT !== 'testing') {
      session()->regenerate();
    }

    //
    // Let the session know we're logged in
    //
    session()->set('logged_in', $this->user->id);

    //
    // When logged in, ensure cache control headers are in place
    //
    service('response')->noCache();

    if ($remember && $this->config->allowRemembering) {
      $this->rememberUser($this->user->id);
    }

    //
    // We'll give a 20% chance to need to do a purge since we don't need to
    // purge THAT often, it's just a maintenance issue to keep the table
    // from getting out of control.
    //
    if (mt_rand(1, 100) < 20) {
      $this->loginModel->purgeOldRememberTokens();
    }

    //
    // Trigger login event, in case anyone cares
    //
    Events::trigger('login', $user);

    return true;
  }

  /**
   * --------------------------------------------------------------------------
   * Is logged in.
   * --------------------------------------------------------------------------
   *
   * Checks to see if the user is logged in.
   *
   * @return bool
   */
  public function isLoggedIn(): bool {
    //
    // On the off chance
    //
    if ($this->user instanceof User) {
      return true;
    }

    if ($userID = session('logged_in')) {
      //
      // Store our current user object
      //
      $this->user = $this->userModel->find($userID);
      return $this->user instanceof User;
    }

    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Login by ID.
   * --------------------------------------------------------------------------
   *
   * Logs a user into the system by their ID.
   *
   * @param int $id
   * @param bool $remember
   *
   * @return bool
   */
  public function loginByID(int $id, bool $remember = false): bool {
    $user = $this->retrieveUser([ 'id' => $id ]);

    if (empty($user)) {
      throw UserNotFoundException::forUserID($id);
    }

    return $this->login($user, $remember);
  }

  /**
   * --------------------------------------------------------------------------
   * Logout.
   * --------------------------------------------------------------------------
   *
   * Logs a user out of the system.
   */
  public function logout(): void {
    helper('cookie');
    //
    // Destroy the session data - but ensure a session is still
    // available for flash messages, etc.
    //
    if (isset($_SESSION)) {
      foreach ($_SESSION as $key => $value) {
        $_SESSION[$key] = null;
        unset($_SESSION[$key]);
      }
    }
    //
    // Regenerate the session ID for a touch of added safety.
    //
    session()->regenerate(true);
    //
    // Remove the cookie
    //
    delete_cookie("remember");
    //
    // Handle user-specific tasks
    //
    if ($user = $this->user()) {
      //
      // Take care of any remember me functionality
      //
      $this->loginModel->purgeRememberTokens($user->id);
      //
      // Trigger logout event
      //
      Events::trigger('logout', $user);
      $this->user = null;
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Record login attempt.
   * --------------------------------------------------------------------------
   *
   * @param string $email
   * @param string|null $ipAddress
   * @param int|null $userID
   * @param bool $success
   * @param string $info
   *
   * @return bool|int|string
   */
  public function recordLoginAttempt(string $email, bool $success, string $info, string $ipAddress = null, int $userID = null): bool|int|string {
    return $this->loginModel->insert([
      'ip_address' => $ipAddress,
      'email' => $email,
      'user_id' => $userID,
      'date' => date('Y-m-d H:i:s'),
      'success' => (int)$success,
      'info' => $info,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Remember user.
   * --------------------------------------------------------------------------
   *
   * Generates a timing-attack safe remember me token and stores the necessary
   * info in the db and a cookie.
   * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
   *
   * @param int $userID
   *
   * @throws \Exception
   */
  public function rememberUser(int $userID): void {
    $selector = bin2hex(random_bytes(12));
    $validator = bin2hex(random_bytes(20));
    $expires = date('Y-m-d H:i:s', time() + $this->config->rememberLength);

    $token = $selector . ':' . $validator;

    //
    // Store it in the database
    //
    $this->loginModel->rememberUser($userID, $selector, hash('sha256', $validator), $expires);

    //
    // Save it to the user's browser in a cookie.
    //
    $cookieConfig = config('Cookie');
    $response = service('response');

    //
    // Create the cookie
    //
    $response->setCookie(
      'remember',                      // Cookie Name
      $token,                          // Value
      $this->config->rememberLength,   // # Seconds until it expires
      $cookieConfig->domain,
      $cookieConfig->path,
      $cookieConfig->prefix,
      $cookieConfig->secure,           // Only send over HTTPS?
      true                             // Hide from Javascript?
    );
  }

  /**
   * --------------------------------------------------------------------------
   * Refresh remember.
   * --------------------------------------------------------------------------
   *
   * Sets a new validator for this user/selector. This allows a one-time use
   * of remember-me tokens, but still allows a user to be remembered on
   * multiple browsers/devices.
   *
   * @param int $userID
   * @param string $selector
   *
   * @return void
   */
  public function refreshRemember(int $userID, string $selector): void {
    $existing = $this->loginModel->getRememberToken($selector);

    //
    // No matching record? Shouldn't happen, but remember the user now.
    //
    if (empty($existing)) {
      $this->rememberUser($userID);
      return;
    }

    //
    // Update the validator in the database and the session
    //
    $validator = bin2hex(random_bytes(20));

    $this->loginModel->updateRememberValidator($selector, $validator);

    //
    // Save it to the user's browser in a cookie.
    //
    helper('cookie');

    $cookieConfig = config('Cookie');

    //
    // Create the cookie
    //
    set_cookie(
      'remember',                             // Cookie Name
      $selector . ':' . $validator,           // Value
      (string)$this->config->rememberLength,  // # Seconds until it expires
      $cookieConfig->domain,
      $cookieConfig->path,
      $cookieConfig->prefix,
      $cookieConfig->secure,                  // Only send over HTTPS?
      true                            // Hide from Javascript?
    );
  }

  /**
   * --------------------------------------------------------------------------
   * Id.
   * --------------------------------------------------------------------------
   *
   * Returns the User ID for the current logged in user.
   *
   * @return int|null
   */
  public function id(): ?int {
    return $this->user->id ?? null;
  }

  /**
   * --------------------------------------------------------------------------
   * User.
   * --------------------------------------------------------------------------
   *
   * Returns the User instance for the current logged in user.
   *
   * @return User|null
   */
  public function user(): ?User {
    return $this->user;
  }

  /**
   * --------------------------------------------------------------------------
   * Retrieve user.
   * --------------------------------------------------------------------------
   *
   * Grabs the current user from the database.
   *
   * @param array $wheres
   *
   * @return array|null|object
   */
  public function retrieveUser(array $wheres): array|null|object {
    if (!$this->userModel instanceof Model) {
      throw AuthException::forInvalidModel('User');
    }
    return $this->userModel->where($wheres)->first();
  }

  /**
   * --------------------------------------------------------------------------
   * Set user model.
   * --------------------------------------------------------------------------
   *
   * Sets the model that should be used to work with user accounts.
   *
   * @param Model $model
   *
   * @return $this
   */
  public function setUserModel(Model $model): AuthenticationBase {
    $this->userModel = $model;
    return $this;
  }

  /**
   * --------------------------------------------------------------------------
   * Set login model.
   * --------------------------------------------------------------------------
   *
   * Sets the model that should be used to record login attempts (but failed
   * and successful).
   *
   * @param LoginModel $model
   *
   * @return $this
   */
  public function setLoginModel(Model $model): AuthenticationBase {
    $this->loginModel = $model;
    return $this;
  }
}

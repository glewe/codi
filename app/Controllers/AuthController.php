<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Authentication\LocalAuthenticator;
use App\Authorization\FlatAuthorization;
use App\Entities\User;
use App\Models\UserModel;
use App\Models\UserOptionModel;
use CodeIgniter\Throttle\Throttler;
use Config\Auth as AuthConfig;
use RobThree\Auth\Providers\Qr\EndroidQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;

/**
 * Class AuthController
 */
class AuthController extends BaseController
{
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var string Log type used in log entries from this controller.
   */
  protected string $logType;

  /**
   * @var LocalAuthenticator
   */
  protected LocalAuthenticator $auth;

  /**
   * @var AuthConfig
   */
  protected AuthConfig $authConfig;

  /**
   * @var FlatAuthorization
   */
  protected FlatAuthorization $authorize;

  /**
   * @var UserModel
   */
  protected UserModel $users;

  /**
   * @var TwoFactorAuth
   */
  protected TwoFactorAuth $tfa;

  /**
   * The 2FA secret key will be encrypted before put into the database and
   * decrypted before used during the 2FA login. This is the cipher algo
   * for en- and decrypting.
   *
   * @var string
   */
  protected string $cipher = "AES-256-CBC";

  /**
   * The 2FA secret key will be encrypted before put into the database and
   * decrypted before used during the 2FA login. This is the passphrase
   * for en- and decrypting.
   *
   * @var string
   */
  protected string $passphrase;

  /**
   * @var Throttler
   */
  protected Throttler $throttler;

  //---------------------------------------------------------------------------
  /**
   * Constructor.
   */
  public function __construct() {
    //
    // Most services in this controller require the session to be started
    //
    $this->logType    = 'Auth';
    $this->authConfig = config('Auth');
    $this->auth       = service('authentication');
    $this->authorize  = service('authorization');
    $this->tfa        = new TwoFactorAuth(new EndroidQrCodeProvider(), $this->authConfig->authenticatorTitle);
    $this->passphrase = hex2bin('8849523a8e0e1ff45f440da048428b2554d2660c80957fcedbeb9575c079d7eb');
    $this->users      = model(UserModel::class);
    $this->throttler  = service('throttler');
  }

  //---------------------------------------------------------------------------
  /**
   * Activate account.
   *
   * @return mixed
   */
  public function activateAccount(): mixed {
    //
    // First things first - log the activation attempt.
    //
    $this->users->logActivationAttempt(
      $this->request->getGet('token'),
      $this->request->getIPAddress(),
      (string) $this->request->getUserAgent()
    );

    if ($this->throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
      return service('response')->setStatusCode(429)->setBody(lang('Auth.login.too_many_requests', [$this->throttler->getTokentime()]));
    }

    /** @var User|null $user */
    $user = $this->users->where('activate_hash', $this->request->getGet('token'))->where('active', 0)->first();

    if (is_null($user)) {
      return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
    }

    $user->activate();
    $this->users->save($user);

    logEvent(
      [
        'type'  => $this->logType,
        'event' => lang('Auth.register.success'),
        'user'  => user_username(),
        'ip'    => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('login')->with('message', lang('Auth.register.success'));
  }

  //---------------------------------------------------------------------------
  /**
   * Resend activation account.
   *
   * @return mixed
   */
  public function activateAccountResend(): mixed {
    if ($this->authConfig->requireActivation === null) {
      return redirect()->route('login');
    }

    if ($this->throttler->check(md5($this->request->getIPAddress()), 2, MINUTE) === false) {
      return service('response')->setStatusCode(429)->setBody(lang('Auth.login.too_many_requests', [$this->throttler->getTokentime()]));
    }

    $login = urldecode($this->request->getGet('login'));
    $type  = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    /** @var User|null $user */
    $user = $this->users->where($type, $login)->where('active', 0)->first();

    if (is_null($user)) {
      return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
    }

    $activator = service('activator');
    $sent      = $activator->send($user);

    if (!$sent) {
      return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.exception.unknown_error'));
    }
    //
    // Success!
    //
    logEvent(
      [
        'type'  => $this->logType,
        'event' => lang('Auth.activation.success'),
        'user'  => user_username(),
        'ip'    => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('login')->with('message', lang('Auth.activation.success'));
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the CI4-Auth error page.
   *
   * @return mixed
   */
  public function error(): mixed {
    return $this->_render($this->authConfig->views['error_auth'], ['authConfig' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Forgot password.
   *
   * Displays the forgot password form.
   *
   * @return mixed
   */
  public function forgotPassword(): mixed {
    if ($this->authConfig->activeResetter === null) {
      return redirect()->route('login')->with('error', lang('Auth.forgot.disabled'));
    }

    return $this->_render($this->authConfig->views['forgot'], ['authConfig' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Forgot password do.
   *
   * Attempts to find a user account with the given email address and sends
   * password reset instructions to them.
   *
   * @return mixed
   */
  public function forgotPasswordDo(): mixed {
    if ($this->authConfig->activeResetter === null) {
      return redirect()->route('login')->with('error', lang('Auth.forgot.disabled'));
    }

    /** @var User|null $user */
    $user = $this->users->where('email', $this->request->getPost('email'))->first();

    if (is_null($user)) {
      return redirect()->back()->with('error', lang('Auth.forgot.no_user'));
    }

    //
    // Save the reset hash
    //
    $user->generateResetHash();
    $this->users->save($user);

    $sent = sendResetEmail($user);
    if (!$sent) {
      return redirect()->back()->withInput()->with('error', lang('Auth.forgot.error_email', [$user->email]));
    }
    logEvent(
      [
        'type'  => $this->logType,
        'event' => lang('Auth.forgot.email_sent'),
        'user'  => user_username(),
        'ip'    => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('reset-password')->with('message', lang('Auth.forgot.email_sent'));
  }

  //---------------------------------------------------------------------------
  /**
   * Login.
   *
   * Displays the login form, or redirects the user to their destination/home
   * if they are already logged in.
   *
   * @return mixed
   */
  public function login(): mixed {
    //
    // No need to show a login form if the user is already logged in.
    //
    if ($this->auth->check()) {
      $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
      $this->session->remove('redirect_url');
      return redirect()->to($redirectURL);
    }

    //
    // Set a return URL if none is specified
    //
    $this->session->set('redirect_url', $this->session->get('redirect_url') ?? previous_url());

    return $this->_render($this->authConfig->views['login'], ['authConfig' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Login do.
   *
   * Attempts to verify the user's credentials through a POST request.
   *
   * @return mixed
   */
  public function loginDo(): mixed {
    $rules = [
      'login'    => 'required',
      'password' => 'required',
    ];

    if ($this->authConfig->validFields == ['email']) {
      $rules['login'] .= '|valid_email';
    }

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $login    = $this->request->getPost('login');
    $password = $this->request->getPost('password');
    $remember = (bool) $this->request->getPost('remember');
    //
    // Determine credential type
    //
    $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //
    // Try to log them in...
    //
    if (!$this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
      logEvent(
        [
          'type'  => $this->logType,
          'event' => $this->auth->error() ?: lang('Auth.login.bad_attempt'),
          'user'  => $login,
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('error', $this->auth->error() ?: lang('Auth.login.bad_attempt'));
    }
    //
    // Is the user being forced to reset their password?
    //
    if ($this->auth->user()->force_pass_reset === true) {
      return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
    }
    //
    // At this point we know that the user submitted the correct credentials.
    // Now we need to check whether a 2FA is required.
    //
    /** @var User|null $user */
    $user = $this->users->where('email', $this->auth->user()->email)->first();

    if ($user === null) {
      return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
    }

    if ($this->auth->user()->hasSecret()) {
      //
      // User has setup 2FA. Save the user's email in a session variable and redirect to 2FA login page.
      //
      $this->session->set('2fa_in_progress', $user->email);
      $this->session->set('ci4auth-remember', $remember);
      $redirectURL = site_url('/login2fa');
      return redirect()->to($redirectURL)->withCookies();
    }
    else {
      //
      // User has not setup 2FA.
      //
      if ($this->settings->getSetting('require2fa')) {
        //
        // 2FA is required. Login the user and redirect to 2FA Setup.
        //
        $this->session->set('2fa_setup_required', $user->email);
        $redirectURL = site_url('/setup2fa');
        $this->session->remove('redirect_url');
        return redirect()->to($redirectURL)->withCookies();
      }
      else {
        //
        // 2FA is not setup and not required. Login the user.
        //
        $this->session->remove('2fa_setup_required');
        $this->auth->login($user, $remember);
        //
        // Get user language and set it in the session
        //
        $UO           = model(UserOptionModel::class);
        $userLanguage = $UO->getOption(['user_id' => $user->id, 'option' => 'language']);
        if ($userLanguage && in_array($userLanguage, config('App')->supportedLocales)) {
          $this->session->set('lang', $userLanguage);
        }
        //
        // Redirect to the intended page
        //
        $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
        $this->session->remove('redirect_url');
        logEvent(
          [
            'type'  => $this->logType,
            'event' => lang('Log.login_successful') . ': ' . $user->email,
            'user'  => user_username(),
            'ip'    => $this->request->getIPAddress(),
          ]
        );
        return redirect()->to($redirectURL)->withCookies()->with('success', lang('Auth.login.success'));
      }
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Login 2FA.
   *
   * Displays the 2FA login page.
   *
   * @return mixed
   */
  public function login2fa(): mixed {
    //
    // Redirect back if already logged in
    //
    if ($this->auth->check()) {
      $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
      $this->session->remove('redirect_url');
      return redirect()->to($redirectURL);
    }
    //
    // Redirect back if 2fa_in_progress cookie not set
    //
    if (!$this->session->get('2fa_in_progress')) {
      $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
      $this->session->remove('redirect_url');
      return redirect()->to($redirectURL);
    }
    //
    // Get the remember setting from the login page
    //
    /** @var User|null $user */
    $user = $this->users->where('email', $this->session->get('2fa_in_progress'))->first();
    if ($user === null) {
      return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
    }
    return $this->_render(
      $this->authConfig->views['login2fa'],
      [
        'authConfig' => $this->authConfig,
        'user'       => $user,
        'remember'   => $this->session->get('ci4auth-remember'),
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Login 2FA do.
   *
   * Attempts to verify the user's 2FA PIN through a POST request.
   *
   * @return mixed
   */
  public function login2faDo(): mixed {
    $rules = [
      'pin' => 'required|numeric',
    ];
    //
    // Validate input
    //
    $res = $this->validate($rules);
    if (!$res) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
    //
    // Redirect back if 2fa_in_progress cookie not set
    //
    if (!$this->session->get('2fa_in_progress')) {
      $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
      $this->session->remove('redirect_url');
      return redirect()->to($redirectURL)->withCookies()->with('errors', lang('Auth.2fa.login.no_2fa_in_progress'));
    }
    //
    // Check PIN
    //
    if ($this->request->getPost('pin')) {
      /** @var User|null $user */
      $user = $this->users->where('email', $this->session->get('2fa_in_progress'))->first();
      if ($user === null) {
        return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
      }
      //
      // Get the hashed secret, decrypt and verify the PIN with it.
      //
      $pin          = $this->request->getPost('pin');
      $secret_hash  = $user->getSecret();
      $secret       = $this->decrypt($secret_hash, true);
      $verifyResult = $this->tfa->verifyCode($secret, $pin);
      if ($verifyResult) {
        //
        // Success. Log the user in.
        //
        $this->auth->login($user, $this->session->get('ci4auth-remember'));
        $redirectURL = $this->session->get('redirect_url') ?? site_url('/');
        $this->session->remove('redirect_url');
        $this->session->remove('2fa_in_progress');
        $this->session->remove('ci4auth-remember');
        logEvent(
          [
            'type'  => $this->logType,
            'event' => lang('Log.login_successful') . ': ' . $user->email,
            'user'  => user_username(),
            'ip'    => $this->request->getIPAddress(),
          ]
        );
        return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.login.success'));
      }
      else {
        //
        // No match. Reload page with the same secret.
        //
        $this->session->setFlashdata('error', lang('Auth.2fa.setup.mismatch'));
        return $this->_render(
          $this->authConfig->views['login2fa'],
          [
            'authConfig' => $this->authConfig,
            'user'       => $user,
            'remember'   => $this->session->get('ci4auth-remember'),
          ]
        );
      }
    }
    else {
      //
      // No PIN submitted.
      //
      return redirect()->back()->withInput()->with('errors', lang('Auth.2fa.authenticator_code_missing'));
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Logout.
   *
   * Log the user out.
   *
   * @return mixed
   */
  public function logout(): mixed {
    if ($this->auth->check()) {
      logEvent(
        [
          'type'  => $this->logType,
          'event' => lang('Log.logout') . ': ' . user_email(),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      $this->auth->logout();
    }
    return redirect()->to(site_url('/'))->with('success', lang('Auth.login.logout_success'));
  }

  //---------------------------------------------------------------------------
  /**
   * Register.
   *
   * Displays the user registration page.
   *
   * @return mixed
   */
  public function register(): mixed {
    //
    // Redirect back if already logged in
    //
    if ($this->auth->check()) {
      return redirect()->back();
    }

    //
    // Redirect back with error if registration is not allowed
    //
    //    if (!$this->authConfig->allowRegistration) return redirect()->back()->withInput()->with('error', lang('Auth.register.disabled'))
    if (!$this->settings->getSetting('allowRegistration')) {
      return redirect()->back()->withInput()->with('error', lang('Auth.register.disabled'));
    }

    return $this->_render($this->authConfig->views['register'], ['authConfig' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Register do.
   *
   * Attempt to register a new user.
   *
   * @return mixed
   */
  public function registerDo(): mixed {
    //
    // Check if registration is allowed
    //
    if (!$this->settings->getSetting('allowRegistration')) {
      return redirect()->back()->withInput()->with('error', lang('Auth.register.disabled'));
    }

    $users = model(UserModel::class);

    //
    // Validate basics first since some password rules rely on these fields
    //
    $rules = [
      'username'    => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
      'email'       => 'required|valid_email|is_unique[users.email]',
      'firstname'   => 'max_length[80]',
      'lastname'    => 'max_length[80]',
      'displayname' => 'max_length[80]',
    ];
    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    //
    // Validate passwords since they can only be validated properly here
    //
    $rules = [
      'password'     => 'required|strongPassword',
      'pass_confirm' => 'required|matches[password]',
    ];
    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    //
    // Save the user. If activation is required, generate a hash.
    //
    $allowedPostFields = array_merge(['password'], $this->authConfig->validFields, $this->authConfig->personalFields);
    $user              = new User($this->request->getPost($allowedPostFields));
    $this->authConfig->requireActivation === null ? $user->activate() : $user->generateActivateHash();

    //
    // Ensure default role gets assigned if set
    //
    if (!empty($this->authConfig->defaultUserRole)) {
      $users = $users->withRole($this->authConfig->defaultUserRole);
    }

    if (!$users->save($user)) {
      return redirect()->back()->withInput()->with('errors', $users->errors());
    }

    if ($this->authConfig->requireActivation !== null) {
      //      $activator = service('activator')
      //      $sent = $activator->send($user)
      //      if (!$sent) return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.exception.unknown_error'))
      $sent = sendActivationEmail($user);
      if (!$sent) {
        return redirect()->back()->withInput()->with('error', lang('Auth.activation.error_sending', [$user->email]));
      }

      //
      // Success!
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => lang('Auth.activation.success') . ': ' . $user->email,
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->route('login')->with('message', lang('Auth.activation.success'));
    }

    //
    // Success!
    //
    logEvent(
      [
        'type'  => $this->logType,
        'event' => lang('Auth.register.success') . ': ' . $user->email,
        'user'  => user_username(),
        'ip'    => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('login')->with('message', lang('Auth.register.success'));
  }

  //---------------------------------------------------------------------------
  /**
   * Reset password.
   *
   * Displays the Reset Password form.
   *
   * @return mixed
   */
  public function resetPassword(): mixed {
    if ($this->authConfig->activeResetter === null) {
      return redirect()->route('login')->with('error', lang('Auth.forgot.disabled'));
    }

    $token = $this->request->getGet('token');

    return $this->_render($this->authConfig->views['reset'], [
      'authConfig' => $this->authConfig,
      'token'      => $token,
    ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Reset password do.
   *
   * Verifies the code with the email and saves the new password,
   * if they all pass validation.
   *
   * @return mixed
   */
  public function resetPasswordDo(): mixed {
    if ($this->authConfig->activeResetter === null) {
      return redirect()->route('login')->with('error', lang('Auth.forgot.disabled'));
    }

    //
    // First things first - log the reset attempt.
    //
    $this->users->logResetAttempt(
      $this->request->getPost('email'),
      $this->request->getPost('token'),
      $this->request->getIPAddress(),
      (string) $this->request->getUserAgent()
    );

    //
    // Use CodeIgniter validation service for input validation
    //
    $rules = [
      'token'        => 'required',
      'email'        => 'required|valid_email',
      'password'     => 'required|strongPassword',
      'pass_confirm' => 'required|matches[password]',
    ];
    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    /** @var User|null $user */
    $user = $this->users
      ->where('email', $this->request->getPost('email'))
      ->where('reset_hash', $this->request->getPost('token'))
      ->first();

    if (is_null($user)) {
      return redirect()->back()->with('error', lang('Auth.forgot.no_user'));
    }

    //
    // Reset token still valid?
    //
    if (!empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp()) {
      return redirect()->back()->withInput()->with('error', lang('Auth.password.reset_token_expired'));
    }

    //
    // Success! Save the new password, and cleanup the reset hash.
    //
    $user->password         = $this->request->getPost('password');
    $user->reset_hash       = null;
    $user->reset_at         = \CodeIgniter\I18n\Time::now();
    $user->reset_expires    = null;
    $user->force_pass_reset = false;
    $this->users->save($user);

    logEvent(
      [
        'type'  => $this->logType,
        'event' => lang('Auth.forgot.reset_success') . ': ' . $this->request->getPost('email'),
        'user'  => user_username(),
        'ip'    => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('login')->with('message', lang('Auth.forgot.reset_success'));
  }

  //---------------------------------------------------------------------------
  /**
   * Setup 2FA.
   *
   * Displays the 2FA setup page.
   *
   * @param string|null $secret Optional, to show the same QR code on wrong verify
   *
   * @return mixed
   */
  public function setup2fa(?string $secret = null): mixed {
    //
    // Redirect back if not logged in and no forced 2FA setup is in progress
    //
    if (!$this->auth->check() && !$this->session->get('2fa_setup_required')) {
      return redirect()->back();
    }

    if (!$this->auth->check() && $this->session->get('2fa_setup_required')) {
      //
      // The user got here after logging in fine with his credentials but a 2FA setup is required. He must setup 2FA before he can be logged in for good.
      // At login, the user's email was saved in session('2fa_setup_required') so we know who we are dealing with here.
      //
      /** @var User|null $user */
      $user = $this->users->where('email', $this->session->get('2fa_setup_required'))->first();
      if ($user === null) {
        return redirect()->route('login')->with('error', lang('Auth.activation.no_user'));
      }
      $has_secret = false;
    }
    else {
      //
      // The user called this page to setup his 2FA
      //
      /** @var User|null $user */
      $user = user();
      if ($user === null) {
        return redirect()->route('login');
      }
      $has_secret = $user->hasSecret();
    }

    //
    // Init 2FA variables
    //
    if (!$secret) {
      $secret = $this->tfa->createSecret();
    }
    $qrcode = $this->tfa->getQRCodeImageAsDataUri($user->email, $secret);

    //
    // Render the page
    //
    return $this->_render(
      $this->authConfig->views['setup2fa'],
      [
        'authConfig' => $this->authConfig,
        'qrcode'     => $qrcode,
        'secret'     => $secret,
        'user'       => $user,
        'has_secret' => $has_secret,
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Setup 2FA do.
   *
   * Attempt to setup 2FA for a user.
   *
   * @return mixed
   */
  public function setup2faDo(): mixed {
    /** @var User|null $user */
    $user = $this->users->where('email', $this->request->getPost('hidden_email'))->first();

    $rules = [
      'authenticator_code' => 'required|numeric',
    ];

    //
    // Validate input
    //
    $res = $this->validate($rules);
    if (!$res) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    //
    // Save the settings
    //
    if ($this->request->getPost('authenticator_code')) {
      $secret       = $this->request->getPost('hidden_secret');
      $totp         = $this->request->getPost('authenticator_code');
      $verifyResult = $this->tfa->verifyCode($secret, $totp);
      if ($verifyResult) {
        //
        // Success. Hash and save the secret to the user record.
        //
        $user->setSecret($this->encrypt($secret, true));
        $this->users->save($user);
        //
        // In case this was a required setup, log in the user for
        // good and unset the session variable.
        //
        if ($this->session->get('2fa_setup_required')) {
          $remember = $this->session->get('ci4auth-remember') ?? false;
          $this->auth->login($user, $remember);
          $this->session->remove('redirect_url');
          $this->session->remove('2fa_in_progress');
          $this->session->remove('2fa_setup_progress');
          $this->session->remove('ci4auth-remember');
        }
        return redirect()->route('/')->with('message', lang('Auth.2fa.setup.success'));
      }
      else {
        //
        // No match. Reload page with the same secret.
        //
        $qrcode = $this->tfa->getQRCodeImageAsDataUri($user->email, $secret);
        session()->setFlashdata('error', lang('Auth.2fa.setup.mismatch'));
        return $this->_render(
          $this->authConfig->views['setup2fa'],
          [
            'authConfig' => $this->authConfig,
            'qrcode'     => $qrcode,
            'secret'     => $secret,
            'user'       => $user,
            'has_secret' => $user->hasSecret(),
          ]
        );
      }
    }
    else {
      //
      // No code submitted.
      //
      return redirect()->back()->withInput()->with('errors', lang('Auth.2fa.setup.authenticator_code_missing'));
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Whoami.
   *
   * Displays the Whoami page.
   *
   * @return mixed
   */
  public function whoami(): mixed {
    return $this->_render($this->authConfig->views['whoami'], ['authConfig' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Encrypt.
   *
   * Encrypts (but does not authenticate) a string.
   *
   * @param string $plaintext String to encrypt
   * @param bool   $encode    Return base64-encoded or not
   *
   * @return string
   */
  protected function encrypt(string $plaintext, bool $encode = false): string {
    $nonceSize = openssl_cipher_iv_length($this->cipher);
    $nonce     = openssl_random_pseudo_bytes($nonceSize);

    $ciphertext = openssl_encrypt(
      $plaintext,
      $this->cipher,
      $this->passphrase,
      OPENSSL_RAW_DATA,
      $nonce
    );

    //
    // Now let's pack the IV and the ciphertext together (concatenate).
    //
    if ($encode) {
      return base64_encode($nonce . $ciphertext);
    }

    return $nonce . $ciphertext;
  }

  //---------------------------------------------------------------------------
  /**
   * Decrypt.
   *
   * Decrypts (but does not verify) an encrypted string.
   *
   * @param string $ciphertext Encrypted string
   * @param bool   $encoded    Is base64 encoded string submitted or not?
   *
   * @return string
   */
  protected function decrypt(string $ciphertext, bool $encoded = false): string {
    $nonceSize = openssl_cipher_iv_length($this->cipher);
    $message   = $ciphertext;

    if ($encoded) {
      $message = base64_decode($ciphertext, true);
      if ($message === false) {
        throw new \InvalidArgumentException('Encryption failure');
      }
    }

    $nonce      = mb_substr($message, 0, $nonceSize, '8bit');
    $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

    return openssl_decrypt(
      $ciphertext,
      $this->cipher,
      $this->passphrase,
      OPENSSL_RAW_DATA,
      $nonce
    );
  }
}

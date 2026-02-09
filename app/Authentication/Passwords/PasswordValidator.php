<?php

declare(strict_types=1);

namespace App\Authentication\Passwords;

use App\Entities\User;
use App\Exceptions\AuthException;
use Config\Auth as AuthConfig;

class PasswordValidator
{
  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * @var string
   */
  protected $error;

  /**
   * @var string
   */
  protected $suggestion;

  //---------------------------------------------------------------------------
  /**
   * @param AuthConfig $config
   */
  public function __construct(AuthConfig $config) {
    $this->config = $config;
  }

  //---------------------------------------------------------------------------
  /**
   * Checks a password against all of the Validators specified
   * in `$passwordValidators` setting in Config\Auth.php.
   *
   * @param string    $password  Password to check
   * @param User|null $user      User entity
   *
   * @return bool
   */
  public function check(string $password, ?User $user = null): bool {
    if (is_null($user)) {
      throw AuthException::forNoEntityProvided();
    }

    $password = trim($password);

    if (empty($password)) {
      $this->error = lang('Auth.password.error_empty');
      return false;
    }

    $valid = false;

    foreach ($this->config->passwordValidators as $className) {
      $class = new $className();
      $class->setConfig($this->config);

      if ($class->check($password, $user) === false) {
        $this->error = $class->error();
        $this->suggestion = $class->suggestion();
        $valid = false;
        break;
      }

      $valid = true;
    }

    return $valid;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns the current error, as defined by validator it failed to pass.
   *
   * @return string|null
   */
  public function error(): ?string {
    return $this->error;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns a string with any suggested fix based on the validator it failed
   * to pass.
   *
   * @return string|null
   */
  public function suggestion(): ?string {
    return $this->suggestion;
  }
}

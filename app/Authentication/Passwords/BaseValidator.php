<?php

declare(strict_types=1);

namespace App\Authentication\Passwords;

use Config\Auth as AuthConfig;

class BaseValidator
{
  /**
   * @var AuthConfig
   */
  protected $config;

  //---------------------------------------------------------------------------
  /**
   * Allows for setting a config file on the Validator.
   *
   * @param AuthConfig $config
   *
   * @return self
   */
  public function setConfig(AuthConfig $config): self {
    $this->config = $config;
    return $this;
  }
}

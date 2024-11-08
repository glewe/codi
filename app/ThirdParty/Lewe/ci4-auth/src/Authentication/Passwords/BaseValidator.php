<?php

namespace CI4\Auth\Authentication\Passwords;

use CI4\Auth\Config\Auth as AuthConfig;

class BaseValidator {
  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * --------------------------------------------------------------------
   * Set Config.
   * --------------------------------------------------------------------
   *
   * Allows for setting a config file on the Validator.
   *
   * @param AuthConfig $config
   *
   * @return $this
   */
  public function setConfig($config): self {
    $this->config = $config;
    return $this;
  }
}

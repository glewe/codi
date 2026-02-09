<?php

namespace App\Authentication\Resetters;

use Config\Auth as AuthConfig;
use App\Entities\User;

abstract class BaseResetter {
  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * @var string
   */
  protected $error = '';

  /**
   * --------------------------------------------------------------------------
   * Send.
   * --------------------------------------------------------------------------
   *
   * Sends a reset message to user
   *
   * @param User $user
   *
   * @return bool
   */
  abstract public function send(?User $user = null): bool;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   *
   * Sets the initial config file.
   *
   * @param AuthConfig|null $config
   */
  public function __construct(?AuthConfig $config = null) {
    $this->config = $config ?? config('Auth');
  }

  /**
   * --------------------------------------------------------------------------
   * Set Config.
   * --------------------------------------------------------------------------
   *
   * Allows for changing the config file on the Resetter.
   *
   * @param AuthConfig $config
   *
   * @return $this
   */
  public function setConfig(AuthConfig $config): self {
    $this->config = $config;

    return $this;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Resetter Settings.
   * --------------------------------------------------------------------------
   *
   * Gets a config settings for current Resetter.
   *
   * @return object
   */
  public function getResetterSettings(): object {
    return (object)$this->config->userResetters[static::class];
  }

  /**
   * --------------------------------------------------------------------------
   * Error.
   * --------------------------------------------------------------------------
   *
   * Returns the current error.
   *
   * @return string
   */
  public function error(): string {
    return $this->error;
  }
}

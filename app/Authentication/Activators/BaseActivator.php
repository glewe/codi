<?php

namespace App\Authentication\Activators;

use App\Config\Auth as AuthConfig;
use App\Entities\User;

abstract class BaseActivator {
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
   * Sends an activation message to user
   *
   * @param User $user
   *
   * @return bool
   */
  abstract public function send(User $user = null): bool;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   *
   * Sets the initial config file.
   *
   * @param AuthConfig|null $config
   */
  public function __construct(AuthConfig $config = null) {
    $this->config = $config ?? config('Auth');
  }

  /**
   * --------------------------------------------------------------------------
   * Set Config.
   * --------------------------------------------------------------------------
   *
   * Allows for changing the config file on the Activator.
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
   * Get Activator Settings.
   * --------------------------------------------------------------------------
   *
   * Gets a config settings for current Activator.
   *
   * @return object
   */
  public function getActivatorSettings(): object {
    return (object)$this->config->userActivators[static::class];
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

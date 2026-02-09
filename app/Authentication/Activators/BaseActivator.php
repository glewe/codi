<?php

declare(strict_types=1);

namespace App\Authentication\Activators;

use App\Entities\User;
use Config\Auth as AuthConfig;

abstract class BaseActivator
{
  /**
   * @var AuthConfig
   */
  protected $config;

  /**
   * @var string
   */
  protected $error = '';

  //---------------------------------------------------------------------------
  /**
   * Sets the initial config file.
   *
   * @param AuthConfig|null $config
   */
  public function __construct(?AuthConfig $config = null) {
    $this->config = $config ?? config('Auth');
  }

  //---------------------------------------------------------------------------
  /**
   * Sends an activation message to user.
   *
   * @param User|null $user
   *
   * @return bool
   */
  abstract public function send(?User $user = null): bool;

  //---------------------------------------------------------------------------
  /**
   * Allows for changing the config file on the Activator.
   *
   * @param AuthConfig $config
   *
   * @return self
   */
  public function setConfig(AuthConfig $config): self {
    $this->config = $config;
    return $this;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets a config settings for current Activator.
   *
   * @return object
   */
  public function getActivatorSettings(): object {
    return (object)$this->config->userActivators[static::class];
  }

  //---------------------------------------------------------------------------
  /**
   * Returns the current error.
   *
   * @return string
   */
  public function error(): string {
    return $this->error;
  }
}

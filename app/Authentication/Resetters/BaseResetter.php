<?php

declare(strict_types=1);

namespace App\Authentication\Resetters;

use App\Entities\User;
use Config\Auth as AuthConfig;

abstract class BaseResetter
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
   * Sends a reset message to user.
   *
   * @param User|null $user
   *
   * @return bool
   */
  abstract public function send(?User $user = null): bool;

  //---------------------------------------------------------------------------
  /**
   * Allows for changing the config file on the Resetter.
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
   * Gets a config settings for current Resetter.
   *
   * @return object
   */
  public function getResetterSettings(): object {
    return (object)$this->config->userResetters[static::class];
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

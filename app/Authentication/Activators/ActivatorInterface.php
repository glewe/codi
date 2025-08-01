<?php

namespace App\Authentication\Activators;

use App\Entities\User;

/**
 * Interface ActivatorInterface
 *
 * @package App\Authentication\Activators
 */
interface ActivatorInterface {
  /**
   * --------------------------------------------------------------------------
   * Send.
   * --------------------------------------------------------------------------
   *
   * Send activation message to user
   *
   * @param User $user
   *
   * @return bool
   */
  public function send(User $user = null): bool;

  /**
   * --------------------------------------------------------------------------
   * Error.
   * --------------------------------------------------------------------------
   *
   * Returns the error string that should be displayed to the user.
   *
   * @return string
   */
  public function error(): string;
}

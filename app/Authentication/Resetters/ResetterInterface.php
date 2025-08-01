<?php

namespace App\Authentication\Resetters;

use App\Entities\User;

/**
 * Interface ResetterInterface
 *
 * @package App\Authentication\Resetters
 */
interface ResetterInterface {
  /**
   * --------------------------------------------------------------------------
   * Send.
   * --------------------------------------------------------------------------
   *
   * Send reset message to user
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

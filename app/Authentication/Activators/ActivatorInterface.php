<?php

declare(strict_types=1);

namespace App\Authentication\Activators;

use App\Entities\User;

interface ActivatorInterface
{
  //---------------------------------------------------------------------------
  /**
   * Send activation message to user.
   *
   * @param User|null $user  User object
   *
   * @return bool
   */
  public function send(?User $user = null): bool;

  //---------------------------------------------------------------------------
  /**
   * Returns the error string that should be displayed to the user.
   *
   * @return string
   */
  public function error(): string;
}

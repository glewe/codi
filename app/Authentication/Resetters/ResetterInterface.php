<?php

declare(strict_types=1);

namespace App\Authentication\Resetters;

use App\Entities\User;

interface ResetterInterface
{
  //---------------------------------------------------------------------------
  /**
   * Send reset message to user.
   *
   * @param User|null $user
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

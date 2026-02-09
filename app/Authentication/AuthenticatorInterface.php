<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Entities\User;

interface AuthenticatorInterface
{
  //---------------------------------------------------------------------------
  /**
   * Attempts to validate the credentials and log a user in.
   *
   * @param array     $credentials  User credentials
   * @param bool|null $remember     Should we remember the user (if enabled)
   *
   * @return bool
   */
  public function attempt(array $credentials, ?bool $remember = null): bool;

  //---------------------------------------------------------------------------
  /**
   * Checks to see if the user is logged in or not.
   *
   * @return bool
   */
  public function check(): bool;

  //---------------------------------------------------------------------------
  /**
   * Checks the user's credentials to see if they could authenticate.
   * Unlike `attempt()`, will not log the user into the system.
   *
   * @param array $credentials  User credentials
   * @param bool  $returnUser   Whether to return the user object
   *
   * @return bool|User
   */
  public function validate(array $credentials, bool $returnUser = false): bool|User;

  //---------------------------------------------------------------------------
  /**
   * Returns the User instance for the current logged in user.
   *
   * @return User|null
   */
  public function user(): ?User;
}

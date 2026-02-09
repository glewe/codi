<?php

namespace App\Authentication\Passwords;

use CodeIgniter\Entity\Entity;

/**
 * Interface ValidatorInterface
 *
 * Forms the
 *
 * @package App\Authentication\Passwords
 */
interface ValidatorInterface {
  /**
   * --------------------------------------------------------------------------
   * Check.
   * --------------------------------------------------------------------------
   *
   * Checks the password and returns true/false if it passes muster. Must return
   * either true/false.
   * True means the password passes this test and the password will be passed to
   * any remaining validators.
   * False will immediately stop validation process
   *
   * @param string $password
   * @param Entity $user
   *
   * @return bool
   */
  public function check(string $password, ?Entity $user = null): bool;

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

  /**
   * --------------------------------------------------------------------------
   * Suggestion.
   * --------------------------------------------------------------------------
   *
   * Returns a suggestion that may be displayed to the user to help them choose
   * a better password. The method is required, but a suggestion is optional.
   * May return an empty string instead.
   *
   * @return string
   */
  public function suggestion(): string;
}

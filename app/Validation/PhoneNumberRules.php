<?php

declare(strict_types=1);

namespace App\Validation;

/**
 * PhoneNumberRules
 */
class PhoneNumberRules
{
  //---------------------------------------------------------------------------
  /**
   * Validates a phone number.
   *
   * @param string $str The phone number to validate.
   *
   * @return bool True if valid, false otherwise.
   */
  public function valid_phone(string $str): bool
  {
    //
    // Check here: https://regex101.com/r/j48BZs/2
    //
    return (bool)preg_match('/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3,4}[\s.-]?\d{4}$/', $str);
  }
}


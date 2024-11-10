<?php

namespace App\Validation;

class PhoneNumberRules {

  public function valid_phone(string $str) {
    //
    // Check here: https://regex101.com/r/j48BZs/2
    //
    return preg_match('/^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3,4}[\s.-]?\d{4}$/', $str);
  }
}

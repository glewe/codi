<?php

namespace App\Validation;

class CustomRules {

  /**
   * --------------------------------------------------------------------------
   * Alpha Numeric Punct Comma
   * --------------------------------------------------------------------------
   *
   * Alphanumeric, spaces, and a limited set of punctuation characters.
   * Accepted punctuation characters are: ~ tilde, ! exclamation,
   * # number, $ dollar, % percent, & ampersand, * asterisk, - dash,
   * _ underscore, + plus, = equals, | vertical bar, : colon, . period
   * ~ ! # $ % & * - _ + = | : . ,
   *
   * @param string|null $str
   *
   * @return bool
   *
   * @see https://regex101.com/r/6N8dDY/1
   */
  public function alpha_numeric_punct_comma($str): bool {
    if ($str === null) {
      return false;
    }
    return preg_match('/\A[A-Z0-9 ~!#$%\&\*\-_+=|:.,]+\z/i', $str) === 1;
  }

  /**
   * --------------------------------------------------------------------------
   * Ctype Graph.
   * --------------------------------------------------------------------------
   *
   * Only printable characters
   *
   * @param string|null $str
   *
   * @return bool
   */
  public function ctype_graph($str): bool {
    if ($str === null) {
      return false;
    }
    return ctype_graph($str);
  }

  /**
   * --------------------------------------------------------------------------
   * Exact Value.
   * --------------------------------------------------------------------------
   *
   * Validation of an exact value
   *
   * @param string|null $str
   *
   * @return bool
   */
  public function exact_value(string $str, string $params, &$error = null): bool {
    //
    // Split the params. First is the exact value.
    //
    $params = explode(',', $params);
    $exact = $params[0];
    if ($str === $exact) {
      return true;
    } else {
      $error = lang('Validation.exact_value', [ $exact ]);
      return false;
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Valid GA4.
   * --------------------------------------------------------------------------
   *
   * Validation of a Google Analytics 4 ID
   *
   * @param string|null $str
   *
   * @return bool
   */
  public function valid_ga4(string $str, &$error = null) {
    //
    // Check for a valid Google Analytics 4 tag
    //
    if (preg_match('/^G-[A-Z0-9]{10,20}$/', $str)) {
      return true;
    } else {
      $error = lang('Validation.valid_ga4');
      return false;
    }
  }
}

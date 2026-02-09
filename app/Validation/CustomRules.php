<?php

declare(strict_types=1);

namespace App\Validation;

/**
 * CustomRules
 */
class CustomRules
{
  //---------------------------------------------------------------------------
  /**
   * Alphanumeric, spaces, and a limited set of punctuation characters.
   * Accepted punctuation characters are: ~ tilde, ! exclamation,
   * # number, $ dollar, % percent, & ampersand, * asterisk, - dash,
   * _ underscore, + plus, = equals, | vertical bar, : colon, . period
   * ~ ! # $ % & * - _ + = | : . ,
   *
   * @param string|null $str String to validate.
   *
   * @return bool True if valid, false otherwise.
   *
   * @see https://regex101.com/r/6N8dDY/1
   */
  public function alpha_numeric_punct_comma(?string $str): bool
  {
    if ($str === null) {
      return false;
    }

    return (bool)preg_match('/\A[A-Z0-9 ~!#$%\&\*\-_+=|:.,]+\z/i', $str);
  }

  //---------------------------------------------------------------------------
  /**
   * Only printable characters.
   *
   * @param string|null $str String to validate.
   *
   * @return bool True if valid, false otherwise.
   */
  public function ctype_graph(?string $str): bool
  {
    if ($str === null) {
      return false;
    }

    return ctype_graph($str);
  }

  //---------------------------------------------------------------------------
  /**
   * Validation of an exact value.
   *
   * @param string      $str    String to validate.
   * @param string      $params Exact value parameter.
   * @param string|null $error  Error message.
   *
   * @return bool True if successful, false otherwise.
   */
  public function exact_value(string $str, string $params, ?string &$error = null): bool
  {
    //
    // Split the params. First is the exact value.
    //
    $paramsArr = explode(',', $params);
    $exact     = $paramsArr[0];

    if ($str === $exact) {
      return true;
    }

    $error = (string)str_replace('{0}', $exact, lang('Validation.exact_value'));

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Validation of a Google Analytics 4 ID.
   *
   * @param string      $str   String to validate.
   * @param string|null $error Error message.
   *
   * @return bool True if successful, false otherwise.
   */
  public function valid_ga4(string $str, ?string &$error = null): bool
  {
    //
    // Check for a valid Google Analytics 4 tag
    //
    if ((bool)preg_match('/^G-[A-Z0-9]{10,20}$/', $str)) {
      return true;
    }

    $error = (string)lang('Validation.valid_ga4');

    return false;
  }
}



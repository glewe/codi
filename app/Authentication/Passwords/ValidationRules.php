<?php

namespace App\Authentication\Passwords;

use App\Entities\User;

/**
 * Class ValidationRules
 *
 * Provides auth-related validation rules for CodeIgniter 4.
 *
 * To use, add this class to Config/Validation.php, in the
 * $rulesets array.
 *
 * @package App\Authentication\Passwords
 */
class ValidationRules {
  /**
   * --------------------------------------------------------------------------
   * Strong Password.
   * --------------------------------------------------------------------------
   *
   * A validation helper method to check if the passed in password will pass
   * all of the validators currently defined.
   *
   * Handy for use in validation, but you will get a slightlybetter security
   * if this is done manually, since you can personalize based on a specific
   * user at that point.
   *
   * @param string $value  Field value
   * @param string $error1 Error that will be returned (for call without validation data array)
   * @param array  $data   Validation data array
   * @param string $error2 Error that will be returned (for call with validation data array)
   *
   * @return bool
   */
  public function strong_password(string $value, ?string &$error1 = null, array $data = [], ?string &$error2 = null): bool {
    $checker = service('passwords');

    if (function_exists('user') && user()) {
      $user = user();
    } else {
      $user = empty($data) ? $this->buildUserFromRequest() : $this->buildUserFromData($data);
    }

    $result = $checker->check($value, $user);

    if ($result === false) {
      if (empty($data)) {
        $error1 = $checker->error();
      } else {
        $error2 = $checker->error();
      }
    }

    return $result;
  }

  /**
   * ---------------------------------------------------------------------------
   * Lower Alpha Dash Dot.
   * ---------------------------------------------------------------------------
   *
   * Specific validator for permission names. Only lower case alpha characters
   * and dots.
   *
   * @param string $str   - Field value
   * @param string $error - Error that will be returned (for call without validation data array)
   *
   * @return bool
   */
  public function lower_alpha_dash_dot($str, ?string &$error = null): bool {
    if ($str === null) {
      return false;
    }

    if (!preg_match('/\A[a-z.]+\z/', $str)) {
      $error = (string)lang('Auth.permission.error_name');
      return false;
    }

    return true;
  }

  /**
   * --------------------------------------------------------------------------
   * Build User from Request.
   * --------------------------------------------------------------------------
   *
   * Builds a new user instance from the global request.
   *
   * @return User
   */
  protected function buildUserFromRequest(): User {
    $fields = $this->prepareValidFields();

    $data = array_filter(service('request')->getPost($fields));

    return new User($data);
  }

  /**
   * --------------------------------------------------------------------------
   * Build User from Data.
   * --------------------------------------------------------------------------
   *
   * Builds a new user instance from assigned data..
   *
   * @param array $data Assigned data
   *
   * @return User
   */
  protected function buildUserFromData(array $data = []): User {
    $fields = $this->prepareValidFields();

    $data = array_intersect_key($data, array_fill_keys($fields, null));

    return new User($data);
  }

  /**
   * --------------------------------------------------------------------------
   * Prepare Valid Fields.
   * --------------------------------------------------------------------------
   *
   * Prepare valid user fields
   *
   * @return array
   */
  protected function prepareValidFields(): array {
    $config = config('Auth');
    $fields = array_merge($config->validFields, $config->personalFields);
    $fields[] = 'password';

    return $fields;
  }
}

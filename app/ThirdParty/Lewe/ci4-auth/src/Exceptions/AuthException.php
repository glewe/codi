<?php

namespace CI4\Auth\Exceptions;

use CodeIgniter\HTTP\Exceptions\HTTPException;

class AuthException extends \DomainException implements ExceptionInterface {

  /**
   * --------------------------------------------------------------------------
   * Invalid Model.
   * --------------------------------------------------------------------------
   *
   * For when the model is invalid.
   *
   * @return AuthException
   */
  public static function forInvalidModel(string $model) {
    return new self(lang('Auth.exception.invalid_model', [ $model ]), 500);
  }

  /**
   * --------------------------------------------------------------------------
   * Too Many Credentials.
   * --------------------------------------------------------------------------
   *
   * For when the developer attempts to authenticate with too many credentials.
   *
   * @return AuthException
   */
  public static function forTooManyCredentials() {
    return new self(lang('Auth.exception.too_many_credentials'), 500);
  }

  /**
   * --------------------------------------------------------------------------
   * Invalid Fields.
   * --------------------------------------------------------------------------
   *
   * For when the developer passed invalid field along with 'password' when
   * attempting to validate a user.
   *
   * @param string $key
   *
   * @return AuthException
   */
  public static function forInvalidFields(string $key) {
    return new self(lang('Auth.exception.invalid_fields', [ $key ]), 500);
  }

  /**
   * --------------------------------------------------------------------------
   * Unset Password Length.
   * --------------------------------------------------------------------------
   *
   * Fires when no minimumPasswordLength has been set in the Auth config file.
   *
   * @return AuthException
   */
  public static function forUnsetPasswordLength() {
    return new self(lang('Auth.exception.password_length_not_set'), 500);
  }

  /**
   * --------------------------------------------------------------------------
   * HIBP Curl Fail.
   * --------------------------------------------------------------------------
   *
   * When the cURL request (to Have I Been Pwned) in PwnedValidator throws a
   * HTTPException it is re-thrown as this one.
   *
   * @return AuthException
   */
  public static function forHIBPCurlFail(HTTPException $e) {
    return new self($e->getMessage(), $e->getCode(), $e);
  }

  /**
   * --------------------------------------------------------------------------
   * No Entity Provided.
   * --------------------------------------------------------------------------
   *
   * When no User Entity is passed into PasswordValidator::check()
   *
   * @return AuthException
   */
  public static function forNoEntityProvided() {
    return new self(lang('Auth.exception.no_user_entity'), 500);
  }
}

<?php

declare(strict_types=1);

namespace App\Exceptions;

class LicException extends \DomainException implements ExceptionInterface
{
  //---------------------------------------------------------------------------
  /**
   * License Blocked.
   *
   * @return LicException
   */
  public static function forLicenseBlocked(): self {
    return new self(lang('Lic.exception.blocked'), 500);
  }

  //---------------------------------------------------------------------------
  /**
   * License Expired.
   *
   * @return LicException
   */
  public static function forLicenseExpired(): self {
    return new self(lang('Lic.exception.bexpired'), 500);
  }

  //---------------------------------------------------------------------------
  /**
   * License Invalid.
   *
   * @return LicException
   */
  public static function forLicenseInvalid(): self {
    return new self(lang('Lic.exception.invalid'), 500);
  }

  //---------------------------------------------------------------------------
  /**
   * License Pending.
   *
   * @return LicException
   */
  public static function forLicensePending(): self {
    return new self(lang('Lic.exception.pending'), 500);
  }

  //---------------------------------------------------------------------------
  /**
   * License Unregistered.
   *
   * @return LicException
   */
  public static function forLicenseUnregistered(): self {
    return new self(lang('Lic.exception.unregistered'), 500);
  }
}

<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;
use DateTime;

/**
 * LoginModel
 */
class LoginModel extends Model
{
  protected $table              = 'logins';
  protected $primaryKey         = 'id';
  protected $returnType         = 'object';
  protected $useSoftDeletes     = false;
  protected $allowedFields      = [
    'ip_address',
    'email',
    'user_id',
    'date',
    'success',
    'info',
  ];
  protected $useTimestamps      = false;
  protected $validationRules    = [
    'ip_address' => 'required',
    'email'      => 'required',
    'user_id'    => 'permit_empty|integer',
    'date'       => 'required|valid_date',
  ];
  protected $validationMessages = [];
  protected $skipValidation     = false;

  //---------------------------------------------------------------------------
  /**
   * Stores a remember-me token for the user.
   *
   * @param int    $userID    User ID.
   * @param string $selector  Selector string.
   * @param string $validator Validator string.
   * @param string $expires   Expiration date string.
   *
   * @return bool True if successful, false otherwise.
   */
  public function rememberUser(int $userID, string $selector, string $validator, string $expires): bool {
    $expiresDate = new DateTime($expires);

    return (bool) $this->db->table('tokens')->insert([
      'user_id'         => $userID,
      'selector'        => $selector,
      'hashedValidator' => $validator,
      'expires'         => $expiresDate->format('Y-m-d H:i:s'),
    ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Returns the remember-me token info for a given selector.
   *
   * @param string $selector Selector string.
   *
   * @return object|null Token info object or null if not found.
   */
  public function getRememberToken(string $selector): ?object {
    return $this->db->table('tokens')
      ->where('selector', $selector)
      ->get()
      ->getRow();
  }

  //---------------------------------------------------------------------------
  /**
   * Updates the validator for a given selector.
   *
   * @param string $selector  Selector string.
   * @param string $validator Validator string.
   *
   * @return bool True if successful, false otherwise.
   */
  public function updateRememberValidator(string $selector, string $validator): bool {
    return (bool) $this->db->table('tokens')
      ->where('selector', $selector)
      ->update([
        'hashedValidator' => hash('sha256', $validator),
        'expires'         => (new DateTime())->modify('+' . (string) config('Auth')->rememberLength . ' seconds')->format('Y-m-d H:i:s'),
      ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Removes all persistent login tokens for a single user.
   *
   * @param int $id User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function purgeRememberTokens(int $id): bool {
    return (bool) $this->builder('tokens')->where(['user_id' => $id])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Purges the 'tokens' table of any expired records.
   *
   * @return void
   */
  public function purgeOldRememberTokens(): void {
    $config = config('Auth');

    if (!$config->allowRemembering) {
      return;
    }

    $this->db->table('tokens')->where('expires <=', date('Y-m-d H:i:s'))->delete();
  }
}


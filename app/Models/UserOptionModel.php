<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserOptionModel
 */
class UserOptionModel extends Model
{
  protected $table          = 'users_options';
  protected $primaryKey     = 'id';
  protected $useTimestamps  = true;
  protected $skipValidation = true;

  //---------------------------------------------------------------------------
  /**
   * Deletes a given option record.
   *
   * @param array $data Data containing 'user_id' and 'option'.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteOption(array $data): bool {
    $conditions = [
      'user_id' => $data['user_id'] ?? 0,
      'option'  => $data['option'] ?? '',
    ];

    return (bool) $this->builder($this->table)->where($conditions)->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes all options for a given user.
   *
   * @param int $userId User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteOptionsForUser(int $userId): bool {
    $conditions = [
      'user_id' => $userId,
    ];

    return (bool) $this->builder($this->table)->where($conditions)->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Gets the user avatar.
   *
   * @param int|null $id User ID.
   *
   * @return string Avatar filename.
   */
  public function getAvatar(?int $id = null): string {
    if ($id === null) {
      return 'default_male.png';
    }

    $found = $this->db->table($this->table)
      ->select('value')
      ->where([
        'user_id' => $id,
        'option'  => 'avatar',
      ])
      ->get()
      ->getRow();

    if ($found) {
      return (string) $found->value;
    }

    return 'default_male.png';
  }

  //---------------------------------------------------------------------------
  /**
   * Reads the value of a given option and user.
   *
   * @param array $data Data containing 'user_id' and 'option'.
   *
   * @return mixed Option value or false if not found.
   */
  public function getOption(array $data): mixed {
    $found = $this->db->table($this->table)
      ->select('value')
      ->where([
        'user_id' => $data['user_id'] ?? 0,
        'option'  => $data['option'] ?? '',
      ])
      ->get()
      ->getRow();

    if ($found) {
      return $found->value;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all options that a user has set.
   *
   * @param int $userId User ID.
   *
   * @return array Array of options [option => value].
   */
  public function getOptionsForUser(int $userId): array {
    $optionRecords = $this->builder()
      ->select($this->table . '.option, ' . $this->table . '.value')
      ->where('user_id', $userId)
      ->get()->getResultArray();

    $options = [];

    foreach ($optionRecords as $record) {
      $options[(string) $record['option']] = $record['value'];
    }

    return $options;
  }

  //---------------------------------------------------------------------------
  /**
   * Saves (creates or updates) an option for a user.
   *
   * @param array $data Data containing 'user_id', 'option', and 'value'.
   *
   * @return bool True if successful, false otherwise.
   */
  public function saveOption(array $data): bool {
    $conditions = [
      'user_id' => $data['user_id'] ?? 0,
      'option'  => $data['option'] ?? '',
    ];

    $row = $this->db->table($this->table)->where($conditions)->get()->getRow();

    if (isset($row)) {
      return (bool) $this->db->table($this->table)
        ->where($conditions)
        ->update(['value' => ($data['value'] ?? '')]);
    }

    return (bool) $this->db->table($this->table)->insert($data);
  }
}


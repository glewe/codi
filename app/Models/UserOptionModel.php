<?php

namespace App\Models;

use CodeIgniter\Model;

class UserOptionModel extends Model {
  protected $table = 'users_options';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $skipValidation = true;

  /**
   * --------------------------------------------------------------------------
   * Delete Option.
   * --------------------------------------------------------------------------
   *
   * Deletes a given option record.
   *
   * @param array $data ['user_id', 'option']
   *
   * @return bool
   */
  public function deleteOption($data): bool {
    $conditions = array(
      'user_id' => $data['user_id'],
      'option' => $data['option']
    );
    return $this->builder($this->table)->where($conditions)->delete();
  }

  /**
   * --------------------------------------------------------------------------
   * Delete Options For User.
   * --------------------------------------------------------------------------
   *
   * Deletes all options for a given user.
   *
   * @param int $userId
   *
   * @return bool
   */
  public function deleteOptionsForUser(int $userId): bool {
    $conditions = array(
      'user_id' => $userId,
    );
    return $this->builder($this->table)->where($conditions)->delete();
  }

  /**
   * --------------------------------------------------------------------------
   * Get Avatar.
   * --------------------------------------------------------------------------
   *
   * Gets the user avatar.
   *
   * @param int $id User ID
   *
   * @return string
   */
  public function getAvatar($id = null): string {
    $found = $this->db->table($this->table)
      ->select('value')
      ->where(array(
        'user_id' => $id,
        'option' => 'avatar'
      ))
      ->get()
      ->getRow();

    if ($found) {
      return $found->value;
    }
    return 'default_male.png';
  }

  /**
   * --------------------------------------------------------------------------
   * Get Option.
   * --------------------------------------------------------------------------
   *
   * Reads the value of a given option and user.
   *
   * @param array $data ['user_id', 'option']
   *
   * @return mixed
   */
  public function getOption($data): mixed {
    $found = $this->db->table($this->table)
      ->select('value')
      ->where(array(
        'user_id' => $data['user_id'],
        'option' => $data['option']
      ))
      ->get()
      ->getRow();

    if ($found) {
      return $found->value;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Options For User.
   * --------------------------------------------------------------------------
   *
   * Returns an array of all options that a user has set.
   *
   * @param int $userId
   *
   * @return array
   */
  public function getOptionsForUser(int $userId): array {
    //
    // Read all records for this user.
    //
    $optionRecords = $this->builder()
      ->select($this->table . '.option, ' . $this->table . '.value')
      ->where('user_id', $userId)
      ->get()->getResultArray();
    //
    // Build an options array and return it.
    //
    $options = [];
    foreach ($optionRecords as $record) {
      $options[$record['option']] = $record['value'];
    }
    return $options;
  }

  /**
   * --------------------------------------------------------------------------
   * Save Option.
   * --------------------------------------------------------------------------
   *
   * Saves (create/insert) an option for a user.
   *
   * @param array $data ['user_id', 'option', 'value']
   *
   * @return bool
   */
  public function saveOption($data): bool {
    $conditions = array(
      'user_id' => $data['user_id'],
      'option' => $data['option']
    );

    $row = $this->db->table($this->table)->where($conditions)->get()->getRow();

    if (isset($row)) {
      //
      // Record exists. Update.
      //
      return $this->db->table($this->table)
        ->where($conditions)
        ->update([ 'value' => $data['value'] ]);
    } else {
      //
      // Record does not exist. Insert.
      //
      return $this->db->table($this->table)->insert($data);
    }
  }
}

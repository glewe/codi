<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * LogModel
 */
class LogModel extends Model
{
  protected $table          = 'log';
  protected $primaryKey     = 'id';
  protected $useTimestamps  = true;
  protected $skipValidation = true;

  //---------------------------------------------------------------------------
  /**
   * Creates a new log entry.
   *
   * @param array $data Array with record data.
   *
   * @return int Insert ID or 0 on failure.
   */
  public function logEvent(array $data): int {
    $result = $this->db->table($this->table)->insert($data);

    if ($result) {
      return (int) $this->db->insertID();
    }

    return 0;
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes all records.
   *
   * @return bool True on success, false on failure.
   */
  public function deleteAll(): bool {
    return (bool) $this->db->table($this->table)->truncate();
  }

  //---------------------------------------------------------------------------
  /**
   * Gets the record for a given ID.
   *
   * @param int|string $id Record ID.
   *
   * @return object|bool Record object or false if not found.
   */
  public function getEvent(int|string $id): object|bool {
    if ($row = $this->db->table($this->table)->where(['id' => $id])->get()->getRow()) {
      return $row;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all records for given event type.
   *
   * @param string $type Event type.
   *
   * @return array Array of records.
   */
  public function getTypeEvents(string $type): array {
    return $this->builder()->select($this->table . '.*')->where('type', $type)->get()->getResultArray();
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all records for given username.
   *
   * @param string $user Username.
   *
   * @return array Array of records.
   */
  public function getUserEvents(string $user): array {
    return $this->builder()->select($this->table . '.*')->where('user', $user)->get()->getResultArray();
  }

  //---------------------------------------------------------------------------
  /**
   * Saves (create or update) a record.
   *
   * @param int|string $id   Record ID.
   * @param array      $data Array with record data.
   *
   * @return bool True on success, false on failure.
   */
  public function saveRecord(int|string $id, array $data): bool {
    $row = $this->db->table($this->table)->where(['id' => $id])->get()->getRow();

    if (isset($row)) {
      return (bool) $this->db->table($this->table)->where(['id' => $id])->update($data);
    }

    return (bool) $this->db->table($this->table)->insert($data);
  }
}


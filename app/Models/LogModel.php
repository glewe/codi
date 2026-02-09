<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model {

  protected $table = 'log';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $skipValidation = true;

  /**
   * --------------------------------------------------------------------------
   * Log Event.
   * --------------------------------------------------------------------------
   *
   * Creates a new day type.
   *
   * @param array $data Array with record data
   *
   * @return int
   */
  public function logEvent($data): int {
    $result = $this->db->table($this->table)->insert($data);
    if ($result) {
      return $this->db->insertID();
    }
    return 0;
  }

  /**
   * --------------------------------------------------------------------------
   * Delete All.
   * --------------------------------------------------------------------------
   *
   * Deletes all records.
   *
   * @return mixed
   */
  public function deleteAll(): mixed {
    return $this->db->table($this->table)->truncate();
  }

  /**
   * --------------------------------------------------------------------------
   * Get Event.
   * --------------------------------------------------------------------------
   *
   * Gets the record for a given ID.
   *
   * @param string $id Record ID
   *
   * @return mixed
   */
  public function getEvent($id): mixed {
    if ($row = $this->db->table($this->table)->where([ 'id' => $id ])->get()->getRow()) {
      return $row;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Type Events.
   * --------------------------------------------------------------------------
   *
   * Returns an array of all records for given event type.
   *
   * @param string $type Event type
   * @return array
   */
  public function getTypeEvents($type): array {
    //
    // Read all records for this user.
    //
    return $this->builder()->select($this->table . '.*')->where('type', $type)->get()->getResultArray();
  }

  /**
   * --------------------------------------------------------------------------
   * Get User Events.
   * --------------------------------------------------------------------------
   *
   * Returns an array of all records for given event type.
   *
   * @param string $user Username
   * @return array
   */
  public function getUserEvents($user): array {
    //
    // Read all records for this user.
    //
    return $this->builder()->select($this->table . '.*')->where('user', $user)->get()->getResultArray();
  }

  /**
   * --------------------------------------------------------------------------
   * Save Record.
   * --------------------------------------------------------------------------
   *
   * Saves (create/insert) a record.
   *
   * @param array $data Array with record data
   *
   * @return bool
   */
  public function saveRecord($id, $data): bool {
    $row = $this->db->table($this->table)->where([ 'id' => $id ])->get()->getRow();
    if (isset($row)) {
      //
      // Record exists. Update.
      //
      return $this->db->table($this->table)->where([ 'id' => $id ])->update($data);
    } else {
      //
      // Record does not exist. Insert.
      //
      return $this->db->table($this->table)->insert($data);
    }
  }
}

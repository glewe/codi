<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model {

  protected $table = 'settings';
  protected $primaryKey = 'id';
  protected $useTimestamps = true;
  protected $skipValidation = true;

  /**
   * --------------------------------------------------------------------------
   * Delete Setting.
   * --------------------------------------------------------------------------
   *
   * Deletes a given setting record.
   *
   * @param string $setting
   *
   * @return bool
   */
  public function deleteSetting($key): bool {
    $conditions = array(
      'key' => $key
    );
    return $this->builder($this->table)->where($conditions)->delete();
  }

  /**
   * --------------------------------------------------------------------------
   * Get Setting.
   * --------------------------------------------------------------------------
   *
   * Reads the value of a given setting.
   *
   * @param string $key
   *
   * @return mixed
   */
  public function getSetting($key): mixed {
    $found = $this->db->table($this->table)
      ->select('value')
      ->where(array(
        'key' => $key
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
   * Get Settings.
   * --------------------------------------------------------------------------
   *
   * Reads all settings into an array and returns it.
   *
   * @return array
   */
  public function getSettings(): array {
    $settingsRows = $this->orderBy('key', 'asc')->findAll();
    $settings = [];
    foreach ($settingsRows as $row) {
      $settings[$row['key']] = $row['value'];
    }
    return $settings;
  }

  /**
   * --------------------------------------------------------------------------
   * Save Setting.
   * --------------------------------------------------------------------------
   *
   * Saves (create/insert) a setting.
   *
   * @param array $data ['key' => 'myKey', 'value' => 'myValue]
   *
   * @return bool
   */
  public function saveSetting($data): bool {
    $row = $this->db->table($this->table)->where([ 'key' => $data['key'] ])->get()->getRow();
    if (isset($row)) {
      //
      // Record exists. Update.
      //
      return $this->db->table($this->table)->where([ 'key' => $data['key'] ])->update([ 'value' => $data['value'] ]);
    } else {
      //
      // Record does not exist. Insert.
      //
      return $this->db->table($this->table)->insert($data);
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Save Settings.
   * --------------------------------------------------------------------------
   *
   * Saves (create/insert) several settings.
   *
   * @param array $data [
   *   ['key' => 'myKey', 'value' => 'myValue],
   *   ['key' => 'myKey', 'value' => 'myValue],
   *   ...
   * ]
   */
  public function saveSettings($data): void {
    foreach ($data as $setting) {
      $this->saveSetting($setting);
    }
  }
}

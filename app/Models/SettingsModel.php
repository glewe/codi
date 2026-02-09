<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * SettingsModel
 */
class SettingsModel extends Model
{
  protected $table          = 'settings';
  protected $primaryKey     = 'id';
  protected $useTimestamps  = true;
  protected $skipValidation = true;

  //---------------------------------------------------------------------------
  /**
   * Deletes a given setting record.
   *
   * @param string $key Setting key.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteSetting(string $key): bool {
    return (bool) $this->builder($this->table)->where(['key' => $key])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Reads the value of a given setting.
   *
   * @param string $key Setting key.
   *
   * @return mixed Setting value or false if not found.
   */
  public function getSetting(string $key): mixed {
    $found = $this->db->table($this->table)
      ->select('value')
      ->where(['key' => $key])
      ->get()
      ->getRow();

    if ($found) {
      return $found->value;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Reads all settings into an associative array.
   *
   * @return array Array of settings [key => value].
   */
  public function getSettings(): array {
    /** @var array $settingsRows */
    $settingsRows = $this->orderBy('key', 'asc')->findAll();
    $settings     = [];

    foreach ($settingsRows as $row) {
      $settings[(string) $row['key']] = $row['value'];
    }

    return $settings;
  }

  //---------------------------------------------------------------------------
  /**
   * Saves (creates or updates) a setting.
   *
   * @param array $data Setting data ['key' => '...', 'value' => '...'].
   *
   * @return bool True if successful, false otherwise.
   */
  public function saveSetting(array $data): bool {
    $row = $this->db->table($this->table)->where(['key' => ($data['key'] ?? '')])->get()->getRow();

    if (isset($row)) {
      return (bool) $this->db->table($this->table)->where(['key' => ($data['key'] ?? '')])->update(['value' => ($data['value'] ?? '')]);
    }

    return (bool) $this->db->table($this->table)->insert($data);
  }

  //---------------------------------------------------------------------------
  /**
   * Saves several settings.
   *
   * @param array $data Array of setting data arrays.
   *
   * @return void
   */
  public function saveSettings(array $data): void {
    foreach ($data as $setting) {
      if (is_array($setting)) {
        $this->saveSetting($setting);
      }
    }
  }
}


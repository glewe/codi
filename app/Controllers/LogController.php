<?php

namespace App\Controllers;

use App\Libraries\Bootstrap;
use App\Models\LogModel;
use Config\Validation;

class LogController extends BaseController {
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var Bootstrap
   */
  protected $bs;

  /**
   * @var array
   */
  protected $formFields = [];

  /**
   * @var LogModel
   */
  protected $LOG;

  /**
   * @var string Event type used in log entries from this controller.
   */
  protected $logType;

  /**
   * @var array
   */
  protected $logTypes;

  /**
   * @var \CodeIgniter\Validation\Validation
   */
  protected $validation;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct() {
    $this->bs = new Bootstrap();
    $this->LOG = model(LogModel::class);
    $this->validation = service('validation');
    $this->logType = 'Log';
    $this->logTypes = config('Config\App')->logTypes;

    foreach ($this->logTypes as $logType) {
      $this->formFields['filters'][] = [ 'swi_log' . $logType => [ 'type' => 'switch', 'subtype' => '', 'mandatory' => false, 'value' => '', 'items' => [] ] ];
      $this->formFields['colors'][] = [ 'txt_logColor' . $logType => [ 'type' => 'color', 'subtype' => '', 'mandatory' => false, 'value' => '', 'items' => [] ] ];
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Log.
   * --------------------------------------------------------------------------
   *
   * Shows all absence records.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function log(): \CodeIgniter\HTTP\RedirectResponse|string {

    $this->checkDefaults();

    $allRecords = $this->LOG->orderBy('created_at', 'desc')->findAll();
    $fields = array();

    $data = [
      'page' => lang('Log.pageTitle'),
      'events' => $allRecords,
      'config' => $this->config,
      'settings' => $this->settings,
      'formFields' => $this->formFields,
    ];

    if ($this->request->withMethod('POST')) {
      //
      // A form was submitted. Let's see what it was...
      //
      if (array_key_exists('btn_clear_log', $this->request->getPost())) {
        // ,-----------,
        // | Clear Log |
        // '-----------'
        $this->LOG->deleteAll();
        logEvent(
          [
            'type' => $this->logType,
            'event' => lang('Log.delete_success'),
            'user' => user_username(),
            'ip' => $this->request->getIPAddress(),
          ]
        );
        return redirect()->route('log')->with('success', lang('Log.delete_success'));
      } elseif (array_key_exists('btn_save_settings', $this->request->getPost())) {
        // ,---------------,
        // | Save Settings |
        // '---------------'
        //
        // Get switch values
        //
        foreach ($this->logTypes as $logType) {
          if ($this->request->getPost('swi_log' . $logType)) {
            $fields[] = [ 'key' => 'log' . $logType, 'value' => '1' ];
          } else {
            $fields[] = [ 'key' => 'log' . $logType, 'value' => '0' ];
          }
          if ($this->request->getPost('txt_logColor' . $logType)) {
            $fields[] = [ 'key' => 'logColor' . $logType, 'value' => htmlspecialchars($this->request->getPost('txt_logColor' . $logType)) ];
          } else {
            $fields[] = [ 'key' => 'logColor' . $logType, 'value' => '' ];
          }
        }
        $this->settings->saveSettings($fields);
        logEvent(
          [
            'type' => $this->logType,
            'event' => lang('Log.save_success'),
            'user' => user_username(),
            'ip' => $this->request->getIPAddress(),
          ]
        );
        return redirect()->route('log')->with('success', lang('Log.save_success'));
      }
    }
    return $this->_render($this->config->views['log'], $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Check Defaults.
   * --------------------------------------------------------------------------
   *
   * Check for missing defaults and save if not exist.
   *
   * @return array
   */
  public function checkDefaults(): array {
    //
    // Get all records and compress them in an array
    //
    $settings = $this->settings->getSettings();
    //
    // Check defaults and save if not exist
    //
    foreach (config('Config\App')->logTypes as $logType) {
      if (!array_key_exists('log' . $logType, $settings)) {
        $this->settings->saveSetting([ 'key' => 'log' . $logType, 'value' => '1' ]);
      }
      if (!array_key_exists('logColor' . $logType, $settings)) {
        $this->settings->saveSetting([ 'key' => 'logColor' . $logType, 'value' => '' ]);
      }
    }
    //
    // Get all records again, compress and return
    //
    return $this->settings->getSettings();
  }
}

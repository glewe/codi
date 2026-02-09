<?php

declare(strict_types=1);

namespace App\Controllers;

use CodeIgniter\Validation\ValidationInterface;

class OptionsController extends BaseController
{
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var string Log type used in log entries from this controller.
   */
  protected string $logType;

  /**
   * @var array<string, array>
   */
  protected array $formFields = [];

  /**
   * @var ValidationInterface
   */
  protected ValidationInterface $validation;

  /**
   * @var string
   */
  protected string $pageTitle;

  //---------------------------------------------------------------------------
  /**
   * Constructor.
   */
  public function __construct() {
    $this->validation = service('validation');
    $this->logType    = 'Options';
    $this->pageTitle  = lang('Page.options') ?? 'Options';

    $this->formFields = [
      'display' => [
        'swi_dummySwitch' => [
          'type'      => 'switch',
          'subtype'   => '',
          'mandatory' => false,
          'value'     => '',
          'items'     => [],
        ],
      ],
    ];
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the settings edit page.
   *
   * @return string
   */
  public function edit(): string {
    $settings = $this->checkDefaults();

    //
    // Fill formFields array with values from database
    //
    foreach ($this->formFields as $tabKey => $tab) {
      foreach ($tab as $key => $setting) {
        $pieces    = explode('_', $key);
        $fieldName = $pieces[1];
        if (array_key_exists($fieldName, $settings)) {
          $this->formFields[$tabKey][$key]['value'] = $settings[$fieldName];
        } else {
          $this->formFields[$tabKey][$key]['value'] = '0';
        }
      }
    }

    return $this->_render(
      $this->config->views['options'],
      [
        'page'       => $this->pageTitle,
        'config'     => $this->config,
        'settings'   => $settings,
        'formFields' => $this->formFields,
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Saves the options page.
   *
   * @param int|null $id
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function editDo(?int $id = null): \CodeIgniter\HTTP\RedirectResponse {
    $form = [];

    //
    // Set basic validation rules
    //
    $validationRules = [
      'txt_todayBorderColor' => ['label' => lang('Options.todayBorderColor'), 'rules' => 'max_length[8]'],
      'txt_todayBorderWidth' => ['label' => lang('Options.todayBorderColor'), 'rules' => 'max_length[2]'],
    ];

    //
    // Get form fields for validation
    //
    foreach ($this->formFields as $tab => $settings) {
      foreach ($this->formFields[$tab] as $key => $option) {
        $form[$key] = $this->request->getPost($key, FILTER_SANITIZE_STRING);
      }
    }

    //
    // Validate input
    //
    $this->validation->setRules($validationRules);
    if (!$this->validation->run($form)) {
      //
      // Return validation error
      //
      return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    } else {
      //
      // Loop through tabs and save settings
      //
      foreach ($this->formFields as $tab) {
        foreach ($tab as $key => $option) {
          $pieces    = explode('_', $key);
          $fieldType = $pieces[0];
          $fieldName = $pieces[1];
          if ($fieldType === 'swi') {
            if ($form[$key]) {
              $this->settings->saveSetting(['key' => $fieldName, 'value' => '1']);
            } else {
              $this->settings->saveSetting(['key' => $fieldName, 'value' => '0']);
            }
          } else {
            $this->settings->saveSetting(['key' => $fieldName, 'value' => $form[$key]]);
          }
        }
      }

      //
      // Success! Go back from where the user came.
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => lang('Options.update_success'),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', lang('Options.update_success'));
    }
  }

  //---------------------------------------------------------------------------
  /**
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
    if (!array_key_exists('todayBorderColor', $settings)) {
      $this->settings->saveSetting(['key' => 'todayBorderColor', 'value' => '#ffb300']);
    }
    if (!array_key_exists('todayBorderWidth', $settings)) {
      $this->settings->saveSetting(['key' => 'todayBorderWidth', 'value' => '2']);
    }
    if (!array_key_exists('showAvatars', $settings)) {
      $this->settings->saveSetting(['key' => 'showAvatars', 'value' => '0']);
    }
    if (!array_key_exists('showRoleIcons', $settings)) {
      $this->settings->saveSetting(['key' => 'showRoleIcons', 'value' => '0']);
    }
    //
    // Get all records again, compress and return
    //
    return $this->settings->getSettings();
  }
}

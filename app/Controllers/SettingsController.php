<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\LogModel;
use CodeIgniter\Session\Session;
use Config\App as AppConfig;
use Config\Validation;
use DateTimeZone;

class SettingsController extends BaseController {
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var LogModel
   */
  protected $LOG;

  /**
   * @var string Log type used in log entries from this controller.
   */
  protected $logType;

  /**
   * @var array
   */
  protected $formFields = [];

  /**
   * @var @var \CodeIgniter\Validation\ValidationInterface
   */
  protected $validation;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct() {
    //
    // Most services in this controller require the session to be started
    //
    $this->LOG = model(LogModel::class);
    $this->validation = service('validation');
    $this->logType = 'Settings';

    $this->formFields = [
      'general' => [
        'txt_applicationUrl' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_applicationName' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_htmlDescription' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_htmlKeywords' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'sel_defaultLanguage' => [ 'type' => 'select', 'subtype' => 'single', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'rad_alerts' => [ 'type' => 'radio', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_autocloseAlertSuccess' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_autocloseAlertWarning' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_autocloseAlertDanger' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_autocloseDelay' => [ 'type' => 'number', 'mandatory' => false, 'value' => '', 'min' => '1000', 'max' => '10000', 'step' => '500' ],
      ],
      'email' => [
        'swi_emailNotifications' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailFrom' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailReply' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_emailSMTP' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailSMTPhost' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailSMTPport' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailSMTPusername' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_emailSMTPpassword' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'rad_emailSMTPCrypto' => [ 'type' => 'radio', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_emailSMTPAnonymous' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
      'footer' => [
        'txt_footerCopyrightName' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_footerCopyrightUrl' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_footerSocialLinks' => [ 'type' => 'textarea', 'mandatory' => false, 'value' => '', 'items' => [], 'rows' => '5' ],
      ],
      'homepage' => [
        'txt_welcomeText' => [ 'type' => 'textareawide', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
      'authentication' => [
        'swi_allowRegistration' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_allowRemembering' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_require2fa' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
      'gdpr' => [
        'swi_cookieConsent' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_dataPrivacyPolicy' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_gdprOrganization' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_gdprController' => [ 'type' => 'textarea', 'mandatory' => false, 'value' => '', 'items' => [], 'rows' => '5' ],
        'txt_gdprPrivacyOfficer' => [ 'type' => 'textarea', 'mandatory' => false, 'value' => '', 'items' => [], 'rows' => '5' ],
        'swi_imprint' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
      'system' => [
        'sel_timezone' => [ 'type' => 'select', 'subtype' => 'single', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_robots' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_noCaching' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_versionCheck' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_googleAnalytics' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'txt_googleAnalyticsId' => [ 'type' => 'text', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'swi_underMaintenance' => [ 'type' => 'switch', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
      'theme' => [
        'rad_defaultTheme' => [ 'type' => 'radio', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'rad_defaultMenu' => [ 'type' => 'radio', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'sel_font' => [ 'type' => 'select', 'subtype' => 'single', 'mandatory' => false, 'value' => '', 'items' => [] ],
        'rad_highlightJsTheme' => [ 'type' => 'radio', 'mandatory' => false, 'value' => '', 'items' => [] ],
      ],
    ];
  }

  /**
   * --------------------------------------------------------------------------
   * Settings Edit.
   * --------------------------------------------------------------------------
   *
   * Displays the settings edit page.
   *
   * @return string
   */
  public function edit(): string {

    /** @var \Config\App $appConfig */
    $appConfig = config('App');

    $settings = $this->checkDefaults();

    //
    // Fill formFields array with values from database
    //
    foreach ($this->formFields as $tabKey => $tab) {
      foreach ($tab as $key => $setting) {
        $pieces = explode('_', $key);
        $fieldName = $pieces[1];
        if (array_key_exists($fieldName, $settings)) {
          $this->formFields[$tabKey][$key]['value'] = $settings[$fieldName];
        } else {
          $this->formFields[$tabKey][$key]['value'] = '0';
        }
      }
    }

    //
    // Add options for rad_alert
    //
    $this->formFields['general']['rad_alerts']['items'] = [
      [ 'label' => lang('Settings.alerts_all'), 'value' => 'all', 'checked' => (array_key_exists('alerts', $settings) && $settings['alerts'] === 'all' ? true : false) ],
      [ 'label' => lang('Settings.alerts_errors'), 'value' => 'errors', 'checked' => (array_key_exists('alerts', $settings) && $settings['alerts'] === 'errors' ? true : false) ],
      [ 'label' => lang('Settings.alerts_none'), 'value' => 'none', 'checked' => (array_key_exists('alerts', $settings) && $settings['alerts'] === 'none' ? true : false) ],
    ];

    //
    // Add options for rad_SMTPCrypto
    //
    $this->formFields['email']['rad_emailSMTPCrypto']['items'] = [
      [ 'label' => lang('Settings.emailSMTPCrypto_none'), 'value' => 'none', 'checked' => (array_key_exists('emailSMTPCrypto', $settings) && $settings['emailSMTPCrypto'] === 'none' ? true : false) ],
      [ 'label' => lang('Settings.emailSMTPCrypto_ssl'), 'value' => 'ssl', 'checked' => (array_key_exists('emailSMTPCrypto', $settings) && $settings['emailSMTPCrypto'] === 'ssl' ? true : false) ],
      [ 'label' => lang('Settings.emailSMTPCrypto_tls'), 'value' => 'tls', 'checked' => (array_key_exists('emailSMTPCrypto', $settings) && $settings['emailSMTPCrypto'] === 'tls' ? true : false) ],
    ];

    //
    // Add options for rad_defaultTheme
    //
    $this->formFields['theme']['rad_defaultTheme']['items'] = [
      [ 'label' => lang('Settings.defaultTheme_dark'), 'value' => 'dark', 'checked' => (array_key_exists('defaultTheme', $settings) && $settings['defaultTheme'] === 'dark' ? true : false) ],
      [ 'label' => lang('Settings.defaultTheme_light'), 'value' => 'light', 'checked' => (array_key_exists('defaultTheme', $settings) && $settings['defaultTheme'] === 'light' ? true : false) ],
    ];

    //
    // Add options for rad_defaultMenu
    //
    $this->formFields['theme']['rad_defaultMenu']['items'] = [
      [ 'label' => lang('Settings.defaultMenu_navbar'), 'value' => 'navbar', 'checked' => (array_key_exists('defaultMenu', $settings) && $settings['defaultMenu'] === 'navbar' ? true : false) ],
      [ 'label' => lang('Settings.defaultMenu_sidebar'), 'value' => 'sidebar', 'checked' => (array_key_exists('defaultMenu', $settings) && $settings['defaultMenu'] === 'sidebar' ? true : false) ],
    ];

    //
    // Add options for rad_defaultTheme
    //
    $this->formFields['theme']['rad_highlightJsTheme']['items'] = [
      [ 'label' => lang('Settings.defaultTheme_dark'), 'value' => 'dark', 'checked' => (array_key_exists('highlightJsTheme', $settings) && $settings['highlightJsTheme'] === 'dark' ? true : false) ],
      [ 'label' => lang('Settings.defaultTheme_light'), 'value' => 'light', 'checked' => (array_key_exists('highlightJsTheme', $settings) && $settings['highlightJsTheme'] === 'light' ? true : false) ],
    ];

    //
    // Add options for sel_font
    //
    $supportedFonts = $appConfig->supportedFonts;
    $fontOptions = [];
    foreach ($supportedFonts as $font) {
      $fontOptions[] = [ 'title' => $font['name'], 'value' => $font['id'], 'selected' => (array_key_exists('font', $settings) && $settings['font'] === $font['id'] ? true : false) ];
    }
    $this->formFields['theme']['sel_font']['items'] = $fontOptions;

    //
    // Add options for sel_defaultLanguage
    //
    $supportedLanguages = $appConfig->supportedLocales;
    $languageOptions = [];
    foreach ($supportedLanguages as $lang) {
      $languageOptions[] = [ 'title' => lang('App.locales.' . $lang), 'value' => $lang, 'selected' => (array_key_exists('defaultLanguage', $settings) && $settings['defaultLanguage'] === $lang ? true : false) ];
    }
    $this->formFields['general']['sel_defaultLanguage']['items'] = $languageOptions;

    //
    // Add options for sel_timezone
    //
    $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    $timezoneOptions = [];
    foreach ($timezones as $tz) {
      $timezoneOptions[] = [ 'title' => $tz, 'value' => $tz, 'selected' => (array_key_exists('timezone', $settings) && $settings['timezone'] === $tz ? true : false) ];
    }
    $this->formFields['system']['sel_timezone']['items'] = $timezoneOptions;

    //
    // Check whether the site is in maintenance mode. If so, display w warning message.
    //
    if ($settings['underMaintenance'] === '1') {
      $this->session->set('warning', lang('Settings.underMaintenance_warning'));
    }

    return $this->_render(
      $this->config->views['settings'],
      [
        'page' => lang('Settings.pageTitle'),
        'config' => $this->config,
        'settings' => $settings,
        'languageOptions' => $languageOptions,
        'formFields' => $this->formFields,
      ]
    );
  }

  /**
   * --------------------------------------------------------------------------
   * Settings Edit Do.
   * --------------------------------------------------------------------------
   *
   * Saves the settings page.
   *
   * @param int|null $id
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function editDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $form = array();

    //
    // Set basic validation rules
    //
    $validationRules = [
      'txt_autocloseDelay' => [ 'label' => lang('Settings.autocloseDelay'), 'rules' => 'integer|greater_than[999]|less_than[10001]' ],
      'txt_applicationUrl' => [ 'label' => lang('Settings.email.applicationUrl'), 'rules' => 'valid_url' ],
      'txt_applicationName' => [ 'label' => lang('Settings.email.applicationName'), 'rules' => 'max_length[255]' ],
      'txt_htmlDescription' => [ 'label' => lang('Settings.email.htmlDescription'), 'rules' => 'permit_empty|max_length[255]' ],
      'txt_htmlKeywords' => [ 'label' => lang('Settings.email.htmlKeywords'), 'rules' => 'permit_empty|max_length[255]' ],
      'txt_emailReply' => [ 'label' => lang('Settings.email.emailReply'), 'rules' => 'valid_email' ],
      'txt_footerCopyrightUrl' => [ 'label' => lang('Settings.footerCopyrightUrl'), 'rules' => 'permit_empty|valid_url' ],
      'txt_welcomeText' => [ 'label' => lang('Settings.email.welcomeText'), 'rules' => 'permit_empty' ],
      'txt_googleAnalyticsId' => [ 'label' => lang('Settings.googleAnalyticsId'), 'rules' => 'permit_empty|valid_ga4' ],
    ];

    //
    // Get form fields for validation
    //
    foreach ($this->formFields as $tab => $settings) {
      foreach ($this->formFields[$tab] as $key => $setting) {
        switch ($key) {
          case 'txt_applicationUrl':
          case 'txt_footerCopyrightUrl':
            $form[$key] = $this->request->getPost($key, FILTER_SANITIZE_URL);
            break;
          case 'txt_emailReply':
            $form[$key] = $this->request->getPost($key, FILTER_SANITIZE_EMAIL);
            break;
          case 'txt_welcomeText':
            $form[$key] = trim(sanitizeWithAllowedTags($this->request->getPost($key)));
            break;
          default:
            $form[$key] = trim($this->request->getPost($key, FILTER_SANITIZE_STRING));
            break;
        }
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
        foreach ($tab as $key => $setting) {
          $pieces = explode('_', $key);
          $fieldType = $pieces[0];
          $fieldName = $pieces[1];
          if ($fieldType === 'swi') {
            if ($form[$key]) {
              if ($fieldName === 'robots') {
                $this->settings->saveSetting([ 'key' => $fieldName, 'value' => 'all' ]);
              } else {
                $this->settings->saveSetting([ 'key' => $fieldName, 'value' => '1' ]);
              }
            } else {
              if ($fieldName === 'robots') {
                $this->settings->saveSetting([ 'key' => $fieldName, 'value' => 'noindex' ]);
              } else {
                $this->settings->saveSetting([ 'key' => $fieldName, 'value' => '0' ]);
              }
            }
          } else {
            $this->settings->saveSetting([ 'key' => $fieldName, 'value' => $form[$key] ]);
          }
        }
      }

      //
      // Success! Go back from where the user came.
      //
      logEvent(
        [
          'type' => $this->logType,
          'event' => lang('Settings.update_success'),
          'user' => user_username(),
          'ip' => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', lang('Settings.update_success'));
    }
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
    if (!array_key_exists('alerts', $settings)) {
      $this->settings->saveSetting([ 'key' => 'alerts', 'value' => 'all' ]);
    }
    if (!array_key_exists('defaultLanguage', $settings)) {
      $this->settings->saveSetting([ 'key' => 'defaultLanguage', 'value' => 'en' ]);
    }
    if (!array_key_exists('defaultTheme', $settings)) {
      $this->settings->saveSetting([ 'key' => 'defaultTheme', 'value' => 'light' ]);
    }
    if (!array_key_exists('defaultMenu', $settings)) {
      $this->settings->saveSetting([ 'key' => 'defaultMenu', 'value' => 'navbar' ]);
    }
    if (!array_key_exists('licenseKey', $settings)) {
      $this->settings->saveSetting([ 'key' => 'licenseKey', 'value' => '' ]);
    }
    if (!array_key_exists('dataPrivacyPolicy', $settings)) {
      $this->settings->saveSetting([ 'key' => 'dataPrivacyPolicy', 'value' => '1' ]);
    }
    if (!array_key_exists('imprint', $settings)) {
      $this->settings->saveSetting([ 'key' => 'imprint', 'value' => '1' ]);
    }
    if (!array_key_exists('timezone', $settings)) {
      $this->settings->saveSetting([ 'key' => 'timezone', 'value' => 'UTC' ]);
    }
    if (!array_key_exists('caching', $settings)) {
      $this->settings->saveSetting([ 'key' => 'caching', 'value' => '1' ]);
    }
    if (!array_key_exists('robots', $settings)) {
      $this->settings->saveSetting([ 'key' => 'robots', 'value' => '0' ]);
    }
    if (!array_key_exists('versionCheck', $settings)) {
      $this->settings->saveSetting([ 'key' => 'versionCheck', 'value' => '0' ]);
    }
    if (!array_key_exists('underMaintenance', $settings)) {
      $this->settings->saveSetting([ 'key' => 'underMaintenance', 'value' => '0' ]);
    }
    if (!array_key_exists('font', $settings)) {
      $this->settings->saveSetting([ 'key' => 'font', 'value' => 'roboto' ]);
    }
    //
    // Get all records again, compress and return
    //
    return $this->settings->getSettings();
  }
}

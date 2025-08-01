<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use App\Config\Lic as LicConfig;
use App\Controllers\BaseController;
use App\Libraries\Bootstrap;
use App\Models\SettingsModel;

class LicController extends BaseController {
  /**
   * Bootstrap library.
   *
   * @var Bootstrap
   */
  protected $bs;

  /**
   * The license key.
   * Private variable holding the license key itself.
   * Set with setKey(), read with getKey() method.
   *
   * @var string
   */
  public $key = '';

  /**
   * The license details.
   * JSON response from the license server.
   *
   * @var object
   */
  public $details;

  /**
   * The client domain.
   * The SERVER_NAME (domain) that this application runs on. The domain is
   * registered with the license on the license server.
   *
   * @var string
   */
  private $domain;

  /**
   * The Lic config class.
   * JSON reponse from the license server.
   *
   * @var LicConfig
   */
  public $licConfig;

  /**
   * Settings Model.
   * Needed to read from application settings records.
   *
   * @var SettingsModel
   */
  protected $settingsModel;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct($key = '') {
    $this->bs = new Bootstrap();
    $this->licConfig = config('Lic');
    $this->domain = $_SERVER['SERVER_NAME'];
    $this->key = $key;
    $this->settingsModel = model(SettingsModel::class);
  }

  /**
   * --------------------------------------------------------------------------
   * Index.
   * --------------------------------------------------------------------------
   *
   * Handles the license page.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|mixed
   */
  public function index(): mixed {
    //
    // If the license check is disabled, redirect to the home page
    //
    if (!$this->licConfig->checkLicense) {
      return redirect()->route('home');
    }
    //
    // Get the license key
    //
    $this->readKey();
    $this->load();

    if ($this->request->getMethod() === 'POST') {
      //
      // A form was submitted. Let's see what it was...
      //
      if (array_key_exists('btn_activate', $this->request->getPost()) || array_key_exists('btn_register', $this->request->getPost())) {
        $this->activate();
        return redirect()->route('license');
      } elseif (array_key_exists('btn_deregister', $this->request->getPost())) {
        $this->deactivate();
        return redirect()->route('license');
      } elseif (array_key_exists('btn_save', $this->request->getPost())) {
        $this->saveKey($this->request->getPost('licensekey'));
        return redirect()->route('license');
      }
    }

    return $this->_render($this->licConfig->views['license'], [
      'page' => lang('Lic.pageTitle'),
      'config' => $this->licConfig,
      'licenseKey' => $this->key,
      'licStatus' => $this->status(),
      'L' => $this,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Activate.
   * --------------------------------------------------------------------------
   *
   * Activates a license key (and registers the domain that the request is
   * coming from).
   *
   * @return object
   */
  public function activate() {
    $parms = array(
      'slm_action' => 'slm_activate',
      'secret_key' => $this->licConfig->secretKey,
      'license_key' => $this->key,
      'registered_domain' => $this->domain,
      'item_reference' => urlencode($this->licConfig->itemReference),
    );

    $response = $this->callAPI('GET', $this->licConfig->licenseServer, $parms);

    if (!$response) {
      return redirect()->route('license')->with('error', lang('Lic.alert.api_error'));
    }

    $response = json_decode((string)$response);

    if ($response->result == 'error') {
      return redirect()->route('license')->with('error', $response->message);
    }

    return $response;
  }

  /**
   * --------------------------------------------------------------------------
   * CallAPI.
   * --------------------------------------------------------------------------
   *
   * License server API call.
   *
   * @param string $method POST, PUT, GET, ...
   * @param string $url API host URL
   * @param array $data URL paramater: array("param" => "value") ==> index.php?param=value
   *
   * @return bool|object|string
   */
  public function callAPI($method, $url, $data = false): bool|object|string {
    $curl = curl_init();

    switch (strtoupper($method)) {

      case "POST":
        curl_setopt($curl, CURLOPT_POST, 1);
        if ($data) {
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        break;

      case "PUT":
        curl_setopt($curl, CURLOPT_PUT, 1);
        break;

      default:
        if ($data) {
          $url = sprintf("%s?%s", $url, http_build_query($data));
        }
    }

    // Optional Authentication:
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC)
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password")

    // Optional Debugging:
    // $query = LICENSE_SERVER . '?slm_action=' . $data['slm_action'] . '&amp;secret_key=' . $data['secret_key'] . '&amp;license_key=' . $data['license_key'] . '&amp;registered_domain=' . $data['registered_domain'] . '&amp;item_reference=' . $data['item_reference']
    // dnd($query)

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
  }

  /**
   * --------------------------------------------------------------------------
   * Deactivate.
   * --------------------------------------------------------------------------
   *
   * De-registers the domain the request is coming from.
   *
   * @return object
   */
  public function deactivate(): object {
    $parms = array(
      'slm_action' => 'slm_deactivate',
      'secret_key' => $this->licConfig->secretKey,
      'license_key' => $this->key,
      'registered_domain' => $this->domain,
      'item_reference' => urlencode($this->licConfig->itemReference),
    );

    $response = $this->callAPI('GET', $this->licConfig->licenseServer, $parms);

    if (!$response) {
      return redirect()->route('license')->with('error', lang('Lic.alert.api_error'));
    }

    $response = json_decode((string)$response);

    if ($response->result == 'error') {
      return redirect()->route('license')->with('error', $response->message);
    }

    return $response;
  }

  /**
   * --------------------------------------------------------------------------
   * Days to expiry.
   * --------------------------------------------------------------------------
   *
   * Returns the days until expiry.
   *
   * @return int
   */
  public function daysToExpiry(): int {
    $todayDate = new Time('now');
    $expiryDate = new Time($this->details->date_expiry);
    $daysToExpiry = $todayDate->diff($expiryDate);

    return intval($daysToExpiry->format('%R%a'));
  }

  /**
   * --------------------------------------------------------------------------
   * Domain registered.
   * --------------------------------------------------------------------------
   *
   * Checks whether the current domain is registered.
   *
   * @return bool
   */
  public function domainRegistered(): bool {
    if (count($this->details->registered_domains)) {
      foreach ($this->details->registered_domains as $domain) {
        if ($domain->registered_domain == $this->domain) {
          return true;
        }
      }
      return false;
    } else {
      return false;
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Expiry warning.
   * --------------------------------------------------------------------------
   *
   * Returns an alert message when the expiry threshold is reached.
   *
   * @return string
   */
  public function expiryWarning(): string {
    $html = '';
    if ($this->daysToExpiry() <= $this->licConfig->expiryWarning) {
      $html = $this->bs->toast([
        'title' => lang('Lic.expiringsoon'),
        'time' => date('Y-m-d H:i'),
        'style' => 'warning',
        'body' => lang('Lic.expiringsoon_subject', [ $this->daysToExpiry() ]) . '<br>' . lang('Lic.expiringsoon_help'),
        'delay' => 5000,
        'custom_style' => false,
      ]);
    }

    return $html;
  }

  /**
   * --------------------------------------------------------------------------
   * Get key.
   * --------------------------------------------------------------------------
   *
   * Reads the value of the license key property.
   *
   * @return string
   */
  public function getKey(): string {
    return $this->key;
  }

  /**
   * --------------------------------------------------------------------------
   * Load.
   * --------------------------------------------------------------------------
   *
   * Loads the license information from license server.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|bool
   */
  public function load(): \CodeIgniter\HTTP\RedirectResponse|bool {
    $parms = array(
      'slm_action' => 'slm_check',
      'secret_key' => $this->licConfig->secretKey,
      'license_key' => $this->key,
    );

    $response = $this->callAPI('GET', $this->licConfig->licenseServer, $parms);

    if (!$response) {
      return redirect()->route('license')->with('error', lang('Lic.alert.api_error'));
    }

    $response = json_decode((string)$response);

    if ($response->result === 'error') {
      return redirect()->route('license')->with('error', $response->message);
    }

    $this->details = $response;
    return true;
  }

  /**
   * --------------------------------------------------------------------------
   * Read key.
   * --------------------------------------------------------------------------
   *
   * Reads the license key from the database.
   *
   * @return void
   */
  public function readKey(): void {
    //
    // Most probably your license key will be in your database together with
    // other settings of your application. Add the proper code to read it
    // here e.g. from a database with this pseudo code
    // $this->key = read_key_from_db();
    //
//    $this->key = 'CI4-61df038a2d0cb';
    $this->key = $this->settingsModel->getSetting('licenseKey');
  }

  /**
   * --------------------------------------------------------------------------
   * Save key.
   * --------------------------------------------------------------------------
   *
   * Saves the license key to the database.
   *
   * @return void
   */
  public function saveKey($value): void {
    //
    // You may want to use this method to save the license key elsewhere
    // e.g. to a database with this pseudo code
    // save_key_to_db($this->key);
    //
    $this->settingsModel->saveSetting([ 'key' => 'licensekey', 'value' => $value ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Set key.
   * --------------------------------------------------------------------------
   *
   * Sets the class license key.
   *
   * @param string $key The license key
   *
   * @return void
   */
  public function setKey($key): void {
    $this->key = $key;
  }

  /**
   * --------------------------------------------------------------------------
   * Show.
   * --------------------------------------------------------------------------
   *
   * Creates a table with license details and displays it inside a Bootstrap
   * alert box. This method assumes that your application uses Bootstrap 5.
   *
   * @param object $data License information array
   *
   * @return string HTML
   */
  public function show($data, $showDetails = false): string {
    if (isset($data->result) && $data->result == "error") {
      $alert['type'] = 'danger';
      $alert['title'] = lang('Lic.invalid');
      $alert['subject'] = lang('Lic.invalid_subject');
      $alert['text'] = lang('Lic.invalid_text');
      $alert['help'] = lang('Lic.invalid_help');
      $details = "";
    } else {
      $domains = "";
      if (count($data->registered_domains)) {
        foreach ($data->registered_domains as $domain) {
          $domains .= $domain->registered_domain . ', ';
        }
        $domains = substr($domains, 0, -2); // Remove last comma and blank
      }
      $daysleft = "";
      if ($daysToExpiry = $this->daysToExpiry()) {
        $daysleft = " (" . $daysToExpiry . " " . lang('Lic.daysleft') . ")";
      }

      switch ($this->status()) {
        case "expired":
          $alert['type'] = 'warning';
          $alert['title'] = lang('Lic.expired');
          $alert['subject'] = lang('Lic.expired_subject');
          $alert['text'] = '';
          $alert['help'] = lang('Lic.expired_help');
          break;
        case "blocked":
          $alert['type'] = 'warning';
          $alert['title'] = lang('Lic.blocked');
          $alert['subject'] = lang('Lic.blocked_subject');
          $alert['text'] = '';
          $alert['help'] = lang('Lic.blocked_help');
          break;
        case "pending":
          $alert['type'] = 'warning';
          $alert['title'] = lang('Lic.pending');
          $alert['subject'] = lang('Lic.pending_subject');
          $alert['text'] = '';
          $alert['help'] = lang('Lic.pending_help');
          break;
        case "unregistered":
          $alert['type'] = 'warning';
          $alert['title'] = lang('Lic.active');
          $alert['subject'] = lang('Lic.active_unregistered_subject');
          $alert['text'] = '';
          $alert['help'] = '';
          break;
        case "active":
        default:
          $alert['type'] = 'success';
          $alert['title'] = lang('Lic.active');
          $alert['subject'] = lang('Lic.active_subject');
          $alert['text'] = '';
          $alert['help'] = '';
          break;
      }
    }

    $details = "
      <table class=\"table table-hover\">
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.product') . ":</th><td>" . $data->product_ref . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.key') . ":</th><td>" . $data->license_key . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.name') . ":</th><td>" . $data->first_name . " " . $data->last_name . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.email') . ":</th><td>" . $data->email . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.company') . ":</th><td>" . $data->company_name . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.date_created') . ":</th><td>" . $data->date_created . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.date_renewed') . ":</th><td>" . $data->date_renewed . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.date_expiry') . ":</th><td>" . $data->date_expiry . $daysleft . "</td></tr>
        <tr class=\"table-" . $alert['type'] . "\"><th>" . lang('Lic.registered_domains') . ":</th><td>" . $domains . "</td></tr>
      </table>";

    return $this->bs->alert([
      'type' => $alert['type'],
      'icon' => '',
      'title' => $alert['title'],
      'subject' => $alert['subject'],
      'text' => $alert['text'],
      'help' => (strlen($alert['help']) ? "<p><i>" . $alert['help'] . "</i></p>" : "") . (($showDetails) ? $details : ''),
      'dismissible' => false,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Status.
   * --------------------------------------------------------------------------
   *
   * Get license status.
   *
   * @return string active/blocked/invalid/expired/pending/unregistered
   */
  public function status(): string {
    if (!isset($this->details) || $this->details->result == 'error') {
      return "invalid";
    }

    switch ($this->details->status) {
      case "active":
        if (!$this->domainRegistered()) {
          return 'unregistered';
        }
        return 'active';
      case "expired":
        return 'expired';
      case "blocked":
        return 'blocked';
      case "pending":
        return 'pending';
      default:
        return 'invalid';
    }
  }
}

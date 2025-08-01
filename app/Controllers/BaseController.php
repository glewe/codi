<?php

namespace App\Controllers;

use App\Libraries\Bootstrap;
use App\Libraries\Gravatar;
use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\UserOptionModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\App as AppConfig;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components and
 * performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 *   class Home extends BaseController { ... }
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * The following properties are available through the BaseController:
 *   $this->config (AppConfig)
 *   $this->helpers (array)
 *   $this->request (IncomingRequest)
 *   $this->session (Session)
 *   $this->settings (SettingsModel)
 *
 * The following methods are available through the BaseController:
 *   $this->_render(string $view, array $data = [], array $options = [])
 */
abstract class BaseController extends Controller {
  /**
   * Instance of the App configuration.
   *
   * @var AppConfig
   */
  protected $config;

  /**
   * Instance of the License configuration.
   *
   * @var AppConfig
   */
  protected $configLic;

  /**
   * Instance of the AppInfo configuration.
   *
   * @var AppConfig
   */
  protected $configAppInfo;

  /**
   * An array of helpers to be loaded automatically upon
   * class instantiation. These helpers will be available
   * to all other controllers that extend BaseController.
   *
   * @var array
   */
  protected $helpers = [ 'auth', 'session', 'url' ];

  /**
   * @var LogModel
   */
  protected $LOG;

  /**
   * Instance of the Bootstrap Library
   *
   * @var Bootstrap
   */
  protected $bs;

  /**
   * Instance of the main Request object.
   *
   * @var CLIRequest|IncomingRequest
   */
  protected $request;

  /**
   * Instance of the Session service.
   * Be sure to declare properties for any property fetch you initialized.
   * The creation of dynamic property is deprecated in PHP 8.2.
   */
  protected $session;

  /**
   * Instance of the Settings model.
   *
   * @var SettingsModel
   */
  protected $settings;

  /**
   * Holds the theme to use.
   *
   * @var string
   */
  protected $theme;

  /**
   * Holds the menu to use.
   *
   * @var string
   */
  protected $menu;

  /**
   * Holds the URL to the user's avatar.
   *
   * @var string
   */
  protected $avatarUrl;

  /**
   * --------------------------------------------------------------------------
   * Init Controller.
   * --------------------------------------------------------------------------
   *
   * Initializes the controller with the provided request, response, and logger.
   *
   * This method is called automatically by CodeIgniter to initialize the controller.
   * It sets up the session, language, theme, menu, and timezone settings.
   *
   * @param RequestInterface $request The request object.
   * @param ResponseInterface $response The response object.
   * @param LoggerInterface $logger The logger object.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|void
   */
  public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void {
    // Do Not Edit This Line
    parent::initController($request, $response, $logger);

    // Preload any models, libraries, etc, here.
    $session = \Config\Services::session();
    $language = \Config\Services::language();

    $this->bs = new Bootstrap();
    $this->config = config('App');
    $this->configAppInfo = config('AppInfo');
    $this->session = service('session');
    $this->settings = model(SettingsModel::class);
    $this->configLic = config('Lic');

    //
    // Get language from session or set default language
    //
    if (!isset($session->lang)) {
      $session->lang = $this->settings->getSetting('defaultLanguage');
    }
    $language->setLocale($session->lang);
    //
    // Se theme, menu and avatar defaults
    //
    $this->theme = $this->settings->getSetting('defaultTheme') ?? 'light';
    $this->menu = $this->settings->getSetting('defaultMenu') ?? 'navbar';
    $this->avatarUrl = base_url() . '/upload/avatars/default_male.png';
    if (user_id()) {
      //
      // Someone is logged in
      //
      $users = model(UserModel::class);
      $userOptions = model(UserOptionModel::class);
      if ($users->where('id', user_id())->first()) {
        //
        // Get the user's theme choice
        //
        $t = $userOptions->getOption([ 'user_id' => user_id(), 'option' => 'theme' ]);
        if ($t && in_array($t, [ 'dark', 'light' ])) {
          $this->theme = $t;
        }
        //
        // Get the user's menu choice
        //
        $m = $userOptions->getOption([ 'user_id' => user_id(), 'option' => 'menu' ]);
        if ($m && in_array($m, [ 'navbar', 'sidebar' ])) {
          $this->menu = $m;
        }
        //
        // Get the user's avatar
        //
        $avatar = $userOptions->getOption([ 'user_id' => user_id(), 'option' => 'avatar' ]);

        if ($avatar === 'gravatar') {
          $gravatar = new Gravatar();
          $gravatarUrl = $gravatar->get(user_email());
          $this->avatarUrl = $gravatarUrl;
        } elseif ($avatar) {
          $avatarBaseUrl = base_url() . '/upload/avatars/';
          $this->avatarUrl = $avatarBaseUrl . $avatar;
        }
      }
    }
    //
    // Set timezone
    //
    $tz = $this->settings->getSetting("timezone");
    if (!strlen($tz) || !$tz || $tz === "default") {
      date_default_timezone_set('UTC');
      $this->settings->saveSetting([ 'key' => 'timezone', 'value' => 'UTC' ]);
    } else {
      date_default_timezone_set($tz);
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Render.
   * --------------------------------------------------------------------------
   *
   * Render View.
   *
   * @param string $view
   * @param array $data
   *
   * @return string
   */
  protected function _render(string $view, array $data = []): string {
    //
    // In case you have a custom configuration that you want to pass to
    // your views (e.g. theme settings), it is added here.
    //
    // It is assumed that have declared and set the variable $myConfig in
    // your BaseController.
    //
    $data['bs'] = $this->bs;
    $data['config'] = $this->config;
    $data['configAppInfo'] = $this->configAppInfo;
    $data['configLic'] = $this->configLic;
    $data['settings'] = $this->settings->getSettings();
    $data['session'] = $this->session;
    $data['theme'] = $this->theme;
    $data['menu'] = $this->menu;
    $data['avatarUrl'] = $this->avatarUrl;
    //
    // Extract the route name from the view string
    //
    if ($pos = strrpos($view, '/')) {
      $page = substr($view, $pos + 1);
    } elseif ($pos = strrpos($view, '\\')) {
      $page = substr($view, $pos + 1);
    } else {
      $page = $view;
    }
    //
    // If under maintenance mode is active, show the under maintenance page.
    // However, the login, logout and settings page must remain so the admin can log
    // back in to switch off the maintenance mode again.
    //
    if ($this->settings->getSetting('undermaintenance') && !in_array($page, [ 'login', 'logout', 'settings' ])) {
      $view = "undermaintenance";
    }
    return view($view, $data);
  }
}

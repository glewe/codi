<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig {
  /**
   * --------------------------------------------------------------------------
   * Base Site URL
   * --------------------------------------------------------------------------
   *
   * URL to your CodeIgniter root. Typically, this will be your base URL,
   * WITH a trailing slash:
   *
   *    http://example.com/
   */
  public string $baseURL = 'http://localhost/lewe/codi/';
  // public string $baseURL = 'https://codi.lewe.com/';

  /**
   * --------------------------------------------------------------------------
   * Allowed Host Names
   * --------------------------------------------------------------------------
   *
   * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
   * If you want to accept multiple Hostnames, set this.
   *
   * E.g. When your site URL ($baseURL) is 'http://example.com/', and your site
   *      also accepts 'http://media.example.com/' and
   *      'http://accounts.example.com/':
   *          ['media.example.com', 'accounts.example.com']
   *
   * @var list<string>
   */
  public array $allowedHostnames = [];

  /**
   * --------------------------------------------------------------------------
   * Index File
   * --------------------------------------------------------------------------
   *
   * Typically this will be your index.php file, unless you've renamed it to
   * something else. If you are using mod_rewrite to remove the page set this
   * variable so that it is blank.
   */
  public string $indexPage = 'index.php';

  /**
   * --------------------------------------------------------------------------
   * Layout for the views to extend
   * --------------------------------------------------------------------------
   *
   * This setting specifies the layout of your views.
   *
   * @var string
   */
  public $viewLayout = 'Views\layout';

  /**
   * --------------------------------------------------------------------------
   * Show Help Menu
   * --------------------------------------------------------------------------
   *
   * This setting specifies whether to show the Help menu in the sidebar or not.
   * The Help menu contains links to the pages 'About', 'Imprint' and 'Data
   * Privacy' that are also linked to in the footer. Disable this menu in the
   * sidebar helps to unclutter it.
   *
   * @var boolean
   */
  public $showHelpMenu = true;

  /**
   * --------------------------------------------------------------------------
   * Views used by Application Controllers
   * --------------------------------------------------------------------------
   *
   * @var array
   */
  public $views = [
    'database' => 'settings\database',
    'log' => 'log\list',
    'options' => 'settings\options',
    'phpinformation' => 'settings\phpinformation',
    'settings' => 'settings\settings',
  ];

  /**
   * --------------------------------------------------------------------------
   * URI PROTOCOL
   * --------------------------------------------------------------------------
   *
   * This item determines which server global should be used to retrieve the
   * URI string.  The default setting of 'REQUEST_URI' works for most servers.
   * If your links do not seem to work, try one of the other delicious flavors:
   *
   * 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
   * 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
   * 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
   *
   * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
   */
  public string $uriProtocol = 'REQUEST_URI';

  /**
   * --------------------------------------------------------------------------
   * Default Locale
   * --------------------------------------------------------------------------
   *
   * The Locale roughly represents the language and location that your visitor
   * is viewing the site from. It affects the language strings and other
   * strings (like currency markers, numbers, etc), that your program
   * should run under for this request.
   */
  public string $defaultLocale = 'en';

  /**
   * --------------------------------------------------------------------------
   * Negotiate Locale
   * --------------------------------------------------------------------------
   *
   * If true, the current Request object will automatically determine the
   * language to use based on the value of the Accept-Language header.
   *
   * If false, no automatic detection will be performed.
   */
  public bool $negotiateLocale = true;

  /**
   * --------------------------------------------------------------------------
   * Supported Locales
   * --------------------------------------------------------------------------
   *
   * If $negotiateLocale is true, this array lists the locales supported
   * by the application in descending order of priority. If no match is
   * found, the first locale will be used.
   *
   * IncomingRequest::setLocale() also uses this list.
   *
   * @var string[]
   */
  public array $supportedLocales = [ 'en', 'de' ];

  /**
   * --------------------------------------------------------------------------
   * Supported Fonts
   * --------------------------------------------------------------------------
   *
   * This array is used to fill the Google Font select list on the settings page.
   * The id needs to match the name of the corresponding css file in the public/css
   * folder. The name is use in the list box.
   *
   * @var array<int, array<string, string>>
   */
  public array $supportedFonts = [
    [ 'id' => 'lato', 'name' => 'Lato' ],
    [ 'id' => 'montserrat', 'name' => 'Montserrat' ],
    [ 'id' => 'opensans', 'name' => 'Open Sans' ],
    [ 'id' => 'roboto', 'name' => 'Roboto' ],
  ];

  /**
   * --------------------------------------------------------------------------
   * Application Timezone
   * --------------------------------------------------------------------------
   *
   * The default timezone that will be used in your application to display
   * dates with the date helper, and can be retrieved through app_timezone()
   *
   * @see https://www.php.net/manual/en/timezones.php for list of timezones supported by PHP.
   */
  public string $appTimezone = 'UTC';

  /**
   * --------------------------------------------------------------------------
   * Default Character Set
   * --------------------------------------------------------------------------
   *
   * This determines which character set is used by default in various methods
   * that require a character set to be provided.
   *
   * @see http://php.net/htmlspecialchars for a list of supported charsets.
   */
  public string $charset = 'UTF-8';

  /**
   * --------------------------------------------------------------------------
   * Force Global Secure Requests
   * --------------------------------------------------------------------------
   *
   * If true, this will force every request made to this application to be
   * made via a secure connection (HTTPS). If the incoming request is not
   * secure, the user will be redirected to a secure version of the page
   * and the HTTP Strict Transport Security header will be set.
   */
  public bool $forceGlobalSecureRequests = false;

  /**
   * --------------------------------------------------------------------------
   * Reverse Proxy IPs
   * --------------------------------------------------------------------------
   *
   * If your server is behind a reverse proxy, you must whitelist the proxy
   * IP addresses from which CodeIgniter should trust headers such as
   * X-Forwarded-For or Client-IP in order to properly identify
   * the visitor's IP address.
   *
   * You need to set a proxy IP address or IP address with subnets and
   * the HTTP header for the client IP address.
   *
   * Here are some examples:
   *     [
   *         '10.0.1.200'     => 'X-Forwarded-For',
   *         '192.168.5.0/24' => 'X-Real-IP',
   *     ]
   *
   * @var array<string, string>
   */
  public array $proxyIPs = [];

  /**
   * --------------------------------------------------------------------------
   * Content Security Policy
   * --------------------------------------------------------------------------
   *
   * Enables the Response's Content Secure Policy to restrict the sources that
   * can be used for images, scripts, CSS files, audio, video, etc. If enabled,
   * the Response object will populate default values for the policy from the
   * `ContentSecurityPolicy.php` file. Controllers can always add to those
   * restrictions at run time.
   *
   * For a better understanding of CSP, see these documents:
   *
   * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
   * @see http://www.w3.org/TR/CSP/
   */
  public bool $CSPEnabled = false;

  /**
   * --------------------------------------------------------------------------
   * Avatar Sets
   * --------------------------------------------------------------------------
   *
   * Enables you to add more avatars by just copying the avatar files to the
   * public/upload/avatars folder. The files will be automatically detected as
   * long as their names follow the following format:
   *
   * av_<set>_<avatar>.<extension>
   *
   * Example:
   * av_animals_dog.png
   * av_animals_cat.png
   * av_animals_bird.png
   * ...
   *
   * Add your set in below array by specifying the title, the set name and the
   * example avatar file name. Also, enter the creditsName and creditsLink info
   * if attribution is required.
   *
   * Example:
   * ['title' => 'My Animals Avatar Set', 'set' => 'animals', 'sample' => 'av_animals_cat.png', 'creditsName' => 'Me', 'creditsLink' => 'https://me.com']
   *
   */
  public $avatarSets = array(
    [ 'title' => 'Freepik-051', 'set' => 'freepik-051', 'sample' => 'av_freepik-051_man.png', 'creditsName' => 'Freepik', 'creditsLink' => 'https://www.flaticon.com/authors/freepik' ],
    [ 'title' => 'Iconshock People', 'set' => 'iconshock-user', 'sample' => 'av_iconshock-user_administrator.png', 'creditsName' => 'Iconshock', 'creditsLink' => 'https://www.iconshock.com/people-icons/' ],
    [ 'title' => 'Iconshock Flat People', 'set' => 'iconshock-flat-people', 'sample' => 'av_iconshock-flat-people_actor.png', 'creditsName' => 'Iconshock', 'creditsLink' => 'https://www.iconshock.com/people-icons/' ],
    [ 'title' => 'Iconshock Material People', 'set' => 'iconshock-material-people', 'sample' => 'av_iconshock-material-people_actor.png', 'creditsName' => 'Iconshock', 'creditsLink' => 'https://www.iconshock.com/people-icons/' ],
  );

  /**
   * --------------------------------------------------------------------------
   * Log Types
   * --------------------------------------------------------------------------
   *
   * Each controller has one of these log types. The log type is used to log
   * events in the log table. The log type is used to filter the log entries.
   * If you add a new log type, also add the appropriate language strings in
   * en/Log.php and de/Log.php.
   *
   * @var array
   */
  public $logTypes = [
    'Auth',
    'Database',
    'Group',
    'Log',
    'Options',
    'Permission',
    'Role',
    'Settings',
    'User',
  ];

}

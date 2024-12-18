<?php

namespace App\Libraries;

/**
 * Gravatar Library for CodeIgniter
 *
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2015 - 2023
 * @author Ryan Marshall <ryan@irealms.co.uk>, 2011 - 2015, @link http://irealms.co.uk
 *
 * Code repository: @link https://github.com/ivantcholakov/Codeigniter-Gravatar
 *
 * @version 1.2.0
 *
 * @license The MIT License (MIT)
 * @link http://opensource.org/licenses/MIT
 */

// Gravatar profile error results.
defined('GRAVATAR_NO_ERROR') || define('GRAVATAR_NO_ERROR', 0);
defined('GRAVATAR_CANT_CONNECT') || define('GRAVATAR_CANT_CONNECT', 1);
defined('GRAVATAR_INVALID_EMAIL') || define('GRAVATAR_INVALID_EMAIL', 2);
defined('GRAVATAR_PROFILE_DOES_NOT_EXIST') || define('GRAVATAR_PROFILE_DOES_NOT_EXIST', 3);
defined('GRAVATAR_INCORRECT_FORMAT') || define('GRAVATAR_INCORRECT_FORMAT', 4);

class Gravatar {

  protected $defaults;
  protected $gravatar_base_url;
  protected $gravatar_secure_base_url;
  protected $gravatar_image_extension;
  protected $gravatar_image_size;
  protected $gravatar_default_image;
  protected $gravatar_force_default_image;
  protected $gravatar_rating;
  protected $gravatar_useragent;
  protected $last_error = GRAVATAR_NO_ERROR;
  protected $is_https;
  protected $curl_exists;
  protected $allow_url_fopen;

  /**
   * Constructor for the Gravatar class.
   *
   * This function initializes the Gravatar library with the provided configuration
   * or default settings if no configuration is provided. It also sets up various
   * properties required for the library to function correctly.
   *
   * @param array $config The configuration array for initializing the Gravatar library.
   * - 'gravatar_base_url' (string): The base URL for Gravatar images.
   * - 'gravatar_secure_base_url' (string): The secure base URL for Gravatar images.
   * - 'gravatar_image_extension' (string): The file extension for Gravatar images.
   * - 'gravatar_image_size' (int): The default size of the Gravatar images.
   * - 'gravatar_default_image' (string): The default image to use if no Gravatar is found.
   * - 'gravatar_force_default_image' (bool): Whether to force the default image.
   * - 'gravatar_rating' (string): The rating level for the Gravatar images.
   * - 'gravatar_useragent' (string): The user agent string for HTTP requests.
   */
  public function __construct($config = array()) {

    $this->defaults = array(
      'gravatar_base_url' => 'http://www.gravatar.com/',
      'gravatar_secure_base_url' => 'https://secure.gravatar.com/',
      'gravatar_image_extension' => '.png',
      'gravatar_image_size' => 80,
      'gravatar_default_image' => '',
      'gravatar_force_default_image' => false,
      'gravatar_rating' => '',
      'gravatar_useragent' => 'PHP Gravatar Library',
    );

    $this->is_https = $this->isHttps();
    $this->curl_exists = function_exists('curl_init');
    $allow_url_fopen = @ini_get('allow_url_fopen');
    $allow_url_fopen = $allow_url_fopen === false || in_array(strtolower((string)$allow_url_fopen), array( 'on', 'true', '1' ));
    $this->allow_url_fopen = $allow_url_fopen;

    if (!is_array($config)) {
      $config = array();
    }

    $this->defaults = array_merge($this->defaults, $config);
    $this->initialize($this->defaults);
  }

  /**
   * Initializes the Gravatar library with the provided configuration.
   *
   * This function sets up the Gravatar library by merging the provided configuration
   * with the default settings and assigning the values to the corresponding properties.
   *
   * @param array $config The configuration array for initializing the Gravatar library.
   * - 'gravatar_base_url' (string): The base URL for Gravatar images.
   * - 'gravatar_secure_base_url' (string): The secure base URL for Gravatar images.
   * - 'gravatar_image_extension' (string): The file extension for Gravatar images.
   * - 'gravatar_image_size' (int): The default size of the Gravatar images.
   * - 'gravatar_default_image' (string): The default image to use if no Gravatar is found.
   * - 'gravatar_force_default_image' (bool): Whether to force the default image.
   * - 'gravatar_rating' (string): The rating level for the Gravatar images.
   * - 'gravatar_useragent' (string): The user agent string for HTTP requests.
   *
   * @return $this The current instance of the Gravatar library.
   */
  public function initialize($config = array()) {

    if (!is_array($config)) {
      $config = array();
    }

    foreach ($config as $key => $value) {
      $this->{$key} = $value;
    }

    $this->gravatar_base_url = (string)$this->gravatar_base_url;
    $this->gravatar_secure_base_url = (string)$this->gravatar_secure_base_url;
    $this->gravatar_image_extension = (string)$this->gravatar_image_extension;

    $this->gravatar_image_size = (int)$this->gravatar_image_size;

    if ($this->gravatar_image_size <= 0) {
      $this->gravatar_image_size = 80;
    }

    $this->gravatar_default_image = (string)$this->gravatar_default_image;
    $this->gravatar_force_default_image = !empty($this->gravatar_force_default_image);
    $this->gravatar_rating = (string)$this->gravatar_rating;
    $this->gravatar_useragent = (string)$this->gravatar_useragent;

    return $this;
  }

  /**
   * Resets the Gravatar library to its default configuration.
   *
   * This function reinitializes the Gravatar library using the default settings.
   *
   * @return $this The current instance of the Gravatar library.
   */
  public function reset() {
    $this->initialize($this->defaults);
    return $this;
  }

  /**
   * Retrieves the default configuration settings for the Gravatar library.
   *
   * This function returns an array containing the default configuration settings
   * used by the Gravatar library.
   *
   * @return array The default configuration settings.
   */
  public function getDefaults() {
    return $this->defaults;
  }

  /**
   * Creates a URL for requesting a Gravatar image.
   * @link http://en.gravatar.com/site/implement/images/
   *
   * @param string $email A registered email.
   * @param int $size The requested size of the avarar in pixels (a square image).
   * @param string $default_image The fallback image option: '', '404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'blank'.
   * @param bool $force_default_image Enforces the fallback image to be shown.
   * @param string $rating The level of allowed self-rate of the avatar: '', 'g' (default), 'pg', 'r', 'x'.
   * @return  string                              Returns the URL of the avatar to be requested.
   *
   * When optional parameters are not set, their default values are taken
   * from the configuration file application/config/gravatar.php
   */
  public function get($email, $size = null, $default_image = null, $force_default_image = null, $rating = null) {

    $url = ($this->is_https ? $this->gravatar_secure_base_url : $this->gravatar_base_url) . 'avatar/' . $this->createHash($email) . $this->gravatar_image_extension;

    $query = array();

    $size = (int)$size;

    if ($size <= 0) {
      $size = $this->gravatar_image_size;
    }

    if ($size > 0) {
      $query['s'] = $size;
    }

    if (isset($default_image)) {
      $default_image = (string)$default_image;
    } else {
      $default_image = $this->gravatar_default_image;
    }

    if ($default_image != '') {
      $query['d'] = $default_image;
    }

    if (isset($force_default_image)) {
      $force_default_image = !empty($force_default_image);
    } else {
      $force_default_image = $this->gravatar_force_default_image;
    }

    if ($force_default_image) {
      $query['f'] = 'y';
    }

    if (isset($rating)) {
      $rating = (string)$rating;
    } else {
      $rating = $this->gravatar_rating;
    }

    if ($rating != '') {
      $query['r'] = $rating;
    }

    if (!empty($query)) {
      $url = $url . '?' . http_build_query($query);
    }

    return $url;
  }

  /**
   * Executes a request for Gravatar profile data and returns it as a multidimensional array.
   * @link https://docs.gravatar.com/profiles/php/
   *
   * @param string $email A registered email.
   * @return  array/null                  Received profile data.
   */
  public function getProfileData($email) {

    $result = $this->executeProfileRequest($email, 'php');

    if ($this->last_error != GRAVATAR_NO_ERROR) {
      return null;
    }

    $result = @ unserialize($result);

    if ($result === false) {
      $this->last_error = GRAVATAR_INCORRECT_FORMAT;
      return null;
    }

    if (!is_array($result)) {
      $this->last_error = GRAVATAR_PROFILE_DOES_NOT_EXIST;
      return null;
    }

    if (!isset($result['entry']) || !isset($result['entry'][0])) {
      $this->last_error = GRAVATAR_INCORRECT_FORMAT;
      return null;
    }

    return $result['entry'][0];
  }

  /**
   * Executes a request for Gravatar profile data and returns raw received response.
   * @link https://docs.gravatar.com/profiles/php/
   *
   * @param string $email A registered email.
   * @param string $format '', 'json', 'xml', 'php', 'vcf', 'qr'.
   * @return  string/null             Received profile raw data.
   */
  public function executeProfileRequest($email, $format = null) {

    $this->last_error = GRAVATAR_NO_ERROR;

    if (function_exists('valid_email')) {
      if (!valid_email($email)) {
        $this->last_error = GRAVATAR_INVALID_EMAIL;
        return null;
      }
    } else {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->last_error = GRAVATAR_INVALID_EMAIL;
        return null;
      }
    }

    $format = trim((string)$format);

    if ($format != '') {
      $format = '.' . ltrim($format, '.');
    }

    $url = $this->gravatar_secure_base_url . $this->createHashSha256($email) . $format;

    $result = null;

    if ($this->curl_exists) {
      $ch = curl_init();
      $options = array(
        CURLOPT_USERAGENT => $this->gravatar_useragent,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => $url,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
      );

      if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
        $options[CURLOPT_FOLLOWLOCATION] = true;
      }

      curl_setopt_array($ch, $options);
      $result = curl_exec($ch);
      $code = @ curl_getinfo($ch, CURLINFO_HTTP_CODE);
      @ curl_close($ch);
      if ($code != 200) {
        $this->last_error = GRAVATAR_CANT_CONNECT;
        return null;
      }
    } elseif ($this->allow_url_fopen) {
      $options = array(
        'http' => array(
          'method' => 'GET',
          'useragent' => $this->gravatar_useragent,
        ),
      );

      $context = stream_context_create($options);
      $result = @ file_get_contents($url, false, $context);
    } else {
      $this->last_error = GRAVATAR_CANT_CONNECT;
      return null;
    }

    if ($result === false) {
      $this->last_error = GRAVATAR_CANT_CONNECT;
      return null;
    }

    return $result;
  }

  /**
   * Returns the error code as a result of the last profile request operation.
   *
   * @return int          GRAVATAR_NO_ERROR - the last operation was successfull,
   *                      other returned value indicates failure.
   */
  public function lastError() {
    return $this->last_error;
  }

  /**
   * Creates a hash value from a provided e-mail address.
   * @link https://docs.gravatar.com/gravatar-images/php/
   *
   * @param string $email A registered email.
   * @return  string/null             The hash for accessing the avatar or profile data.
   */
  public function createHash($email) {
    return md5(strtolower(trim((string)$email)));
  }

  /**
   * Checks if the current request is using HTTPS.
   *
   * This function determines if the current request is made over HTTPS by checking various server variables.
   *
   * @return bool True if the request is using HTTPS, false otherwise.
   */
  protected function isHttps() {
    if (function_exists('isHttps')) {
      return isHttps();
    }
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
      return true;
    }
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
      return true;
    }
    if (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
      return true;
    }
    return false;
  }

  /**
   * Creates a sha256 hash value from a provided e-mail address.
   * @link https://docs.gravatar.com/general/hash/
   *
   * @param string $email A registered email.
   * @return  string/null             The hash for accessing the avatar or profile data.
   */
  public function createHashSha256($email) {
    return hash('sha256', strtolower(trim((string)$email)));
  }
}

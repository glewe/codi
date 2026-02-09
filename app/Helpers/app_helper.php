<?php

declare(strict_types=1);

/**
 * ============================================================================
 * Application Helper Functions
 * ============================================================================
 */

if (!function_exists('consoleLog')) {
  //---------------------------------------------------------------------------
  /**
   * Function to log data to the JavaScript console.
   *
   * This function generates a JavaScript console.log statement with the provided
   * module name, variable name, and content. The generated JavaScript code can
   * optionally be wrapped in script tags.
   *
   * @param string $module           The name of the module where the log is coming from.
   * @param string $function         The name of the function where the log is coming from.
   * @param string $variableName     The name of the variable to be logged.
   * @param mixed  $content          The content to be logged. This can be any data type that can be JSON encoded.
   * @param bool   $with_script_tags Optional. Whether to wrap the JavaScript code in script tags. Default is true.
   *
   * @return void This function does not return a value. It echoes the generated JavaScript code.
   */
  function consoleLog(
    string $module,
    string $function,
    string $variableName,
    mixed $content,
    bool $with_script_tags = true
  ): void {
    $output = var_export($content, true);
    $js_code = 'console.log(">> [' . $module . '] ' . $function . '() ' . $variableName . ': " + ' . json_encode($output, JSON_HEX_TAG) . ');';

    if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
    }

    echo $js_code;
  }
}

if (!function_exists('getPageHelpUrl')) {
  //---------------------------------------------------------------------------
  /**
   * This function is used to get the help page URL for a given URI.
   *
   * @param string $route The route for which the help page URL is needed.
   *
   * @return string The URL of the help page. If a specific help page URL is set
   * for the given URI in the 'HelpPages' config, that URL is returned.
   * Otherwise, the default help page URL from the 'AppInfo' config is returned.
   */
  function getPageHelpUrl(string $route): string {
    $url = config('Config\AppInfo')->documentationUrl;

    if (isset(config('Config\HelpPages')->url[$route]) && strlen(config('Config\HelpPages')->url[$route]) > 0) {
      $url = config('Config\HelpPages')->url[$route];
    }

    return $url;
  }
}

if (!function_exists('logEvent')) {
  //---------------------------------------------------------------------------
  /**
   * This function logs events to the database.
   *
   * @param array $data Array with event data
   *
   * @return bool Result of the logging
   */
  function logEvent(array $data): bool {
    $logTypes = config('Config\App')->logTypes;
    $S        = model('SettingsModel');

    if (in_array($data['type'], $logTypes) && $S->getSetting('log' . (string)$data['type']) === '1') {
      $LOG = model('LogModel');
      return (bool)$LOG->logEvent($data);
    }

    return false;
  }
}

if (!function_exists('loremIpsum')) {
  //---------------------------------------------------------------------------
  /**
   * This function returns a Lorem Ipsum paragraph.
   *
   * @param bool $long (optional) If true, return a longer paragraph.
   *
   * @return string Lorem Ipsum text.
   */
  function loremIpsum(bool $long = false): string {
    if ($long) {
      return 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?';
    }

    return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
  }
}

if (!function_exists('sanitizeWithAllowedTags')) {
  //---------------------------------------------------------------------------
  /**
   * Sanitizes input while allowing certain HTML tags.
   *
   * @param string $input The input string to sanitize.
   *
   * @return string Sanitized string.
   */
  function sanitizeWithAllowedTags(string $input): string {
    $allowedTags = [
      '<a>',
      '<b>',
      '<br>',
      '<em>',
      '<h1>',
      '<h2>',
      '<h3>',
      '<h4>',
      '<hr>',
      '<i>',
      '<img>',
      '<li>',
      '<ol>',
      '<p>',
      '<strong>',
      '<ul>',
    ];

    // Convert the array of allowed tags to a string
    $allowedTagsString = implode('', $allowedTags);

    // Strip tags except the allowed ones
    return strip_tags($input, $allowedTagsString);
  }
}

if (!function_exists('userAvatar')) {
  //---------------------------------------------------------------------------
  /**
   * This function returns the current user's avatar.
   *
   * @param int|string $userid The user ID
   *
   * @return string The avatar.
   */
  function userAvatar($userid): string {
    $avatar = 'default_male.png';

    if (logged_in()) {
      $UOM    = model('UserOptionModel');
      $option = $UOM->getOption(['user_id' => $userid, 'option' => 'avatar']);

      if ($option) {
        $avatar = $option;
      }
    }

    return $avatar;
  }
}


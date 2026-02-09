<?php

namespace App\Controllers;

class PhpInformationController extends BaseController {
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   *
   */
  public function __construct() {}

  /**
   * --------------------------------------------------------------------------
   * PHPInfo.
   * --------------------------------------------------------------------------
   *
   * Shows the PHPInfo page, formatted in a Bootstrap panel.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function phpinfo(): string {

    $data = [
      'page' => lang('App.phpinfo.title'),
      'config' => $this->config,
      'settings' => $this->settings,
      'output' => $this->getPhpInfoBootstrap(),
    ];

    return $this->_render($this->config->views['phpinformation'], $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Get PHPInfo Bootstrap.
   * --------------------------------------------------------------------------
   *
   * Reads phpinfo() and parses it into a Bootstrap panel display.
   *
   * @return string $output Bootstrap formatted phpinfo() output
   */
  public function getPhpInfoBootstrap(): string {
    $output = '';
    $rowstart = "<div class='row' style='border-bottom: 1px dotted; margin-bottom: 10px; padding-bottom: 10px;'>\n";
    $rowend = "</div>\n";

    ob_start();
    phpinfo(11);
    $phpinfo = array();

    if (preg_match_all('#<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>|<tr(?: class="[^"]*+")?><t[hd](?: class="[^"]*+")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class="[^"]*+")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class="[^"]*+")?>(.*?)\s*</t[hd]>)?)?</tr>#s', ob_get_clean(), $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        if (strlen($match[1])) {
          $phpinfo[$match[1]] = array();
        } elseif (isset($match[3])) {
          $keys1 = array_keys($phpinfo);
          $phpinfo[end($keys1)][$match[2]] = isset($match[4]) ? array( $match[3], $match[4] ) : $match[3];
        } else {
          $keys1 = array_keys($phpinfo);
          $phpinfo[end($keys1)][] = $match[2];
        }
      }
    }

    if (!empty($phpinfo)) {
      foreach ($phpinfo as $section) {
        foreach ($section as $key => $val) {
          $output .= $rowstart;
          if (is_array($val)) {
            $output .= "<div class='col-lg-4 text-bold'>" . $key . "</div>\n<div class='col-lg-4'>" . $val[0] . "</div>\n<div class='col-lg-4'>" . $val[1] . "</div>\n";
          } elseif (is_string($key)) {
            $output .= "<div class='col-lg-4 text-bold'>" . $key . "</div>\n<div class='col-lg-8'>" . $val . "</div>\n";
          } else {
            $output .= "<div class='col-lg-12'>" . $val . "</div>\n";
          }
          $output .= $rowend;
        }
      }
    } else {
      $output .= '<p>An error occurred executing the phpinfo() function. It may not be accessible or disabled. <a href="http://php.net/manual/en/function.phpinfo.php">See the documentation.</a></p>';
    }

    //
    // Some HTML fixes
    //
    $output = str_replace('border="0"', 'style="border: 0px;"', $output);
    $output = str_replace("<font ", "<span ", $output);
    $output = str_replace("</font>", "</span>", $output);

    return $output;
  }
}

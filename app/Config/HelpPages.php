<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class HelpPages extends BaseConfig {
  /**
   * ------------------------------------------------------------------------
   * Links to help pages
   * ------------------------------------------------------------------------
   *
   * If a link is specified for a route, it will be linked to via the help
   * icon at the right end of the page's card header.
   *
   * If no link is specified, the $documentationUrl from the 'AppInfo'
   * is used.
   *
   * Start with http:// or https:// to link to an external page.
   *
   * @var array [route => helpUrl]
   */
  public $url = [
    'about' => '',
    'home' => '',
    'login' => '',
    'sample/view' => '',
    'sample/edit' => '',
    'users' => '',
    'welcome' => '',
  ];

}

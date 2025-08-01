<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AppInfo extends BaseConfig {
  /**
   * ------------------------------------------------------------------------
   * Product Name
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $name = 'CODI';

  /**
   * ------------------------------------------------------------------------
   * Subtitle
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $subtitle = 'Lewe CodeIgniter Boilerplate';

  /**
   * ------------------------------------------------------------------------
   * Product Icon
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $icon = 'bi bi-box-fill';

  /**
   * ------------------------------------------------------------------------
   * Product Version
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $version = '6.0.0';

  /**
   * ------------------------------------------------------------------------
   * Release Date
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $releaseDate = '2025-08-01';

  /**
   * ------------------------------------------------------------------------
   * Product Author
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $author = 'George Lewe';

  /**
   * ------------------------------------------------------------------------
   * Author URL
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $authorUrl = 'https://www.lewe.com';

  /**
   * ------------------------------------------------------------------------
   * Author Email
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $authorEmail = 'george@lewe.com';

  /**
   * ------------------------------------------------------------------------
   * Copyright Entity
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $copyrightBy = 'Lewe';

  /**
   * ------------------------------------------------------------------------
   * Copyright Url
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $copyrightUrl = 'https://www.lewe.com';

  /**
   * ------------------------------------------------------------------------
   * Support Url
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $supportUrl = 'https://github.com/glewe/codi/issues';

  /**
   * ------------------------------------------------------------------------
   * Documentation Url
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $documentationUrl = 'https://lewe.gitbook.io';

  /**
   * ------------------------------------------------------------------------
   * Repo Url
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $repoUrl = 'https://github.com/glewe/codi';

  /**
   * ------------------------------------------------------------------------
   * Download Url
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $downloadUrl = 'https://github.com/glewe/codi/releases';

  /**
   * ------------------------------------------------------------------------
   * Version comparison script
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $versionScript = 'https://support.lewe.com/version/codi.js';

  /**
   * ------------------------------------------------------------------------
   * First Year
   * ------------------------------------------------------------------------
   *
   * First year in which the product was published
   *
   * @var string
   */
  public $firstYear = '2024';

  /**
   * ------------------------------------------------------------------------
   * Key Words
   * ------------------------------------------------------------------------
   *
   * SEO key words
   *
   * @var string
   */
  public $keywords = 'lewe application framework php boilerplate codeigniter 4';

  /**
   * ------------------------------------------------------------------------
   * Description
   * ------------------------------------------------------------------------
   *
   * SEO description
   *
   * @var string
   */
  public $description = 'CODI is a PHP application framework boilerplate based on CodeIgniter 4.';

  /**
   * ------------------------------------------------------------------------
   * Data Privacy Site Information
   * ------------------------------------------------------------------------
   *
   */
  public $siteEntity = 'ACME Inc.';
  public $siteName = 'MySite';
  public $siteOwner = 'John Doe';
  public $siteOwnerAddr1 = 'Street 123';
  public $siteOwnerAddr2 = '1235 Town';
  public $siteOwnerAddr3 = 'Country';
  public $siteOwnerEmail = 'john@doe.com';

  /**
   * ------------------------------------------------------------------------
   * Module Credits
   * ------------------------------------------------------------------------
   *
   */
  public $credits = [
    'bootstrap' => [
      'author' => 'Bootstrap Team',
      'product' => 'Bootstrap Framework',
      'version' => '5.3.7',
      'url' => 'https://getbootstrap.com/',
    ],
    'bootstrap-icons' => [
      'author' => 'Bootstrap Team',
      'product' => 'Bootstrap Icons',
      'version' => '1.13.1',
      'url' => 'https://icons.getbootstrap.com/',
    ],
    'chartjs' => [
      'author' => 'Chart.js Team',
      'product' => 'Chart.js',
      'version' => '4.5.0',
      'url' => 'https://www.chartjs.org/',
    ],
    'codeigniter' => [
      'author' => 'CodeIgniter Team',
      'product' => 'CodeIgniter Framework',
      'version' => '4.6.1',
      'url' => 'https://codeigniter.com/',
    ],
    'datatables' => [
      'author' => 'DataTables Team',
      'product' => 'DataTables',
      'version' => '2.3.2',
      'url' => 'https://datatables.net/',
    ],
    'fontawesome' => [
      'author' => 'Font Awesome Team',
      'product' => 'Font Awesome Icons',
      'version' => '6.7.2',
      'url' => 'https://fontawesome.com/',
    ],
    'freepik' => [
      'author' => 'Freepik',
      'product' => 'Avatar Icons',
      'version' => '',
      'url' => 'https://www.freepik.com/',
    ],
    'googlefonts' => [
      'author' => 'Google Team',
      'product' => 'Google Fonts',
      'version' => '',
      'url' => 'https://www.google.com/fonts/',
    ],
    'garavatarLibrary' => [
      'author' => 'Ivan Tcholakov',
      'product' => 'Gravatar Library',
      'version' => '1.2.0',
      'url' => 'https://github.com/ivantcholakov/Codeigniter-Gravatar',
    ],
    'highlightjs' => [
      'author' => 'Highlight.js Team',
      'product' => 'Highlight.js',
      'version' => '11.9.0',
      'url' => 'https://highlightjs.org/',
    ],
    'iconshock' => [
      'author' => 'Iconshock',
      'product' => 'People Icons',
      'version' => '',
      'url' => 'https://www.iconshock.com/people-icons/',
    ],
    'jquery' => [
      'author' => 'jQuery Team',
      'product' => 'jQuery JavaScript Library',
      'version' => '3.7.1',
      'url' => 'https://jquery.com/',
    ],
    'jquery-ui' => [
      'author' => 'jQuery Team',
      'product' => 'jQuery UI',
      'version' => '1.13.2',
      'url' => 'https://jqueryui.com/',
    ],
    'lightbox2' => [
      'author' => 'Lokesh Dhakar',
      'product' => 'Lightbox2',
      'version' => '2.11.5',
      'url' => 'https://lokeshdhakar.com/projects/lightbox2/',
    ],
    'coloris' => [
      'author' => 'Momo Bassit',
      'product' => 'Coloris Color Picker',
      'version' => '0.24.0',
      'url' => 'https://coloris.js.org/',
    ],
    'cookie-consent' => [
      'author' => 'Osano',
      'product' => 'Cookie Consent',
      'version' => '3.1.1',
      'url' => 'https://cookieconsent.osano.com/',
    ],
    'php' => [
      'author' => 'PHP Team',
      'product' => 'PHP Programming Language',
      'version' => '8.1+',
      'url' => 'https://www.php.net/',
    ],
    'datetime-picker' => [
      'author' => 'XDSoft',
      'product' => 'DateTime Picker',
      'version' => '1.3.6',
      'url' => 'https://xdsoft.net/jqplugins/datetimepicker/',
    ],
  ];

  /**
   * --------------------------------------------------------------------------
   * Show Credits on About page
   * --------------------------------------------------------------------------
   *
   * Set to true to display an expandable section with credits on the
   * About page.
   *
   * @var bool
   */
  public $showCredits = true;

  /**
   * --------------------------------------------------------------------------
   * Show Release Info on About page
   * --------------------------------------------------------------------------
   *
   * Set to true to display an expandable section with release notes on the
   * About page.
   *
   * @var bool
   */
  public $showReleaseInfo = true;
}

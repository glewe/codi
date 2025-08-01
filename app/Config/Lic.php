<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Lic extends BaseConfig {
  /**
   * ------------------------------------------------------------------------
   * Check license switch.
   * ------------------------------------------------------------------------
   *
   * This switch enables or disables the license check. If set to true, the
   * application will check the license key with the license server.
   *
   * If set to false, the application will not check the license key even
   * though you might have added it as a filter for a route. Also,
   * the license page will not be displayed.
   *
   * @var bool
   */
  public $checkLicense = false;

  /**
   * ------------------------------------------------------------------------
   * The license server URL.
   * ------------------------------------------------------------------------
   *
   * This variable specifies the URL of your WordPress server where the license
   * manager plugin is installed on. This server will be contacted from your
   * application to check license keys.
   *
   * @var string
   */
  public $licenseServer = '';

  /**
   * ------------------------------------------------------------------------
   * The secret key.
   * ------------------------------------------------------------------------
   *
   * This variable must contain the value from the License Manager plugin
   * Settings page on your WordPress site. The description of the field there
   * says "Secret Key for License Verification Requests".
   *
   * @var string
   */
  public $secretKey = '';

  /**
   * ------------------------------------------------------------------------
   * The license item reference.
   * ------------------------------------------------------------------------
   *
   * This variable provides a reference label for the licenses which will be
   * issued. Therefore you should enter something specific to describe what
   * the licenses issued are pertaining to.
   *
   * @var string
   */
  public $itemReference = 'CODI';

  /**
   * ------------------------------------------------------------------------
   * Days to expiry warning threshold.
   * ------------------------------------------------------------------------
   *
   * This variable defines the amount of days to expiry after which a warning
   * message is shown to the user.
   *
   * @var int
   */
  public $expiryWarning = 30;

  /**
   * ------------------------------------------------------------------------
   * Views used by Auth Controllers
   * ------------------------------------------------------------------------
   *
   * @var array
   */
  public $views = [

    'license' => 'settings\license',

  ];

  /**
   * ------------------------------------------------------------------------
   * Layout for the views to extend
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $viewLayout = 'layout';
}

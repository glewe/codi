<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class LicInfo extends BaseConfig
{
  /**
   * ------------------------------------------------------------------------
   * Product Name
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $name = 'Lewe CI4 Lic';

  /**
   * ------------------------------------------------------------------------
   * Product Version
   * ------------------------------------------------------------------------
   *
   * @var string
   */
  public $version = '1.1.0';

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
   * Author URL
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
   * First Year
   * ------------------------------------------------------------------------
   *
   * First year in which the product was published
   *
   * @var string
   */
  public $firstYear = '2022';

  /**
   * ------------------------------------------------------------------------
   * Key Words
   * ------------------------------------------------------------------------
   *
   * SEO key words
   *
   * @var string
   */
  public $keyWords = 'lewe codeigniter software license manager';

  /**
   * ------------------------------------------------------------------------
   * Description
   * ------------------------------------------------------------------------
   *
   * SEO description
   *
   * @var string
   */
  public $description = 'A Codeigniter 4 web application including license management.';

  /**
   * ------------------------------------------------------------------------
   * Data Privacy Site Information
   * ------------------------------------------------------------------------
   *
   */
  public $siteName       = 'MySite';
  public $siteOwner      = 'John Doe';
  public $siteOwnerAddr1 = 'Street 123';
  public $siteOwnerAddr2 = '1235 Town';
  public $siteOwnerAddr3 = 'Country';
  public $siteOwnerEmail = 'john@doe.com';
}

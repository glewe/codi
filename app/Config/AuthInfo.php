<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AuthInfo extends BaseConfig
{
  /**
   * --------------------------------------------------------------------------
   * Product Name
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $name = 'Lewe CI4 Auth';

  /**
   * --------------------------------------------------------------------------
   * Product Version
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $version = '3.7.0';

  /**
   * --------------------------------------------------------------------------
   * Product Author
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $author = 'George Lewe';

  /**
   * --------------------------------------------------------------------------
   * Author URL
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $authorUrl = 'https://www.lewe.com';

  /**
   * --------------------------------------------------------------------------
   * Author URL
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $authorEmail = 'george@lewe.com';

  /**
   * --------------------------------------------------------------------------
   * Copyright Entity
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $copyrightBy = 'Lewe';

  /**
   * --------------------------------------------------------------------------
   * Copyright Url
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $copyrightUrl = 'https://www.lewe.com';

  /**
   * --------------------------------------------------------------------------
   * Support Url
   * --------------------------------------------------------------------------
   *
   * @var string
   */
  public string $supportUrl = 'https://github.com/glewe/ci4-auth/issues';

  /**
   * --------------------------------------------------------------------------
   * First Year
   * --------------------------------------------------------------------------
   *
   * First year in which the product was published
   *
   * @var string
   */
  public string $firstYear = '2022';

  /**
   * --------------------------------------------------------------------------
   * Key Words
   * --------------------------------------------------------------------------
   *
   * SEO key words
   *
   * @var string
   */
  public string $keyWords = 'lewe codeigniter 2fa authentication authorization two factor';

  /**
   * --------------------------------------------------------------------------
   * Description
   * --------------------------------------------------------------------------
   *
   * SEO description
   *
   * @var string
   */
  public string $description = 'A Codeigniter 4 web based application including user, group, role and permission management, plus 2FA.';

  /**
   * --------------------------------------------------------------------------
   * Data Privacy Site Information
   * --------------------------------------------------------------------------
   */
  public string $siteName = 'MySite';
  public string $siteOwner = 'John Doe';
  public string $siteOwnerAddr1 = 'Street 123';
  public string $siteOwnerAddr2 = '1235 Town';
  public string $siteOwnerAddr3 = 'Country';
  public string $siteOwnerEmail = 'john@doe.com';
}

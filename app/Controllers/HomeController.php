<?php

namespace App\Controllers;

class HomeController extends BaseController {
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct() {}

  /**
   * --------------------------------------------------------------------------
   * Index.
   * --------------------------------------------------------------------------
   *
   * Show root/home page.
   *
   * @return string
   */
  public function index(): string {
    $data = [
      'page' => lang('App.home.title'),
    ];
    return $this->_render('home', $data);
  }

  /**
   * --------------------------------------------------------------------------
   * About.
   * --------------------------------------------------------------------------
   *
   * Show About page.
   *
   * @return string
   */
  public function about(): string {
    $data = [
      'page' => lang('App.about.about'),
    ];
    return $this->_render('about', $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Data Privacy.
   * --------------------------------------------------------------------------
   *
   * Show data privacy page.
   *
   * @return string
   */
  public function dataprivacy(): string {
    $data = [
      'page' => lang('App.dataprivacy.title'),
    ];
    return $this->_render($this->getLocale() . '/dataprivacy', $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Get Locale.
   * --------------------------------------------------------------------------
   *
   * @return string
   */
  public function getLocale(): string {
    // Default locale
    $locale = $this->config->defaultLocale;
    if ($this->settings->getSetting('defaultLanguage')) {
      // Overwrite with application setting
      $locale = $this->settings->getSetting('defaultLanguage');
    }
    if ($this->session->get('lang')) {
      // Overwrite with session setting
      $locale = $this->session->get('lang');
    }
    return $locale;
  }

  /**
   * --------------------------------------------------------------------------
   * Imprint.
   * --------------------------------------------------------------------------
   *
   * Show Imprint page.
   *
   * @return string
   */
  public function imprint(): string {
    $data = [
      'page' => lang('App.imprint.title'),
    ];
    return $this->_render($this->getLocale() . '/imprint', $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Sample.
   * --------------------------------------------------------------------------
   *
   * Show Sample page.
   *
   * @return string
   */
  public function sample($page = 'view'): string {
    $chartjs = new \App\Libraries\Chartjs();
    $data['chartjs'] = $chartjs;
    if ($page === 'edit') {
      $data['page'] = 'Sample Form';
    } else {
      $data['page'] = 'Sample Page';
    }
    return $this->_render('samples/' . $page, $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Under Maintenance.
   * --------------------------------------------------------------------------
   *
   * Show Under Maintenance page.
   *
   * @return string
   */
  public function undermaintenance(): string {
    $data = [
      'page' => lang('App.imprint.title'),
    ];
    return $this->_render('undermaintenance', $data);
  }
}

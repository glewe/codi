<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\SettingsModel;

class UnderMaintenanceFilter implements FilterInterface {
  //---------------------------------------------------------------------------
  /**
   * Verifies that a user is logged in, or redirects to login.
   *
   * @param RequestInterface $request
   * @param array|null       $arguments
   *
   * @return mixed
   */
  public function before(RequestInterface $request, $arguments = null) {
    $settingsModel = new SettingsModel();
    if (!$settingsModel->getSetting('underMaintenance')) {
      return false;
    }
    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * @param RequestInterface $request
   * @param ResponseInterface $response
   * @param array|null $arguments
   *
   * @return void
   */
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

<?php

declare(strict_types=1);

namespace App\Filters;

use App\Models\SettingsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UnderMaintenanceFilter implements FilterInterface
{
  //---------------------------------------------------------------------------
  /**
   * Verifies that a user is logged in, or redirects to login.
   *
   * @param RequestInterface $request
   * @param array|null       $arguments
   *
   * @return ResponseInterface|string|void
   */
  public function before(RequestInterface $request, $arguments = null) {
    $settingsModel = new SettingsModel();

    if (!$settingsModel->getSetting('underMaintenance')) {
      return;
    }

    return;
  }

  //---------------------------------------------------------------------------
  /**
   * After stage.
   *
   * @param RequestInterface  $request
   * @param ResponseInterface $response
   * @param array|null        $arguments
   *
   * @return ResponseInterface|null
   */
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface {
    return null;
  }
}

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Exceptions\LicException;
use App\Controllers\LicController;
use App\Models\SettingsModel;

class LicFilter implements FilterInterface {
  /**
   * --------------------------------------------------------------------------
   * Before.
   * --------------------------------------------------------------------------
   *
   * Do whatever processing this filter needs to do. By default it should not
   * return anything during normal execution. However, when an abnormal state
   * is found, it should return an instance of CodeIgniter\HTTP\Response. If
   * it does, script execution will end and that Response will be sent back
   * to the client, allowing for error pages, redirects, etc.
   *
   * @param RequestInterface $request
   * @param array|null       $arguments
   *
   * @return mixed
   */
  public function before(RequestInterface $request, $arguments = null) {

    if (empty($arguments)) {
      return false;
    }

    $lic = new LicController();

    if (!$lic->licConfig->checkLicense) {
      return false;
    }

    $lic->readKey();
    $lic->load();
    $error = false;
    $errorMessage = '';

    if ($lic->key === null || $lic->key === "") {
      $redirectURL = '/error_auth';
      unset($_SESSION['redirect_url']);
      return redirect()->to($redirectURL)->with('error', lang('Lic.exception.nokey'));
    }

    switch ($lic->details->status) {
      case "active":
        if (!$lic->domainRegistered()) {
          $error = true;
          $errorMessage =lang('Lic.exception.unregistered');
          break;
        } else {
          return false; // All good
        }
      case "expired":
        $error = true;
        $errorMessage =lang('Lic.exception.expired');
        break;
      case "blocked":
        $error = true;
        $errorMessage =lang('Lic.exception.blocked');
        break;
      case "pending":
        $error = true;
        $errorMessage =lang('Lic.exception.pending');
        break;
      default:
        $error = true;
        $errorMessage =lang('Lic.exception.invalid');
        break;
    }

    if ($error) {
      $redirectURL = '/error_auth';
      unset($_SESSION['redirect_url']);
      return redirect()->to($redirectURL)->with('error', $errorMessage);
    }

    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * After.
   * --------------------------------------------------------------------------
   *
   * Allows After filters to inspect and modify the response object as needed.
   * This method does not allow any way to stop execution of other after filters,
   * short of throwing an Exception or Error.
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
  /**
   * Dumps the entry of a mixed variable for debugging and dies (if set).
   *
   * @param mixed $a   Data to dump
   * @param bool  $die True or false (die or not)
   */
  function dnd($a, $die = true) {
    echo highlight_string("<?php\n\$data =\n" . var_export($a, true) . ";\n?>");
    if ($die) {
      die();
    }
  }
}

<?php

namespace CI4\Auth\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CI4\Auth\Exceptions\PermissionException;

class PermissionFilter implements FilterInterface {
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
    if (!function_exists('logged_in')) {
      helper('auth');
    }

    if (empty($arguments)) {
      return false;
    }

    $authenticate = service('authentication');

    //
    // if no user is logged in then send to the login form
    //
    if (!$authenticate->check()) {
      session()->set('redirect_url', current_url());
      return redirect('login');
    }

    $authorize = service('authorization');
    $result = true;
    //
    // Check each requested permission
    //
    foreach ($arguments as $permission) {
      $result = $result && $authorize->hasPermission($permission, $authenticate->id());
    }

    if (!$result) {
      $redirectURL = ' / error_auth';
      unset($_SESSION['redirect_url']);
      return redirect()->to($redirectURL)->with('error', lang('Auth.exception.insufficient_permissions'));
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
   * @return void
   */
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}

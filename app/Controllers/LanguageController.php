<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserOptionModel;
use App\Models\UserModel;

/**
 * ----------------------------------------------------------------------------
 * Class LanguageController
 * ----------------------------------------------------------------------------
 *
 * This class extends the BaseController and is used to handle the language
 * settings of the application.
 *
 * See: https://onlinewebtutorblog.com/create-multilingual-website-in-codeigniter-4/
 */
class LanguageController extends BaseController {
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * --------------------------------------------------------------------------
   * Index.
   * --------------------------------------------------------------------------
   *
   * The index method is the default method for this controller.
   *
   * It retrieves the current locale from the request, removes any existing
   * 'lang' session variable, sets the 'lang' session variable to the current
   * locale, and then redirects the user to the base URL.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse Redirects the user to the base URL.
   */
  public function index(): \CodeIgniter\HTTP\RedirectResponse {
    // Start a new session
    $session = session();

    // Get the current locale from the request
    $locale = $this->request->getLocale();

    // Remove any existing 'lang' session variable
    $session->remove('lang');

    // Set the 'lang' session variable to the current locale
    $session->set('lang', $locale);

    if (user_id()) {
      //
      // If a user is logged in, update the user's language preference.
      //
      $users = model(UserModel::class);
      $userOptions = model(UserOptionModel::class);
      if ($users->where('id', user_id())->first()) {
        //
        // User found, update the user's language preference.
        //
        $userOptions->saveOption([ 'user_id' => user_id(), 'option' => 'language', 'value' => $locale ]);
      }
    }

    // Redirect the user to the base URL
//    $url = base_url();
//    return redirect()->to($url); // Redirect to the base URL

    // Redirect the user back to the previous page
    return redirect()->back();
  }
}

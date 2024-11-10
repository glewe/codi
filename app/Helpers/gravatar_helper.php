<?php

/**
 * ============================================================================
 * Gravatar Helper Functions
 *
 * @author  Ivan Tcholakov <ivantcholakov@gmail.com>, 2015
 * @license The MIT License, http://opensource.org/licenses/MIT
 * ============================================================================
 */

if (!function_exists('gravatar')) {
  /**
   * --------------------------------------------------------------------------
   * Gravatar.
   * --------------------------------------------------------------------------
   *
   * Generates a Gravatar URL or an image tag for a specified email address.
   * This helper function has been added here for compatibility with PyroCMS.
   *
   * This function retrieves the Gravatar URL for the given email address and
   * returns either the URL or an HTML image tag, depending on the $url_only
   * parameter.
   *
   * @param string $email    The email address to get the Gravatar for.
   * @param int    $size     The size of the Gravatar image in pixels.
   * @param string $rating   The maximum allowed rating (e.g., 'g', 'pg', 'r', 'x').
   * @param bool   $url_only Whether to return only the URL (true) or an HTML image tag (false).
   * @param mixed  $default  The default image URL or a boolean false for the default Gravatar image.
   *
   * @return string The Gravatar URL or an HTML image tag.
   */
  function gravatar($email = '', $size = 50, $rating = 'g', $url_only = false, $default = false) {
    $ci = &get_instance();
    $ci->load->library('gravatar');
    if (@ (string)$default == '') {
      $default = null;
    }
    $gravatar_url = $ci->gravatar->get($email, $size, $default, null, $rating);
    if ($url_only) {
      return $gravatar_url;
    }
    return '<img src="' . $gravatar_url . '" alt="Gravatar" class="gravatar" />';
  }
}

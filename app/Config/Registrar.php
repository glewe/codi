<?php

declare(strict_types=1);

namespace Config;

use Closure;

/**
 * Helper class that will register our bulk plugins and filters with the View
 * Parser class.
 *
 * Called automatically by Config\View as long as this file is setup as a
 * Registrar:
 *
 * protected $registrars = [
 *   \Myth\Template\Registrar::class
 * ];
 */
class Registrar
{
  //---------------------------------------------------------------------------
  /**
   * Registers the View plugins.
   *
   * @return array<string, array<string, list<Closure>>> The view plugins to register.
   */
  public static function View(): array {
    return [
      'plugins' => [
        'logged_in'  => [
          function ($str, array $params = []) {
            return service('authentication')->check() ? $str : '';
          }
        ],
        'logged_out' => [
          function ($str, array $params = []) {
            return !service('authentication')->check() ? $str : '';
          }
        ],
      ]
    ];
  }
}

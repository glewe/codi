<?php

declare(strict_types=1);

namespace App\Authentication\Resetters;

use App\Entities\User;

class UserResetter extends BaseResetter implements ResetterInterface
{
  //---------------------------------------------------------------------------
  /**
   * Sends reset message to the user via specified class
   * in `$activeResetter` setting in Config\Auth.php.
   *
   * @param User|null $user
   *
   * @return bool
   */
  public function send(?User $user = null): bool {
    if ($this->config->activeResetter === null) {
      return true;
    }

    $className = $this->config->activeResetter;

    $class = new $className();
    $class->setConfig($this->config);

    if ($class->send($user) === false) {
      log_message('error', str_replace('{0}', $user->username, lang('Auth.forgot.error_reset')));
      $this->error = $class->error();

      return false;
    }

    return true;
  }
}

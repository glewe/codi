<?php

declare(strict_types=1);

namespace App\Authentication\Activators;

use App\Entities\User;
use Config\Email;

class EmailActivator extends BaseActivator implements ActivatorInterface
{
  //---------------------------------------------------------------------------
  /**
   * Sends an activation email.
   *
   * @param User|null $user
   *
   * @return bool
   */
  public function send(?User $user = null): bool {
    $email = service('email');
    $config = new Email();

    $settings = $this->getActivatorSettings();

    $sent = $email->setFrom($settings->fromEmail ?? $config->fromEmail, $settings->fromName ?? $config->fromName)
      ->setTo($user->email)
      ->setSubject(lang('Auth.activation.subject'))
      ->setMessage(view($this->config->views['emailActivation'], ['hash' => $user->activate_hash]))
      ->setMailType('html')
      ->send();

    if (!$sent) {
      $this->error = str_replace('{0}', $user->email, lang('Auth.activation.error_sending'));
      return false;
    }

    return true;
  }
}

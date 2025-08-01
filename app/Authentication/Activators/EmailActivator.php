<?php

namespace App\Authentication\Activators;

use Config\Email;
use App\Entities\User;

/**
 * Class EmailActivator
 *
 * Sends an activation email to user.
 *
 * @package App\Authentication\Activators
 */
class EmailActivator extends BaseActivator implements ActivatorInterface {
  /**
   * --------------------------------------------------------------------------
   * Send.
   * --------------------------------------------------------------------------
   *
   * Sends an activation email
   *
   * @param User $user
   *
   * @return bool
   */
  public function send(User $user = null): bool {
    $email = service('email');
    $config = new Email();

    $settings = $this->getActivatorSettings();

    $sent = $email->setFrom($settings->fromEmail ?? $config->fromEmail, $settings->fromName ?? $config->fromName)
      ->setTo($user->email)
      ->setSubject(lang('Auth.activation.subject'))
      ->setMessage(view($this->config->views['emailActivation'], [ 'hash' => $user->activate_hash ]))
      ->setMailType('html')
      ->send();

    if (!$sent) {

      $this->error = lang('Auth.activation.error_sending', [ $user->email ]);
      return false;
    }

    return true;
  }
}

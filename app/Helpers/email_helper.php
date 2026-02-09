<?php

declare(strict_types=1);

use App\Models\SettingsModel;

/**
 * ============================================================================
 * Email Helper Functions
 * ============================================================================
 */

if (!function_exists('sendEmail')) {
  //---------------------------------------------------------------------------
  /**
   * Sends an email with the provided parameters.
   *
   * @param string $to        The recipient's email address. If not provided, defaults to 'george.lewe@gmail.com'.
   * @param string $cc        The CC recipient's email address. If not provided, defaults to an empty string.
   * @param string $bcc       The BCC recipient's email address. If not provided, defaults to an empty string.
   * @param string $subject   The subject of the email. If not provided, defaults to 'Email Test'.
   * @param string $message   The body of the email. If not provided, defaults to 'Testing the email class.'.
   * @param string $recipient The name of the recipient.
   * @param bool   $onScreen  Whether to display the email on screen instead of sending.
   *
   * @return bool Returns true if the email was successfully sent, false otherwise.
   */
  function sendEmail(
    string $to = '',
    string $cc = '',
    string $bcc = '',
    string $subject = '',
    string $message = '',
    string $recipient = 'User',
    bool $onScreen = false
  ): bool {
    $settings = model(SettingsModel::class);
    $email    = initializeEmail();

    if ($email === false) {
      return false;
    }

    if (!strlen($to)) {
      return false;
    }

    $email->setTo($to);
    $email->setCC($cc);
    $email->setBCC($bcc);

    if (!strlen($subject)) {
      $email->setSubject('Email Test');
    } else {
      $email->setSubject($subject);
    }

    //
    // Now, build the email body based on the template file.
    //
    $data = [
      'summary'        => 'This is the body summary',
      'greeting'       => lang('General.hello'),
      'recipient'      => $recipient,
      'message'        => $message,
      'signature'      => lang('General.your_team', [$settings->getSetting('applicationName')]),
      'button'         => false,
      'button_url'     => '',
      'button_message' => '',
      'button_text'    => '',
      'footer_message' => 'Powered by ' . config('AppInfo')->name . ' ' . config('AppInfo')->version,
    ];

    if ($onScreen) {
      echo buildEmailBody($data);
      return true;
    }

    $email->setMessage(buildEmailBody($data));

    return $email->send();
  }
}

if (!function_exists('sendActivationEmail')) {
  //---------------------------------------------------------------------------
  /**
   * Sends the account activation email.
   *
   * @param object $user     The user to reset the password for.
   * @param bool   $onScreen Whether to display the email on screen instead of sending.
   *
   * @return bool Returns true if the email was successfully sent, false otherwise.
   */
  function sendActivationEmail(object $user, bool $onScreen = false): bool {
    /** @var \App\Entities\User $user */
    $settings = model(SettingsModel::class);
    $email    = initializeEmail();

    if ($email === false) {
      return false;
    }

    $email->setTo($user->email);
    $email->setSubject(lang('Auth.activation.subject'));

    $message = loadEmailMessage('activation');
    $message = str_replace('%site_url%', base_url(), $message);
    $message = str_replace('%token%', $user->activate_hash, $message);

    //
    // Now, build the email body based on the template file.
    //
    $data = [
      'summary'        => lang('Auth.activation.subject'),
      'greeting'       => lang('General.hello'),
      'recipient'      => $user->username,
      'message'        => $message,
      'signature'      => lang('General.your_team', [$settings->getSetting('applicationName')]),
      'footer_message' => 'Powered by ' . config('AppInfo')->name . ' ' . config('AppInfo')->version,
    ];

    if ($onScreen) {
      echo buildEmailBody($data);
      die();
    }

    $email->setMessage(buildEmailBody($data));

    return $email->send();
  }
}

if (!function_exists('sendResetEmail')) {
  //---------------------------------------------------------------------------
  /**
   * Sends an reset password email.
   *
   * @param object $user     The user to reset the password for.
   * @param bool   $onScreen Whether to display the email on screen instead of sending.
   *
   * @return bool Returns true if the email was successfully sent, false otherwise.
   */
  function sendResetEmail(object $user, bool $onScreen = false): bool {
    /** @var \App\Entities\User $user */
    $settings = model(SettingsModel::class);
    $email    = initializeEmail();

    if ($email === false) {
      return false;
    }

    $email->setTo($user->email);
    $email->setSubject(lang('Auth.forgot.subject'));

    $message = loadEmailMessage('reset_password');
    $message = str_replace('%site_url%', base_url(), $message);
    $message = str_replace('%token%', $user->reset_hash, $message);

    //
    // Now, build the email body based on the template file.
    //
    $data = [
      'summary'        => lang('Auth.forgot.subject'),
      'greeting'       => lang('General.hello'),
      'recipient'      => $user->username,
      'message'        => $message,
      'signature'      => lang('General.your_team', [$settings->getSetting('applicationName')]),
      'footer_message' => 'Powered by ' . config('AppInfo')->name . ' ' . config('AppInfo')->version,
    ];

    if ($onScreen) {
      echo buildEmailBody($data);
      die();
    }

    $email->setMessage(buildEmailBody($data));

    return $email->send();
  }
}

if (!function_exists('buildEmailBody')) {
  //---------------------------------------------------------------------------
  /**
   * Builds the email body based on the template file. The following variables
   * are available:
   *
   * - %site_url% - The URL of the site (to load images from)
   * - %app_name% - The application name
   * - %summary% - The summary of the email body (not the summary of the email message)
   * - %greeting$ - The greeting phrase of the email message
   * - %recipient% - The name of the recipient
   * - %message% - The message of the email
   * - %signature% - The signature of the email
   * - %button% - Whether to add a button to the mail (true/false)
   * - %button_url% - The URL of the button
   * - %button_message% - The message above the button
   * - %button_text% - The text of the button
   * - %footer_message% - The footer message of the email
   *
   * @param array $data Array with variables to put into the body template.
   *
   * @return string The email message body.
   */
  function buildEmailBody(array $data): string {
    $settings = model(SettingsModel::class);
    $body     = loadEmailTemplate();

    $body = str_replace('%site_url%', base_url(), $body);
    $body = str_replace('%app_name%', $settings->getSetting('applicationName'), $body);
    $body = str_replace('%summary%', (string)$data['summary'], $body);
    $body = str_replace('%greeting%', (string)$data['greeting'], $body);
    $body = str_replace('%recipient%', (string)$data['recipient'], $body);
    $body = str_replace('%message%', (string)$data['message'], $body);
    $body = str_replace('%signature%', (string)$data['signature'], $body);
    $body = str_replace('%footer_message%', (string)$data['footer_message'], $body);

    return $body;
  }
}

if (!function_exists('initializeEmail')) {
  //---------------------------------------------------------------------------
  /**
   * Initializes the email service.
   *
   * @return \CodeIgniter\Email\Email|false Returns the result true or false.
   */
  function initializeEmail(): \CodeIgniter\Email\Email|false {
    $settings = model(SettingsModel::class);
    $email    = \Config\Services::email();

    //
    // Initialize the email settings.
    //
    $config['mailType'] = 'html';
    $config['protocol'] = 'sendmail';

    if ($settings->getSetting('emailSMTP')) {
      $config['protocol']   = 'smtp';
      $config['SMTPHost']   = $settings->getSetting('emailSMTPhost');
      $config['SMTPPort']   = $settings->getSetting('emailSMTPport');
      $config['SMTPUser']   = $settings->getSetting('emailSMTPusername');
      $config['SMTPPass']   = $settings->getSetting('emailSMTPpassword');
      $config['SMTPCrypto'] = ($settings->getSetting('emailSMTPCrypto') !== 'none') ? $settings->getSetting('emailSMTPCrypto') : '';
    }

    if (!$email->initialize($config)) {
      return false;
    }

    $email->setFrom($settings->getSetting('emailReply'), $settings->getSetting('emailFrom'));
    $email->setReplyTo($settings->getSetting('emailReply'), $settings->getSetting('emailReply'));

    return $email;
  }
}

if (!function_exists('loadEmailMessage')) {
  //---------------------------------------------------------------------------
  /**
   * Loads the email message type template file.
   *
   * @param string $message The message type to load.
   *
   * @return string The email template file.
   */
  function loadEmailMessage(string $message = ''): string {
    $session = service('session');

    if (!strlen($message)) {
      return '';
    }

    return (string)file_get_contents(APPPATH . 'Views/emails/' . (string)$session->get('lang') . '/' . $message . '.html');
  }
}

if (!function_exists('loadEmailTemplate')) {
  //---------------------------------------------------------------------------
  /**
   * Loads the basic email template file.
   *
   * @return string The email template file.
   */
  function loadEmailTemplate(): string {
    return (string)file_get_contents(APPPATH . 'Views/emails/template.html');
  }
}


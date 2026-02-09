<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
  /**
   * The from email address
   *
   * @var string
   */
  public string $fromEmail = 'support@lewe.com';

  /**
   * The name to associate with the sender
   *
   * @var string
   */
  public string $fromName = 'Lewe Support';

  /**
   * The recipient email address/es
   *
   * @var string
   */
  public string $recipients = '';

  /**
   * The "user agent"
   *
   * @var string
   */
  public string $userAgent = 'CODI';

  /**
   * The mail sending protocol: mail, sendmail, smtp
   *
   * @var string
   */
  public string $protocol = 'mail';

  /**
   * The server path to Sendmail.
   *
   * @var string
   */
  public string $mailPath = '/usr/sbin/sendmail';

  /**
   * SMTP Server Hostname
   *
   * @var string
   */
  public string $SMTPHost = '';

  /**
   * SMTP Username
   *
   * @var string
   */
  public string $SMTPUser = '';

  /**
   * SMTP Password
   *
   * @var string
   */
  public string $SMTPPass = '';

  /**
   * SMTP Port
   *
   * @var int
   */
  public int $SMTPPort = 465;

  /**
   * SMTP Timeout (in seconds)
   *
   * @var int
   */
  public int $SMTPTimeout = 30;

  /**
   * Enable persistent SMTP connections
   *
   * @var bool
   */
  public bool $SMTPKeepAlive = false;

  /**
   * SMTP Encryption.
   *
   * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
   *             to the server. 'ssl' means implicit SSL. Connection on port
   *             465 should set this to ''.
   */
  public string $SMTPCrypto = 'tls';

  /**
   * Enable word-wrap
   *
   * @var bool
   */
  public bool $wordWrap = true;

  /**
   * Character count to wrap at
   *
   * @var int
   */
  public int $wrapChars = 76;

  /**
   * Type of mail, either 'text' or 'html'
   *
   * @var string
   */
  public string $mailType = 'text';

  /**
   * Character set (utf-8, iso-8859-1, etc.)
   *
   * @var string
   */
  public string $charset = 'UTF-8';

  /**
   * Whether to validate the email address
   *
   * @var bool
   */
  public bool $validate = false;

  /**
   * Email Priority. 1 = highest. 5 = lowest. 3 = normal
   *
   * @var int
   */
  public int $priority = 3;

  /**
   * Newline character. (Use “\r\n” to comply with RFC 822)
   *
   * @var string
   */
  public string $CRLF = "\r\n";

  /**
   * Newline character. (Use “\r\n” to comply with RFC 822)
   *
   * @var string
   */
  public string $newline = "\r\n";

  /**
   * Enable BCC Batch Mode.
   *
   * @var bool
   */
  public bool $BCCBatchMode = false;

  /**
   * Number of emails in each BCC batch
   *
   * @var int
   */
  public int $BCCBatchSize = 200;

  /**
   * Enable notify message from server
   *
   * @var bool
   */
  public bool $DSN = false;
}

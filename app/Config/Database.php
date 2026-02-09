<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
  /**
   * The directory that holds the Migrations
   * and Seeds directories.
   *
   * @var string
   */
  public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

  /**
   * Lets you choose which connection group to
   * use if no other is specified.
   *
   * @var string
   */
  public string $defaultGroup = 'default';

  /**
   * The default database connection.
   *
   * @var array
   */
  public array $default = [
    'DSN'          => '',
    'hostname'     => 'localhost',
    'username'     => 'root',
    'password'     => '',
    'database'     => 'codi',
    'DBDriver'     => 'MySQLi',
    'DBPrefix'     => '',
    'pConnect'     => false,
    'DBDebug'      => true,
    'charset'      => 'utf8',
    'DBCollat'     => 'utf8_general_ci',
    'swapPre'      => '',
    'encrypt'      => false,
    'compress'     => false,
    'strictOn'     => false,
    'failover'     => [],
    'port'         => 3306,
    'numberNative' => false,
  ];

  /**
   * This database connection is used when running PHPUnit database tests.
   *
   * @var array
   */
  public array $tests = [
    'DSN'         => '',
    'hostname'    => '127.0.0.1',
    'username'    => '',
    'password'    => '',
    'database'    => ':memory:',
    'DBDriver'    => 'SQLite3',
    'DBPrefix'    => 'db_',  // Needed to ensure we're working correctly with prefixes live. DO NOT REMOVE FOR CI DEVS
    'pConnect'    => false,
    'DBDebug'     => true,
    'charset'     => 'utf8',
    'DBCollat'    => 'utf8_general_ci',
    'swapPre'     => '',
    'encrypt'     => false,
    'compress'    => false,
    'strictOn'    => false,
    'failover'    => [],
    'port'        => 3306,
    'foreignKeys' => true,
    'busyTimeout' => 1000,
  ];

  //---------------------------------------------------------------------------
  /**
   * This database connection is used when running PHPUnit database tests.
   */
  public function __construct() {
    parent::__construct();

    // Ensure that we always set the database group to 'tests' if we are
    // currently running an automated test suite, so thatwe don't
    // overwrite live data on accident.
    if (ENVIRONMENT === 'testing') { // @phpstan-ignore-line
      $this->defaultGroup = 'tests';
    }
  }
}

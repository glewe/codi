<?php

declare(strict_types=1);

namespace App\Commands;

use App\Entities\User;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class HashPassword extends BaseCommand
{
  protected $group = 'Auth';
  protected $name = 'auth:hash_password';
  protected $description = 'Hashes given password.';

  protected $usage = 'auth:hash_password [password]';

  /**
   * @var array<string, string>
   */
  protected $arguments = [
    'password' => 'Password value you want to hash.',
  ];

  //---------------------------------------------------------------------------
  /**
   * This method is responsible for hashing a given password.
   * It takes an array of parameters as input, which should contain the password.
   * If the password is not provided, it prompts the user to enter it.
   * It then creates a new User entity and assigns the provided password to it.
   * The password is then hashed using the User entity's password hashing mechanism.
   * The hashed password is then outputted to the console.
   *
   * @param array $params An array of parameters. The first element should be the password.
   *
   * @return void
   */
  public function run(array $params = []): void {
    // Consume or prompt for password
    $password = array_shift($params);

    if (empty($password)) {
      $password = CLI::prompt('Password', null, 'required');
    }

    $user = new User();
    $user->password = $password;

    // write to console
    CLI::write('Hash: ' . $user->password_hash, 'green');
  }
}

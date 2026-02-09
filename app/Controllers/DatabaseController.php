<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Authorization\FlatAuthorization;
use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Seeder;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Validation\Validation;

/**
 * Class DatabaseController
 */
class DatabaseController extends BaseController
{
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var string Log type used in log entries from this controller.
   */
  protected string $logType;

  /**
   * @var Forge
   */
  protected Forge $forge;

  /**
   * @var Seeder
   */
  protected Seeder $seeder;

  /**
   * @var Validation
   */
  protected Validation $validation;

  /**
   * @var FlatAuthorization
   */
  protected FlatAuthorization $authorize;

  //---------------------------------------------------------------------------
  /**
   * Constructor.
   */
  public function __construct() {
    //
    // Most services in this controller require the session to be started
    //
    $this->validation = service('validation');
    $this->logType    = 'Database';
    $this->authorize  = service('authorization');
    $this->forge      = \Config\Database::forge();
    $this->seeder     = \Config\Database::seeder();
  }

  //---------------------------------------------------------------------------
  /**
   * Handles the database administration page.
   *
   * @return RedirectResponse|string
   */
  public function database(): RedirectResponse|string {
    // ,-------------------,
    // | Optimize Database |
    // '-------------------'
    if (array_key_exists('btn_optimize', $this->request->getPost())) {
      $dbutil = \Config\Database::utils();
      $result = $dbutil->optimizeDatabase();
      if ($result !== false) {
        //
        // Success! Go back from where the user came.
        //
        logEvent(
          [
            'type'  => $this->logType,
            'event' => lang('Database.optimize_success'),
            'user'  => user_username(),
            'ip'    => $this->request->getIPAddress(),
          ]
        );
        return redirect()->back()->withInput()->with('success', lang('Database.optimize_success'));
      }
    }

    // ,-------,
    // | Reset |
    // '-------'
    if (array_key_exists('btn_reset', $this->request->getPost())) {
      $validationRules = [
        'txt_resetConfirm' => [
          'label'  => lang('Database.resetConfirm'),
          'rules'  => 'exact_value[YesIAmSure]',
          'errors' => [
            'exact_value' => lang('Validation.exact_value', ['YesIAmSure']),
          ],
        ],
      ];
      //
      // Get form fields for validation
      //
      $form['txt_resetConfirm'] = $this->request->getPost('txt_resetConfirm', FILTER_SANITIZE_STRING);
      //
      // Validate input
      //
      $this->validation->setRules($validationRules);
      if (!$this->validation->run($form)) {
        //
        // Return validation error
        //
        return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
      }
      else {
        $this->dropTables();
        $this->createTables();
        $this->seeder->call('App\Database\Seeds\UserSeeder');
        $this->seeder->call('App\Database\Seeds\PermissionSeeder');
        $this->seeder->call('App\Database\Seeds\GroupSeeder');
        $this->seeder->call('App\Database\Seeds\RoleSeeder');
        $this->seeder->call('App\Database\Seeds\SettingsSeeder');
        $this->seeder->call('App\Database\Seeds\GroupsUsersSeeder');
        $this->seeder->call('App\Database\Seeds\RolesUsersSeeder');
        $this->seeder->call('App\Database\Seeds\RolesPermissionsSeeder');
        $this->seeder->call('App\Database\Seeds\UserOptionsSeeder');
        //
        // Success! Go back from where the user came.
        //
        logEvent(
          [
            'type'  => $this->logType,
            'event' => lang('Database.reset_success'),
            'user'  => user_username(),
            'ip'    => $this->request->getIPAddress(),
          ]
        );
        return redirect()->back()->withInput()->with('success', lang('Database.reset_success'));
      }
    }

    return $this->_render(
      $this->config->views['database'],
      [
        'page'   => lang('Database.pageTitle'),
        'config' => $this->config,
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Drops all tables in the database.
   *
   * @return void
   */
  public function dropTables(): void {
    //
    // Drop tables
    //
    $this->forge->dropTable('users', true);
    $this->forge->dropTable('users_options', true);
    $this->forge->dropTable('logins', true);
    $this->forge->dropTable('tokens', true);
    $this->forge->dropTable('reset_attempts', true);
    $this->forge->dropTable('activation_attempts', true);
    $this->forge->dropTable('roles', true);
    $this->forge->dropTable('permissions', true);
    $this->forge->dropTable('roles_permissions', true);
    $this->forge->dropTable('roles_users', true);
    $this->forge->dropTable('users_permissions', true);
    $this->forge->dropTable('groups', true);
    $this->forge->dropTable('groups_users', true);
    $this->forge->dropTable('groups_permissions', true);
    $this->forge->dropTable('settings', true);
    $this->forge->dropTable('log', true);
    $this->forge->dropTable('migrations', true);
  }

  //---------------------------------------------------------------------------
  /**
   * Creates all tables in the database.
   *
   * @return void
   */
  public function createTables(): void {
    //
    // Users Table
    //
    $this->forge->addField([
      'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'email'            => ['type' => 'varchar', 'constraint' => 255],
      'username'         => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
      'lastname'         => ['type' => 'varchar', 'constraint' => 120],
      'firstname'        => ['type' => 'varchar', 'constraint' => 120],
      'displayname'      => ['type' => 'varchar', 'constraint' => 120],
      'hidden'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
      'password_hash'    => ['type' => 'varchar', 'constraint' => 255],
      'secret_hash'      => ['type' => 'varchar', 'constraint' => 255],
      'reset_hash'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'reset_at'         => ['type' => 'datetime', 'null' => true],
      'reset_expires'    => ['type' => 'datetime', 'null' => true],
      'activate_hash'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'status_message'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'active'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
      'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
      'created_at'       => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'       => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
      'deleted_at'       => ['type' => 'datetime', 'null' => true],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('email');
    $this->forge->addUniqueKey('username');
    $this->forge->createTable('users', true);

    //
    // Logins Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
      'date'       => ['type' => 'datetime'],
      'success'    => ['type' => 'tinyint', 'constraint' => 1],
      'info'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('email');
    $this->forge->addKey('user_id');
    // NOTE: Do NOT delete the user_id or email when the user is deleted for security audits
    $this->forge->createTable('logins', true);

    //
    // Tokens Table
    // @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
    //
    $this->forge->addField([
      'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'selector'        => ['type' => 'varchar', 'constraint' => 255],
      'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
      'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
      'expires'         => ['type' => 'datetime'],
      'created_at'      => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'      => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('selector');
    $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
    $this->forge->createTable('tokens', true);

    //
    // Reset Attempts Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'email'      => ['type' => 'varchar', 'constraint' => 255],
      'ip_address' => ['type' => 'varchar', 'constraint' => 255],
      'user_agent' => ['type' => 'varchar', 'constraint' => 255],
      'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('reset_attempts', true);

    //
    // Activation Attempts Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'ip_address' => ['type' => 'varchar', 'constraint' => 255],
      'user_agent' => ['type' => 'varchar', 'constraint' => 255],
      'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('activation_attempts', true);

    //
    // Roles Table
    //
    $this->forge->addField([
      'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'name'        => ['type' => 'varchar', 'constraint' => 255],
      'description' => ['type' => 'varchar', 'constraint' => 255],
      'bscolor'     => ['type' => 'varchar', 'constraint' => 16, 'default' => 'primary'],
      'created_at'  => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'  => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('roles', true);

    //
    // Permissions Table
    //
    $this->forge->addField([
      'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'name'        => ['type' => 'varchar', 'constraint' => 255],
      'description' => ['type' => 'varchar', 'constraint' => 255],
      'created_at'  => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'  => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('permissions', true);

    //
    // Roles_Permissions Table
    //
    $this->forge->addField([
      'role_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'created_at'    => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'    => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey(['role_id', 'permission_id']);
    $this->forge->addForeignKey('role_id', 'roles', 'id', '', 'CASCADE');
    $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', 'CASCADE');
    $this->forge->createTable('roles_permissions', true);

    //
    // Roles_Users Table
    //
    $this->forge->addField([
      'role_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey(['role_id', 'user_id']);
    $this->forge->addForeignKey('role_id', 'roles', 'id', '', 'CASCADE');
    $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
    $this->forge->createTable('roles_users', true);

    //
    // Users_Permissions Table
    //
    $this->forge->addField([
      'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'created_at'    => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'    => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey(['user_id', 'permission_id']);
    $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
    $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', 'CASCADE');
    $this->forge->createTable('users_permissions', true);

    //
    // Groups Table
    //
    $this->forge->addField([
      'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'name'        => ['type' => 'varchar', 'constraint' => 255],
      'description' => ['type' => 'varchar', 'constraint' => 255],
      'created_at'  => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'  => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('groups', true);

    //
    // Groups_Users Table
    //
    $this->forge->addField([
      'group_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey(['group_id', 'user_id']);
    $this->forge->addForeignKey('group_id', 'groups', 'id', '', 'CASCADE');
    $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
    $this->forge->createTable('groups_users', true);

    //
    // Groups_Permissions Table
    //
    $this->forge->addField([
      'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'created_at'    => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at'    => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey(['group_id', 'permission_id']);
    $this->forge->addForeignKey('group_id', 'groups', 'id', '', 'CASCADE');
    $this->forge->addForeignKey('permission_id', 'permissions', 'id', '', 'CASCADE');
    $this->forge->createTable('groups_permissions', true);

    //
    // Settings Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'key'        => ['type' => 'varchar', 'constraint' => 255],
      'value'      => ['type' => 'text'],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('key');
    $this->forge->createTable('settings', true);

    //
    // Users_Options Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
      'option'     => ['type' => 'varchar', 'constraint' => 255],
      'value'      => ['type' => 'varchar', 'constraint' => 255],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey(['user_id', 'option']);
    $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
    $this->forge->createTable('users_options', true);

    //
    // Log Table
    //
    $this->forge->addField([
      'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
      'type'       => ['type' => 'varchar', 'constraint' => 80],
      'user'       => ['type' => 'varchar', 'constraint' => 80],
      'ip'         => ['type' => 'varchar', 'constraint' => 80],
      'event'      => ['type' => 'varchar', 'constraint' => 255],
      'created_at' => ['type' => 'timestamp DEFAULT current_timestamp()', 'null' => false],
      'updated_at' => ['type' => 'timestamp DEFAULT current_timestamp() ON UPDATE current_timestamp()', 'null' => false],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('log', true);
  }
}

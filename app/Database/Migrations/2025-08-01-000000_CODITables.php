<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CODITables extends Migration
{
  //---------------------------------------------------------------------------
  /**
   * Create Tables
   */
  public function up() {
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

  //---------------------------------------------------------------------------
  /**
   * Rollback Tables
   */
  public function down() {
    //
    // Drop constraints first to prevent errors
    //
    if ($this->db->DBDriver != 'SQLite3') { // @phpstan-ignore-line
      $this->forge->dropForeignKey('users_options', 'users_options_user_id_foreign');
      $this->forge->dropForeignKey('tokens', 'tokens_user_id_foreign');
      $this->forge->dropForeignKey('roles_permissions', 'roles_permissions_role_id_foreign');
      $this->forge->dropForeignKey('roles_permissions', 'roles_permissions_permission_id_foreign');
      $this->forge->dropForeignKey('roles_users', 'roles_users_role_id_foreign');
      $this->forge->dropForeignKey('roles_users', 'roles_users_user_id_foreign');
      $this->forge->dropForeignKey('users_permissions', 'users_permissions_user_id_foreign');
      $this->forge->dropForeignKey('users_permissions', 'users_permissions_permission_id_foreign');
      $this->forge->dropForeignKey('groups_users', 'groups_users_group_id_foreign');
      $this->forge->dropForeignKey('groups_users', 'groups_users_user_id_foreign');
      $this->forge->dropForeignKey('groups_permissions', 'groups_permissions_group_id_foreign');
      $this->forge->dropForeignKey('groups_permissions', 'groups_permissions_permission_id_foreign');
    }

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
  }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder {
  //---------------------------------------------------------------------------
  /**
   * Seed the 'permissions' table.
   */
  public function run() {
    $records = array(
      [ 'name' => 'application.manage', 'description' => 'Allows to manage all settings of the application' ],
      [ 'name' => 'database.edit', 'description' => 'Allows to manage database records' ],
      [ 'name' => 'group.create', 'description' => 'Allows to create groups' ],
      [ 'name' => 'group.delete', 'description' => 'Allows to delete groups' ],
      [ 'name' => 'group.edit', 'description' => 'Allows to edit groups' ],
      [ 'name' => 'group.view', 'description' => 'Allows to view groups' ],
      [ 'name' => 'log.delete', 'description' => 'Allows to delete the application log' ],
      [ 'name' => 'log.edit', 'description' => 'Allows to edit application log' ],
      [ 'name' => 'log.view', 'description' => 'Allows to view application log' ],
      [ 'name' => 'options.manage', 'description' => 'Allows to manage calendar options' ],
      [ 'name' => 'permission.create', 'description' => 'Allows to create permissions' ],
      [ 'name' => 'permission.delete', 'description' => 'Allows to delete permissions' ],
      [ 'name' => 'permission.edit', 'description' => 'Allows to edit permissions' ],
      [ 'name' => 'permission.view', 'description' => 'Allows to view permissions' ],
      [ 'name' => 'role.create', 'description' => 'Allows to create roles' ],
      [ 'name' => 'role.delete', 'description' => 'Allows to delete roles' ],
      [ 'name' => 'role.edit', 'description' => 'Allows to edit roles' ],
      [ 'name' => 'role.view', 'description' => 'Allows to view roles' ],
      [ 'name' => 'user.create', 'description' => 'Allows to create users' ],
      [ 'name' => 'user.delete', 'description' => 'Allows to delete users' ],
      [ 'name' => 'user.edit', 'description' => 'Allows to edit users' ],
      [ 'name' => 'user.view', 'description' => 'Allows to view users' ],
    );

    //
    // Simple Queries
    //
    // $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

    //
    // Insert records
    //
    foreach ($records as $record) {
      $this->db->table('auth_permissions')->insert($record);
    }
  }
}

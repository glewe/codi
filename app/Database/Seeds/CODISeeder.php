<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CODISeeder extends Seeder {
  //---------------------------------------------------------------------------
  /**
   * Seed the tables with sample data.
   */
  public function run() {
    //
    // Seed CODI tables with sample data (keep this sequence).
    //
    $this->call('UserSeeder');
    $this->call('PermissionSeeder');
    $this->call('GroupSeeder');
    $this->call('RoleSeeder');
    $this->call('SettingsSeeder');
    $this->call('GroupsUsersSeeder');
    $this->call('RolesUsersSeeder');
    $this->call('RolesPermissionsSeeder');
    $this->call('UserOptionsSeeder');
    //
    // Seed custom tables
    //
  }
}

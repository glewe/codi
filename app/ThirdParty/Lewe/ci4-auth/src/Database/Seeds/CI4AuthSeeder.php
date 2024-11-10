<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CI4AuthSeeder extends Seeder {
  /**
   * --------------------------------------------------------------------------
   * Run.
   * --------------------------------------------------------------------------
   *
   * Seed the CI4-Auth tables with sample data.
   *
   * @return void
   */
  public function run(): void {
    $this->call('UserSeeder');
    $this->call('PermissionSeeder');
    $this->call('GroupSeeder');
    $this->call('RoleSeeder');
    $this->call('GroupsUsersSeeder');
    $this->call('RolesUsersSeeder');
    $this->call('RolesPermissionsSeeder');
  }
}

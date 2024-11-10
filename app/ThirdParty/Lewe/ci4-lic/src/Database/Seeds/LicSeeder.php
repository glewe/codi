<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupSeeder extends Seeder {
  /**
   * --------------------------------------------------------------------------
   * Run.
   * --------------------------------------------------------------------------
   *
   * Seed the 'groups' table.
   *
   * @return void
   */
  public function run(): void {
    $records = array(
      [ 'name' => 'Admins', 'description' => 'Application administrators' ],
      [ 'name' => 'Disney', 'description' => 'Disney characters' ],
      [ 'name' => 'Pixar', 'description' => 'Pixar characters' ],
      [ 'name' => 'Looney', 'description' => 'Looney characters' ],
    );

    // Simple Queries
    // $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

    // Using Query Builder
    foreach ($records as $record) {

      $this->db->table('auth_groups')->insert($record);
    }
  }
}

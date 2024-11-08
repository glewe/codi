<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserOptionsSeeder extends Seeder {
  //---------------------------------------------------------------------------
  /**
   * Seed the 'users_options' table.
   */
  public function run() {
    $records = array(
      [ 'user_id' => 1, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 1, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 1, 'option' => 'avatar', 'value' => 'av_iconshock-user_administrator.png' ],
      [ 'user_id' => 2, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 2, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 2, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 3, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 3, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 3, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 4, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 4, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 4, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 5, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 5, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 5, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 6, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 6, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 6, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 7, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 7, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 7, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 8, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 8, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 8, 'option' => 'avatar', 'value' => 'default_male.png' ],
      [ 'user_id' => 9, 'option' => 'language', 'value' => 'default' ],
      [ 'user_id' => 9, 'option' => 'theme', 'value' => 'default' ],
      [ 'user_id' => 9, 'option' => 'avatar', 'value' => 'default_male.png' ],
    );

    //
    // Simple Queries
    //
    // $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

    //
    // Insert records
    //
    foreach ($records as $record) {
      $this->db->table('users_options')->insert($record);
    }
  }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder {
  //---------------------------------------------------------------------------
  /**
   * Seed the 'users' table.
   */
  public function run() {
    $records = array(
      [ 'email' => 'admin@mydomain.com', 'username' => 'admin', 'firstname' => 'Super', 'lastname' => 'Admin', 'displayname' => 'Admin', 'hidden' => 1, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'mmouse@mydomain.com', 'username' => 'mmouse', 'firstname' => 'Mickey', 'lastname' => 'Mouse', 'displayname' => 'Mickey', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'mimouse@mydomain.com', 'username' => 'mimouse', 'firstname' => 'Minnie', 'lastname' => 'Mouse', 'displayname' => 'Minnie', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'dduck@mydomain.com', 'username' => 'dduck', 'firstname' => 'Donald', 'lastname' => 'Duck', 'displayname' => 'Donald', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'blightyear@mydomain.com', 'username' => 'blightyear', 'firstname' => 'Buzz', 'lastname' => 'Lightyear', 'displayname' => 'Buzz', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'phead@mydomain.com', 'username' => 'phead', 'firstname' => 'Potatoe', 'lastname' => 'Head', 'displayname' => 'Potie', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'ccarl@mydomain.com', 'username' => 'ccarl', 'firstname' => 'Coyote', 'lastname' => 'Carl', 'displayname' => 'Carl', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'sgonzalez@mydomain.com', 'username' => 'sgonzalez', 'firstname' => 'Speedy', 'lastname' => 'Gonzalez', 'displayname' => 'Speedy', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
      [ 'email' => 'sman@mydomain.com', 'username' => 'sman', 'firstname' => '', 'lastname' => 'Spiderman', 'displayname' => 'Spiderman', 'hidden' => 0, 'password_hash' => '$2y$10$V9Qlx9d1FtAFdsfl/uKhju2Gbq6HlHNGoD9.Nc9RBw/XSrcoEbmw2', 'active' => 1 ],
    );

    //
    // Simple Queries
    //
    // $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

    //
    // Insert records
    //
    foreach ($records as $record) {
      $this->db->table('auth_users')->insert($record);
    }
  }
}

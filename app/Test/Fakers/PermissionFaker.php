<?php

namespace App\Test\Fakers;

use Faker\Generator;
use App\Models\PermissionModel;

class PermissionFaker extends PermissionModel {
  /**
   * Faked data for Fabricator.
   *
   * @param Generator $faker
   *
   * @return array
   */
  public function fake(Generator &$faker): array {
    return [
      'name' => $faker->word,
      'description' => $faker->sentence,
    ];
  }
}

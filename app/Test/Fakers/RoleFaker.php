<?php

namespace App\Test\Fakers;

use Faker\Generator;
use App\Models\RoleModel;
use stdClass;

class RoleFaker extends RoleModel {
  /**
   * Faked data for Fabricator.
   *
   * @param Generator $faker
   *
   * @return stdClass
   */
  public function fake(Generator &$faker): stdClass {
    return (object)[
      'name' => $faker->word,
      'description' => $faker->sentence,
    ];
  }
}

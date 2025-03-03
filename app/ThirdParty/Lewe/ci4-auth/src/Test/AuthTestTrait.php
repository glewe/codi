<?php

namespace CI4\Auth\Test;

use CodeIgniter\Test\Fabricator;
use Config\Services;
use CI4\Auth\Entities\User;
use CI4\Auth\Models\UserModel;
use CI4\Auth\Test\Fakers\UserFaker;

/**
 * Trait AuthTestTrait
 *
 * Provides additional utilities for authentication and authorization
 * during testing.
 */
trait AuthTestTrait {
  /**
   * Creates a new faked User, optionally logging them in.
   *
   * @param bool  $login     Whether to log in the new User
   * @param array $overrides Overriding data for the Fabricator
   *
   * @return array|User|object
   * @throws \RuntimeException Usually only if overriding data fails to validate
   */
  protected function createAuthUser(bool $login = true, array $overrides = []) {
    $fabricator = new Fabricator(UserFaker::class);

    // Set overriding data, if necessary
    if (!empty($overrides)) {
      $fabricator->setOverrides($overrides);
    }

    /**
     * @var User $user
     */
    $user = $fabricator->make();
    $user->activate();

    if (!$userId = model(UserFaker::class)->insert($user)) {
      $error = implode(' ', model(UserFaker::class)->errors());

      throw new \RuntimeException('Unable to create user: ' . $error);
    }

    // Look the user up using Model Factory in case it is overridden in App
    $user = model(UserModel::class)->find($userId);

    if ($login) {
      $auth = Services::authentication();
      $auth->login($user);
      Services::injectMock('authentication', $auth);
    }

    return $user;
  }

  /**
   * Resets the Authentication and Authorization services.
   * Particularly helpful between feature tests.
   */
  protected function resetAuthServices() {
    Services::injectMock('authentication', Services::authentication('local', null, null, false));
    Services::injectMock('authorization', Services::authorization(null, null, null, false, null));
    $_SESSION = [];
  }
}

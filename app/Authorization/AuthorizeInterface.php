<?php

declare(strict_types=1);

namespace App\Authorization;

interface AuthorizeInterface
{
  //---------------------------------------------------------------------------
  /**
   * Returns the latest error string.
   *
   * @return string|null
   */
  public function error(): ?string;

  //---------------------------------------------------------------------------
  /**
   * Checks to see if a user is in a group.
   *
   * Groups can be either a string, with the name of the group, an INT with
   * the ID of the group, or an array of strings/ids that the user must belong
   * to ONE of. (It's an OR check not an AND check)
   *
   * @param mixed $groups
   * @param int   $userId
   *
   * @return bool
   */
  public function inGroup($groups, int $userId): bool;

  //---------------------------------------------------------------------------
  /**
   * Checks to see if a user is in a role.
   *
   * Roles can be either a string, with the name of the role, an INT with the
   * ID of the role, or an array of strings/ids that the user must belong to
   * ONE of. (It's an OR check not an AND check)
   *
   * @param mixed $roles
   * @param int   $userId
   *
   * @return bool
   */
  public function inRole($roles, int $userId): bool;

  //---------------------------------------------------------------------------
  /**
   * Checks a user's roles to see if they have the specified permission.
   *
   * @param int|string $permission
   * @param int        $userId
   *
   * @return bool
   */
  public function hasPermission($permission, int $userId): bool;

  //---------------------------------------------------------------------------
  /**
   * Adds a user to a group.
   *
   * @param int        $userid
   * @param int|string $group   Either ID or name
   *
   * @return bool
   */
  public function addUserToGroup(int $userid, $group): bool;

  //---------------------------------------------------------------------------
  /**
   * Adds a user to a role.
   *
   * @param int        $userid
   * @param int|string $role    Either ID or name
   *
   * @return bool
   */
  public function addUserToRole(int $userid, $role): bool;

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a group.
   *
   * @param int        $userId
   * @param int|string $group
   *
   * @return bool
   */
  public function removeUserFromGroup(int $userId, $group): bool;

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a role.
   *
   * @param int        $userId
   * @param int|string $role
   *
   * @return bool
   */
  public function removeUserFromRole(int $userId, $role): bool;

  //---------------------------------------------------------------------------
  /**
   * Adds a single permission to a single group.
   *
   * @param int|string $permission
   * @param int|string $group
   *
   * @return bool
   */
  public function addPermissionToGroup($permission, $group): bool;

  //---------------------------------------------------------------------------
  /**
   * Adds a single permission to a single role.
   *
   * @param int|string $permission
   * @param int|string $role
   *
   * @return bool
   */
  public function addPermissionToRole($permission, $role): bool;

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a group.
   *
   * @param int|string $permission
   * @param int|string $group
   *
   * @return bool
   */
  public function removePermissionFromGroup($permission, $group): bool;

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a role.
   *
   * @param int|string $permission
   * @param int|string $role
   *
   * @return bool
   */
  public function removePermissionFromRole($permission, $role): bool;

  //---------------------------------------------------------------------------
  /**
   * Grabs the details about a single group.
   *
   * @param int|string $group
   *
   * @return object|null
   */
  public function group($group): ?object;

  //---------------------------------------------------------------------------
  /**
   * Grabs an array of all groups.
   *
   * @return array
   */
  public function groups(): array;

  //---------------------------------------------------------------------------
  /**
   * @param string $name
   * @param string $description
   *
   * @return int|bool
   */
  public function createGroup(string $name, string $description = ''): int|bool;

  //---------------------------------------------------------------------------
  /**
   * Deletes a single group.
   *
   * @param int $groupId
   *
   * @return bool
   */
  public function deleteGroup(int $groupId): bool;

  //---------------------------------------------------------------------------
  /**
   * Updates a single group's information.
   *
   * @param int    $id
   * @param string $name
   * @param string $description
   *
   * @return bool
   */
  public function updateGroup(int $id, string $name, string $description = ''): bool;

  //---------------------------------------------------------------------------
  /**
   * Grabs the details about a single role.
   *
   * @param int|string $role
   *
   * @return object|null
   */
  public function role($role): ?object;

  //---------------------------------------------------------------------------
  /**
   * Grabs an array of all roles.
   *
   * @return array
   */
  public function roles(): array;

  //---------------------------------------------------------------------------
  /**
   * @param string $name
   * @param string $description
   * @param string $bscolor
   *
   * @return int|bool
   */
  public function createRole(string $name, string $description = '', string $bscolor = 'primary'): int|bool;

  //---------------------------------------------------------------------------
  /**
   * Deletes a single role.
   *
   * @param int $roleId
   *
   * @return bool
   */
  public function deleteRole(int $roleId): bool;

  //---------------------------------------------------------------------------
  /**
   * Updates a single role's information.
   *
   * @param int    $id
   * @param string $name
   * @param string $description
   * @param string $bscolor
   *
   * @return bool
   */
  public function updateRole(int $id, string $name, string $description = '', string $bscolor = 'primary'): bool;

  //---------------------------------------------------------------------------
  /**
   * Returns the details about a single permission.
   *
   * @param int|string $permission
   *
   * @return object|null
   */
  public function permission($permission): ?object;

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all permissions in the system.
   *
   * @return array
   */
  public function permissions(): array;

  //---------------------------------------------------------------------------
  /**
   * Creates a single permission.
   *
   * @param string $name
   * @param string $description
   *
   * @return int|bool
   */
  public function createPermission(string $name, string $description = ''): int|bool;

  //---------------------------------------------------------------------------
  /**
   * Deletes a single permission and removes that permission from all roles.
   *
   * @param int $permissionId
   *
   * @return bool
   */
  public function deletePermission(int $permissionId): bool;

  //---------------------------------------------------------------------------
  /**
   * Updates the details for a single permission.
   *
   * @param int    $id
   * @param string $name
   * @param string $description
   *
   * @return bool
   */
  public function updatePermission(int $id, string $name, string $description = ''): bool;
}

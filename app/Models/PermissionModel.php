<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * PermissionModel
 */
class PermissionModel extends Model
{
  protected $table         = 'permissions';
  protected $primaryKey    = 'id';
  protected $returnType    = 'object';
  protected $allowedFields = ['name', 'description'];
  protected $useTimestamps = false;

  /** @var mixed */
  public $error;

  //---------------------------------------------------------------------------
  /**
   * Adds a single permission to a single user.
   *
   * @param int $permissionId Permission ID.
   * @param int $userId       User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function addPermissionToUser(int $permissionId, int $userId): bool {
    cache()->delete("{$userId}_permissions");

    return (bool) $this->db->table('users_permissions')->insert([
      'user_id'       => $userId,
      'permission_id' => $permissionId,
    ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a permission.
   *
   * @param int $id Permission ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deletePermission(int $id): bool {
    if (!$this->delete($id)) {
      $this->error = $this->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Checks if a user has a specific permission (personal, group, role).
   *
   * @param int $userId       User ID.
   * @param int $permissionId Permission ID.
   *
   * @return bool True if the user has the permission, false otherwise.
   */
  public function doesUserHavePermission(int $userId, int $permissionId): bool {
    $userPerms = $this->getPermissionsForUser($userId);

    if (count($userPerms) > 0 && array_key_exists($permissionId, $userPerms)) {
      return true;
    }

    $count = (int) $this->db->table('groups_permissions')
      ->join('groups_users', 'groups_users.group_id = groups_permissions.group_id', 'inner')
      ->where('groups_permissions.permission_id', $permissionId)
      ->where('groups_users.user_id', $userId)
      ->countAllResults();

    $count += (int) $this->db->table('roles_permissions')
      ->join('roles_users', 'roles_users.role_id = roles_permissions.role_id', 'inner')
      ->where('roles_permissions.permission_id', $permissionId)
      ->where('roles_users.user_id', $userId)
      ->countAllResults();

    return $count > 0;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all personal, group and role permissions for a user.
   *
   * @param int $userId User ID.
   *
   * @return array Array of permissions [id => name].
   */
  public function getPermissionsForUser(int $userId): array {
    if (null === ($found = cache("{$userId}_permissions"))) {
      $fromUser = $this->db->table('users_permissions')
        ->select('id, permissions.name')
        ->join('permissions', 'permissions.id = permission_id', 'inner')
        ->where('user_id', $userId)
        ->get()
        ->getResultObject();

      $fromGroup = $this->db->table('groups_users')
        ->select('permissions.id, permissions.name')
        ->join('groups_permissions', 'groups_permissions.group_id = groups_users.group_id', 'inner')
        ->join('permissions', 'permissions.id = groups_permissions.permission_id', 'inner')
        ->where('user_id', $userId)
        ->get()
        ->getResultObject();

      $fromRole = $this->db->table('roles_users')
        ->select('permissions.id, permissions.name')
        ->join('roles_permissions', 'roles_permissions.role_id = roles_users.role_id', 'inner')
        ->join('permissions', 'permissions.id = roles_permissions.permission_id', 'inner')
        ->where('user_id', $userId)
        ->get()
        ->getResultObject();

      $combined = array_merge($fromUser, $fromGroup, $fromRole);

      $found = [];
      foreach ($combined as $row) {
        /** @var object $row */
        $found[$row->id] = strtolower((string) $row->name);
      }

      cache()->save("{$userId}_permissions", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all personal permissions for a user.
   *
   * @param int $userId User ID.
   *
   * @return array Array of personal permissions [id => name].
   */
  public function getPersonalPermissionsForUser(int $userId): array {
    if (null === ($found = cache("{$userId}_personal_permissions"))) {
      $fromUser = $this->db->table('users_permissions')
        ->select('id, permissions.name')
        ->join('permissions', 'permissions.id = permission_id', 'inner')
        ->where('user_id', $userId)
        ->get()
        ->getResultObject();

      $found = [];
      foreach ($fromUser as $row) {
        /** @var object $row */
        $found[$row->id] = strtolower((string) $row->name);
      }

      cache()->save("{$userId}_personal_permissions", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all groups that have a single permission assigned.
   *
   * @param int $permId Permission ID.
   *
   * @return array Array of groups [id => name].
   */
  public function getGroupsForPermission(int $permId): array {
    if (null === ($found = cache("{$permId}_permission_groups"))) {
      $permGroups = $this->db->table('groups_permissions')
        ->select('id, groups.name')
        ->join('groups', 'groups.id = group_id', 'inner')
        ->where('permission_id', $permId)
        ->get()
        ->getResultObject();

      $found = [];
      foreach ($permGroups as $row) {
        /** @var object $row */
        $found[$row->id] = (string) $row->name;
      }

      cache()->save("{$permId}_permission_groups", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all roles that have a single permission assigned.
   *
   * @param int $permId Permission ID.
   *
   * @return array Array of roles [id => name].
   */
  public function getRolesForPermission(int $permId): array {
    if (null === ($found = cache("{$permId}_permission_roles"))) {
      $permRoles = $this->db->table('roles_permissions')
        ->select('id, roles.name')
        ->join('roles', 'roles.id = role_id', 'inner')
        ->where('permission_id', $permId)
        ->get()
        ->getResultObject();

      $found = [];
      foreach ($permRoles as $row) {
        /** @var object $row */
        $found[$row->id] = (string) $row->name;
      }

      cache()->save("{$permId}_permission_roles", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all users that hold a single personal permission.
   *
   * @param int $permId Permission ID.
   *
   * @return array Array of users [id => username].
   */
  public function getUsersForPermission(int $permId): array {
    if (null === ($found = cache("{$permId}_permission_users"))) {
      $permUsers = $this->db->table('users_permissions')
        ->select('id, users.username')
        ->join('users', 'users.id = user_id', 'inner')
        ->where('permission_id', $permId)
        ->get()
        ->getResultObject();

      $found = [];
      foreach ($permUsers as $row) {
        /** @var object $row */
        $found[$row->id] = (string) $row->username;
      }

      cache()->save("{$permId}_permission_users", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a permission from a user.
   *
   * @param int $permissionId Permission ID.
   * @param int $userId       User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removePermissionFromUser(int $permissionId, int $userId): bool {
    $res = $this->db->table('users_permissions')->where(['user_id' => $userId, 'permission_id' => $permissionId])->delete();
    cache()->delete("{$userId}_permissions");

    return (bool) $res;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes all permissions from a user.
   *
   * @param int $userId User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeAllPermissionsFromUser(int $userId): bool {
    $res = $this->db->table('users_permissions')->where(['user_id' => $userId])->delete();
    cache()->delete("{$userId}_permissions");

    return (bool) $res;
  }
}


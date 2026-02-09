<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * RoleModel
 */
class RoleModel extends Model
{
  protected $table          = 'roles';
  protected $primaryKey     = 'id';
  protected $returnType     = 'object';
  protected $allowedFields  = ['name', 'description', 'bscolor'];
  protected $useTimestamps  = false;
  protected $skipValidation = false;

  /** @var mixed */
  public $error;

  //---------------------------------------------------------------------------
  /**
   * Add a single permission to a single role, by IDs.
   *
   * @param int $permissionId Permission ID.
   * @param int $roleId       Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function addPermissionToRole(int $permissionId, int $roleId): bool {
    $data = [
      'role_id'       => $roleId,
      'permission_id' => $permissionId,
    ];

    return (bool) $this->db->table('roles_permissions')->insert($data);
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a single user to a single role.
   *
   * @param int $userId User ID.
   * @param int $roleId Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function addUserToRole(int $userId, int $roleId): bool {
    cache()->delete("{$roleId}_users");
    cache()->delete("{$userId}_roles");
    cache()->delete("{$userId}_permissions");

    $data = [
      'user_id' => $userId,
      'role_id' => $roleId,
    ];

    return (bool) $this->db->table('roles_users')->insert($data);
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a role.
   *
   * @param int $id Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteRole(int $id): bool {
    if (!$this->delete($id)) {
      $this->error = $this->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all permissions for a role.
   *
   * @param int $roleId Role ID.
   *
   * @return array Array of permissions.
   */
  public function getPermissionsForRole(int $roleId): array {
    $permissionModel = model(PermissionModel::class);
    $fromRole        = $permissionModel
      ->select('permissions.*')
      ->join('roles_permissions', 'roles_permissions.permission_id = permissions.id', 'inner')
      ->where('role_id', $roleId)
      ->findAll();

    $found = [];
    foreach ($fromRole as $permission) {
      /** @var object $permission */
      $found[$permission->id] = $permission;
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all roles that a user is a member of.
   *
   * @param int $userId User ID.
   *
   * @return array Array of roles.
   */
  public function getRolesForUser(int $userId): array {
    if (null === ($found = cache("{$userId}_roles"))) {
      $found = $this->builder()
        ->select('roles_users.*, roles.name, roles.description')
        ->join('roles_users', 'roles_users.role_id = roles.id', 'left')
        ->where('user_id', $userId)
        ->get()->getResultArray();

      cache()->save("{$userId}_roles", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all users that are members of a role.
   *
   * @param int $roleId Role ID.
   *
   * @return array Array of users.
   */
  public function getUsersForRole(int $roleId): array {
    if (null === ($found = cache("{$roleId}_users"))) {
      $found = $this->builder()
        ->select('roles_users.*, users.*')
        ->join('roles_users', 'roles_users.role_id = roles.id', 'left')
        ->join('users', 'roles_users.user_id = users.id', 'left')
        ->where('roles.id', $roleId)
        ->get()->getResultArray();

      cache()->save("{$roleId}_users", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes all permissions from a single role.
   *
   * @param int $roleId Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeAllPermissionsFromRole(int $roleId): bool {
    return (bool) $this->db->table('roles_permissions')->where(['role_id' => $roleId])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a single role.
   *
   * @param int $permissionId Permission ID.
   * @param int $roleId       Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removePermissionFromRole(int $permissionId, int $roleId): bool {
    return (bool) $this->db->table('roles_permissions')
      ->where([
        'permission_id' => $permissionId,
        'role_id'       => $roleId,
      ])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from all roles.
   *
   * @param int $permissionId Permission ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removePermissionFromAllRoles(int $permissionId): bool {
    return (bool) $this->db->table('roles_permissions')->where('permission_id', $permissionId)->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a single role.
   *
   * @param int $userId User ID.
   * @param int $roleId Role ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeUserFromRole(int $userId, int $roleId): bool {
    cache()->delete("{$roleId}_users");
    cache()->delete("{$userId}_roles");
    cache()->delete("{$userId}_permissions");

    return (bool) $this->db->table('roles_users')->where(['user_id' => $userId, 'role_id' => $roleId])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from all roles.
   *
   * @param int $userId User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeUserFromAllRoles(int $userId): bool {
    cache()->delete("{$userId}_roles");
    cache()->delete("{$userId}_permissions");

    return (bool) $this->db->table('roles_users')->where('user_id', $userId)->delete();
  }
}


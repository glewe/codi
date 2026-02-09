<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

/**
 * GroupModel
 */
class GroupModel extends Model
{
  protected $table          = 'groups';
  protected $primaryKey     = 'id';
  protected $returnType     = 'object';
  protected $allowedFields  = ['name', 'description'];
  protected $useTimestamps  = false;
  protected $skipValidation = false;

  /** @var mixed */
  public $error;

  //---------------------------------------------------------------------------
  /**
   * Add a single permission to a single group, by IDs.
   *
   * @param int $permissionId Permission ID.
   * @param int $groupId      Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function addPermissionToGroup(int $permissionId, int $groupId): bool {
    $data = [
      'group_id'      => $groupId,
      'permission_id' => $permissionId,
    ];

    return (bool) $this->db->table('groups_permissions')->insert($data);
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a single user to a single group.
   *
   * @param int $userId User ID.
   * @param int $groupId Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function addUserToGroup(int $userId, int $groupId): bool {
    cache()->delete("{$groupId}_users");
    cache()->delete("{$userId}_groups");
    cache()->delete("{$userId}_permissions");

    $data = [
      'user_id'  => $userId,
      'group_id' => $groupId,
    ];

    return (bool) $this->db->table('groups_users')->insert($data);
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a group.
   *
   * @param int $id Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteGroup(int $id): bool {
    if (!$this->delete($id)) {
      $this->error = $this->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all groups that a user is a member of.
   *
   * @param int $userId User ID.
   *
   * @return array Array of groups.
   */
  public function getGroupsForUser(int $userId): array {
    if (null === ($found = cache("{$userId}_groups"))) {
      $found = $this->builder()
        ->select('groups_users.*, groups.name, groups.description')
        ->join('groups_users', 'groups_users.group_id = groups.id', 'left')
        ->where('user_id', $userId)
        ->get()->getResultArray();

      cache()->save("{$userId}_groups", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all permissions for a group.
   *
   * @param int $groupId Group ID.
   *
   * @return array Array of permissions.
   */
  public function getPermissionsForGroup(int $groupId): array {
    $permissionModel = model(PermissionModel::class);
    $fromGroup       = $permissionModel
      ->select('permissions.*')
      ->join('groups_permissions', 'groups_permissions.permission_id = permissions.id', 'inner')
      ->where('group_id', $groupId)
      ->findAll();

    $found = [];
    foreach ($fromGroup as $permission) {
      /** @var object $permission */
      $found[$permission->id] = $permission;
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all users that are members of a group.
   *
   * @param int $groupId Group ID.
   *
   * @return array Array of users.
   */
  public function getUsersForGroup(int $groupId): array {
    if (null === ($found = cache("{$groupId}_users"))) {
      $found = $this->builder()
        ->select('groups_users.*, users.*')
        ->join('groups_users', 'groups_users.group_id = groups.id', 'left')
        ->join('users', 'groups_users.user_id = users.id', 'left')
        ->where('groups.id', $groupId)
        ->get()->getResultArray();

      cache()->save("{$groupId}_users", $found, 300);
    }

    return $found;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a single group.
   *
   * @param int $permissionId Permission ID.
   * @param int $groupId      Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removePermissionFromGroup(int $permissionId, int $groupId): bool {
    return (bool) $this->db->table('groups_permissions')
      ->where([
        'permission_id' => $permissionId,
        'group_id'      => $groupId,
      ])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes all permissions from a single group.
   *
   * @param int $groupId Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeAllPermissionsFromGroup(int $groupId): bool {
    return (bool) $this->db->table('groups_permissions')->where(['group_id' => $groupId])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from all groups.
   *
   * @param int $permissionId Permission ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removePermissionFromAllGroups(int $permissionId): bool {
    return (bool) $this->db->table('groups_permissions')->where('permission_id', $permissionId)->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a single group.
   *
   * @param int $userId  User ID.
   * @param int $groupId Group ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeUserFromGroup(int $userId, int $groupId): bool {
    cache()->delete("{$groupId}_users");
    cache()->delete("{$userId}_groups");
    cache()->delete("{$userId}_permissions");

    return (bool) $this->db->table('groups_users')->where(['user_id' => $userId, 'group_id' => $groupId])->delete();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from all groups.
   *
   * @param int $userId User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function removeUserFromAllGroups(int $userId): bool {
    cache()->delete("{$userId}_groups");
    cache()->delete("{$userId}_permissions");

    return (bool) $this->db->table('groups_users')->where('user_id', $userId)->delete();
  }
}


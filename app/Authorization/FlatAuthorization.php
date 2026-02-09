<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Entities\User;
use App\Models\GroupModel;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\Events\Events;
use CodeIgniter\Model;

class FlatAuthorization implements AuthorizeInterface
{
  /**
   * @var array|string|null
   */
  public $error;

  /**
   * The group model to use. Usually the class noted below (or an extension
   * thereof) but can be any compatible CodeIgniter Model.
   *
   * @var GroupModel
   */
  protected $groupModel;

  /**
   * The role model to use. Usually the class noted below (or an extension
   * thereof) but can be any compatible CodeIgniter Model.
   *
   * @var RoleModel
   */
  protected $roleModel;

  /**
   * The permission model to use. Usually the class noted below (or an
   * extension thereof) but can be any compatible CodeIgniter Model.
   *
   * @var PermissionModel
   */
  protected $permissionModel;

  /**
   * The user model to use. Usually the class noted below (or an extension
   * thereof) but can be any compatible CodeIgniter Model.
   *
   * @var Model|null
   */
  protected $userModel = null;

  //---------------------------------------------------------------------------
  /**
   * Stores the models.
   *
   * @param GroupModel      $groupModel
   * @param RoleModel       $roleModel
   * @param PermissionModel $permissionModel
   */
  public function __construct(Model $groupModel, Model $roleModel, Model $permissionModel) {
    $this->groupModel = $groupModel;
    $this->roleModel = $roleModel;
    $this->permissionModel = $permissionModel;
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a single permission to a single group.
   *
   * @param int|string $permission
   * @param int|string $group
   *
   * @return bool
   */
  public function addPermissionToGroup($permission, $group): bool {
    $permissionId = $this->getPermissionID($permission);
    $groupId = $this->getGroupID($group);

    if (!is_numeric($permissionId)) {
      return false;
    }

    if (!is_numeric($groupId)) {
      return false;
    }

    if (!$this->groupModel->addPermissionToGroup($permissionId, $groupId)) {
      $this->error = $this->groupModel->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a single permission to a single role.
   *
   * @param int|string $permission
   * @param int|string $role
   *
   * @return bool
   */
  public function addPermissionToRole($permission, $role): bool {
    $permissionId = $this->getPermissionID($permission);
    $roleId = $this->getRoleID($role);

    if (!is_numeric($permissionId)) {
      return false;
    }

    if (!is_numeric($roleId)) {
      return false;
    }

    if (!$this->roleModel->addPermissionToRole($permissionId, $roleId)) {
      $this->error = $this->roleModel->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Assigns a single permission to a user, irregardless of permissions
   * assigned by roles. This is saved to the user's meta information.
   *
   * @param int|string $permission
   * @param int        $userId
   *
   * @return bool|null
   */
  public function addPermissionToUser($permission, int $userId): ?bool {
    $permissionId = $this->getPermissionID($permission);

    if (!is_numeric($permissionId)) {
      return null;
    }

    if (!Events::trigger('beforeAddPermissionToUser', $userId, $permissionId)) {
      return false;
    }

    $user = $this->userModel->find($userId);

    if (!$user) {
      $this->error = lang('Auth.user.not_found', [$userId]);
      return false;
    }

    /** @var User $user */
    $permissions = $user->getPermissions();

    if (!in_array($permissionId, $permissions)) {
      $this->permissionModel->addPermissionToUser($permissionId, $user->id);
    }

    Events::trigger('didAddPermissionToUser', $userId, $permissionId);

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a user to group.
   *
   * @param int   $userid
   * @param mixed $group   Either ID or name, fails on anything else
   *
   * @return bool
   */
  public function addUserToGroup(int $userid, $group): bool {
    if ($userid === 0) {
      return false;
    }

    if (empty($group) || (!is_numeric($group) && !is_string($group))) {
      return false;
    }

    $groupId = $this->getGroupID($group);

    if (!Events::trigger('beforeAddUserToGroup', $userid, $groupId)) {
      return false;
    }

    if (!is_numeric($groupId)) {
      return false;
    }

    if (!$this->groupModel->addUserToGroup($userid, (int)$groupId)) {
      $this->error = $this->groupModel->errors();
      return false;
    }

    Events::trigger('didAddUserToGroup', $userid, $groupId);

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Adds a user to role.
   *
   * @param int   $userid
   * @param mixed $role    Either ID or name, fails on anything else
   *
   * @return bool
   */
  public function addUserToRole(int $userid, $role): bool {
    if ($userid === 0) {
      return false;
    }

    if (empty($role) || (!is_numeric($role) && !is_string($role))) {
      return false;
    }

    $roleId = $this->getRoleID($role);

    if (!Events::trigger('beforeAddUserToRole', $userid, $roleId)) {
      return false;
    }

    if (!is_numeric($roleId)) {
      return false;
    }

    if (!$this->roleModel->addUserToRole($userid, (int)$roleId)) {
      $this->error = $this->roleModel->errors();
      return false;
    }

    Events::trigger('didAddUserToRole', $userid, $roleId);

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a single permission.
   *
   * @param string $name
   * @param string $description
   *
   * @return int|bool
   */
  public function createPermission(string $name, string $description = ''): int|bool {
    $data = [
      'name' => $name,
      'description' => $description,
    ];

    $validation = service('validation', null, false);
    $validation->setRules([
      'name' => 'required|max_length[255]|is_unique[permissions.name]',
      'description' => 'max_length[255]',
    ]);

    if (!$validation->run($data)) {
      $this->error = $validation->getErrors();
      return false;
    }

    $id = $this->permissionModel->skipValidation()->insert($data);

    if (is_numeric($id)) {
      return (int)$id;
    }

    $this->error = $this->permissionModel->errors();

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * @param string $name
   * @param string $description
   *
   * @return int|bool
   */
  public function createGroup(string $name, string $description = ''): int|bool {
    $data = [
      'name' => $name,
      'description' => $description,
    ];

    $validation = service('validation', null, false);
    $validation->setRules(
      [
        'name' => 'required|max_length[255]|is_unique[groups.name]',
        'description' => 'max_length[255]',
      ],
      [
        'name' => [
          'required' => 'You must enter a group name.',
          'max_length[255]' => 'The group name cannot be longer than 255 characters.',
          'is_unique[groups.name]' => 'The group name already exists.',
        ],
        'description' => [
          'max_length[255]' => 'The description cannot be longer than 255 characters.',
        ],
      ]
    );

    if (!$validation->run($data)) {
      $this->error = $validation->getErrors();
      return false;
    }

    $id = $this->groupModel->skipValidation()->insert($data);

    if (is_numeric($id)) {
      return (int)$id;
    }

    $this->error = $this->groupModel->errors();

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * @param string $name
   * @param string $description
   * @param string $bscolor
   *
   * @return int|bool
   */
  public function createRole(string $name, string $description = '', string $bscolor = 'primary'): int|bool {
    $data = [
      'name' => $name,
      'description' => $description,
      'bscolor' => $bscolor,
    ];

    $validation = service('validation', null, false);
    $validation->setRules(
      [
        'name' => 'required|max_length[255]|is_unique[roles.name]',
        'description' => 'max_length[255]',
      ],
      [
        'name' => [
          'required' => 'You must enter a role name.',
          'max_length[255]' => 'The role name cannot be longer than 255 characters.',
          'is_unique[roles.name]' => 'The role name already exists.',
        ],
        'description' => [
          'max_length[255]' => 'The description cannot be longer than 255 characters.',
        ],
      ]
    );

    if (!$validation->run($data)) {
      $this->error = $validation->getErrors();
      return false;
    }

    $id = $this->roleModel->skipValidation()->insert($data);

    if (is_numeric($id)) {
      return (int)$id;
    }

    $this->error = $this->roleModel->errors();

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a single group.
   *
   * @param int $groupId
   *
   * @return bool
   */
  public function deleteGroup(int $groupId): bool {
    if (!$this->groupModel->delete($groupId)) {
      $this->error = $this->groupModel->errors();
      return false;
    }
    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a single permission and removes that permission from all roles.
   *
   * @param int $permissionId
   *
   * @return bool
   */
  public function deletePermission(int $permissionId): bool {
    if (!$this->permissionModel->delete($permissionId)) {
      $this->error = $this->permissionModel->errors();
      return false;
    }
    // Remove the permission from all roles and groups
    $this->roleModel->removePermissionFromAllRoles($permissionId);
    $this->groupModel->removePermissionFromAllGroups($permissionId);
    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a single role.
   *
   * @param int $roleId
   *
   * @return bool
   */
  public function deleteRole(int $roleId): bool {
    if (!$this->roleModel->delete($roleId)) {
      $this->error = $this->roleModel->errors();
      return false;
    }
    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Checks to see if a user has personal permission assigned to it (not via
   * a group or role).
   *
   * @param int|string $userId
   * @param int|string $permission
   *
   * @return bool|null
   */
  public function doesUserHavePermission($userId, $permission): ?bool {
    $permissionId = $this->getPermissionID($permission);

    if (!is_numeric($permissionId)) {
      return false;
    }

    if (empty($userId) || !is_numeric($userId)) {
      return null;
    }

    return $this->permissionModel->doesUserHavePermission($userId, (int)$permissionId);
  }

  //---------------------------------------------------------------------------
  /**
   * Returns any error(s) from the last call.
   *
   * @return string|null
   */
  public function error(): ?string {
    if (is_array($this->error)) {
      return implode(', ', $this->error);
    }
    return $this->error;
  }

  //---------------------------------------------------------------------------
  /**
   * Given a group, will return the group ID. The group can be either
   * the ID or the name of the group.
   *
   * @param int|string $group
   *
   * @return int|false
   */
  protected function getGroupID($group): int|false {
    if (is_numeric($group)) {
      return (int)$group;
    }

    $g = $this->groupModel->where('name', $group)->first();

    if (!$g) {
      $this->error = lang('Auth.group.not_found', [$group]);
      return false;
    }

    /** @var object $g */
    return (int)$g->id;
  }

  //---------------------------------------------------------------------------
  /**
   * Verifies that a permission (either ID or the name) exists and returns
   * the permission ID.
   *
   * @param int|string $permission
   *
   * @return int|false
   */
  protected function getPermissionID($permission): int|false {
    // If it's a number, we're done here.
    if (is_numeric($permission)) {
      return (int)$permission;
    }

    // Otherwise, pull it from the database.
    $p = $this->permissionModel->asObject()->where('name', $permission)->first();

    if (!$p) {
      $this->error = lang('Auth.permission.not_found', [$permission]);
      return false;
    }

    /** @var object $p */
    return (int)$p->id;
  }

  //---------------------------------------------------------------------------
  /**
   * Given a role, will return the role ID. The role can be either
   * the ID or the name of the role.
   *
   * @param int|string $role
   *
   * @return int|false
   */
  protected function getRoleID($role): int|false {
    if (is_numeric($role)) {
      return (int)$role;
    }
    $r = $this->roleModel->where('name', $role)->first();
    if (!$r) {
      $this->error = lang('Auth.role.not_found', [$role]);
      return false;
    }
    /** @var object $r */
    return (int)$r->id;
  }

  //---------------------------------------------------------------------------
  /**
   * Grabs the details about a single group.
   *
   * @param int|string $group
   *
   * @return object|null
   */
  public function group($group): ?object {
    if (is_numeric($group)) {
      return $this->groupModel->find((int)$group);
    }
    return $this->groupModel->where('name', $group)->first();
  }

  //---------------------------------------------------------------------------
  /**
   * Grabs an array of all groups.
   *
   * @return array
   */
  public function groups(): array {
    return $this->groupModel->orderBy('name', 'asc')->findAll();
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all permissions in the system for a group.
   * The group can be either the ID or the name of the group.
   *
   * @param int|string $group
   *
   * @return array
   */
  public function groupPermissions($group): array {
    if (is_numeric($group)) {
      return $this->groupModel->getPermissionsForGroup((int)$group);
    } else {
      $g = $this->groupModel->where('name', $group)->first();
      /** @var object $g */
      return $this->groupModel->getPermissionsForGroup($g->id);
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Checks whether a user has a given permission.
   *
   * @param int|string $permission  Permission ID or name
   * @param int        $userId
   *
   * @return bool
   */
  public function hasPermission($permission, int $userId): bool {
    if (empty($permission)) {
      return false;
    }

    if ($userId === 0) {
      return false;
    }

    // Get the Permission ID
    $permissionId = $this->getPermissionID($permission);

    if (!is_numeric($permissionId)) {
      return false;
    }

    // First check the permission model. If that exists, then we're golden.
    if ($this->permissionModel->doesUserHavePermission($userId, (int)$permissionId)) {
      return true;
    }

    // Still here? Then we have one last check to make - any user private permissions.
    return (bool)$this->doesUserHavePermission($userId, (int)$permissionId);
  }

  //---------------------------------------------------------------------------
  /**
   * Checks whether a user has any of the given permissions.
   *
   * Permissions can be either a string, with the name of the permission, an
   * INT with the ID of the permission, or an array of strings/ids of
   * permissions that the user must have ONE of.
   * (It's an OR check not an AND check)
   *
   * @param mixed $permissions  Permission ID or name (or array of)
   * @param int   $userId
   *
   * @return bool|null
   */
  public function hasPermissions($permissions, int $userId): ?bool {
    if ($userId === 0) {
      return null;
    }

    if (!is_array($permissions)) {
      $permissions = [$permissions];
    }
    if (empty($permissions)) {
      return false;
    }

    foreach ($permissions as $permission) {
      if ($this->hasPermission($permission, $userId)) {
        return true;
      }
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Checks whether a user is in a group.
   *
   * Groups can be either a string, with the name of the group, an INT with the
   * ID of the group, or an array of strings/ids that the user must belong to
   * ONE of. (It's an OR check not an AND check)
   *
   * @param mixed $groups
   * @param int   $userId
   *
   * @return bool
   */
  public function inGroup($groups, int $userId): bool {
    if ($userId === 0) {
      return false;
    }

    if (!is_array($groups)) {
      $groups = [$groups];
    }

    $userGroups = $this->groupModel->getGroupsForUser((int)$userId);

    if (empty($userGroups)) {
      return false;
    }

    foreach ($groups as $group) {
      if (is_numeric($group)) {
        $ids = array_column($userGroups, 'group_id');
        if (in_array($group, $ids)) {
          return true;
        }
      } elseif (is_string($group)) {
        $names = array_column($userGroups, 'name');
        if (in_array((string)$group, $names)) {
          return true;
        }
      }
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Checks whether a user is in a role.
   *
   * Roles can be either a string, with the name of the role, an INT
   * with the ID of the role, or an array of strings/ids that the
   * user must belong to ONE of. (It's an OR check not an AND check)
   *
   * @param mixed $roles
   * @param int   $userId
   *
   * @return bool
   */
  public function inRole($roles, int $userId): bool {
    if ($userId === 0) {
      return false;
    }

    if (!is_array($roles)) {
      $roles = [$roles];
    }

    $userRoles = $this->roleModel->getRolesForUser((int)$userId);

    if (empty($userRoles)) {
      return false;
    }

    foreach ($roles as $role) {
      if (is_numeric($role)) {
        $ids = array_column($userRoles, 'role_id');
        if (in_array($role, $ids)) {
          return true;
        }
      } elseif (is_string($role)) {
        $names = array_column($userRoles, 'name');
        if (in_array((string)$role, $names)) {
          return true;
        }
      }
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns the details about a single permission.
   *
   * @param int|string $permission
   *
   * @return object|null
   */
  public function permission($permission): ?object {
    if (is_numeric($permission)) {
      return $this->permissionModel->find((int)$permission);
    }
    return $this->permissionModel->like('name', $permission, 'none', null, true)->first();
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all permissions in the system.
   *
   * @return array
   */
  public function permissions(): array {
    return $this->permissionModel->orderBy('name', 'asc')->findAll();
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a group.
   *
   * @param int|string $permission
   * @param int|string $group
   *
   * @return bool
   */
  public function removePermissionFromGroup($permission, $group): bool {
    $permissionId = $this->getPermissionID($permission);
    $groupId = $this->getRoleID($group);

    if (!is_numeric($permissionId)) {
      return false;
    }

    if (!is_numeric($groupId)) {
      return false;
    }

    if (!$this->groupModel->removePermissionFromGroup($permissionId, $groupId)) {
      $this->error = $this->groupModel->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a role.
   *
   * @param int|string $permission
   * @param int|string $role
   *
   * @return bool
   */
  public function removePermissionFromRole($permission, $role): bool {
    $permissionId = $this->getPermissionID($permission);
    $roleId = $this->getRoleID($role);

    if (!is_numeric($permissionId)) {
      return false;
    }

    if (!is_numeric($roleId)) {
      return false;
    }

    if (!$this->roleModel->removePermissionFromRole($permissionId, $roleId)) {
      $this->error = $this->roleModel->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes all individual permissions from a user.
   *
   * @param int $userId
   *
   * @return bool|null
   */
  public function removeAllPermissionsFromUser(int $userId): ?bool {
    if ($userId === 0) {
      return null;
    }
    if (!Events::trigger('beforeRemoveAllPermissionsFromUser', $userId)) {
      return false;
    }
    $this->permissionModel->removeAllPermissionsFromUser($userId);
    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single permission from a user. Only applies to permissions
   * that have been assigned with addPermissionToUser, not to permissions
   * inherited based on roles they belong to.
   *
   * @param int|string $permission
   * @param int        $userId
   *
   * @return bool|null
   */
  public function removePermissionFromUser($permission, int $userId): ?bool {
    $permissionId = $this->getPermissionID($permission);
    if (!is_numeric($permissionId)) {
      return false;
    }
    if ($userId === 0) {
      return null;
    }
    if (!Events::trigger('beforeRemovePermissionFromUser', $userId, $permissionId)) {
      return false;
    }
    return $this->permissionModel->removePermissionFromUser($permissionId, $userId);
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a group.
   *
   * @param int   $userId
   * @param mixed $group
   *
   * @return bool
   */
  public function removeUserFromGroup(int $userId, $group): bool {
    if ($userId === 0) {
      return false;
    }

    if (empty($group) || (!is_numeric($group) && !is_string($group))) {
      return false;
    }

    $groupId = $this->getGroupID($group);

    if (!Events::trigger('beforeRemoveUserFromGroup', $userId, $groupId)) {
      return false;
    }

    if (!is_numeric($groupId)) {
      return false;
    }

    if (!$this->groupModel->removeUserFromGroup($userId, $groupId)) {
      $this->error = $this->groupModel->errors();
      return false;
    }

    Events::trigger('didRemoveUserFromGroup', $userId, $groupId);

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a single user from a role.
   *
   * @param int   $userId
   * @param mixed $role
   *
   * @return bool
   */
  public function removeUserFromRole(int $userId, $role): bool {
    if ($userId === 0) {
      return false;
    }

    if (empty($role) || (!is_numeric($role) && !is_string($role))) {
      return false;
    }

    $roleId = $this->getRoleID($role);

    if (!Events::trigger('beforeRemoveUserFromRole', $userId, $roleId)) {
      return false;
    }

    if (!is_numeric($roleId)) {
      return false;
    }

    if (!$this->roleModel->removeUserFromRole($userId, $roleId)) {
      $this->error = $this->roleModel->errors();
      return false;
    }

    Events::trigger('didRemoveUserFromRole', $userId, $roleId);

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a user from all groups.
   *
   * @param int $userId
   *
   * @return bool|null
   */
  public function removeUserFromAllGroups(int $userId): ?bool {
    if ($userId === 0) {
      return null;
    }

    if (!Events::trigger('beforeRemoveUserFromAllGroups', $userId)) {
      return false;
    }

    return $this->groupModel->removeUserFromAllGroups($userId);
  }

  //---------------------------------------------------------------------------
  /**
   * Removes a user from all roles.
   *
   * @param int $userId
   *
   * @return bool|null
   */
  public function removeUserFromAllRoles(int $userId): ?bool {
    if ($userId === 0) {
      return null;
    }

    if (!Events::trigger('beforeRemoveUserFromAllRoles', $userId)) {
      return false;
    }

    return $this->roleModel->removeUserFromAllRoles($userId);
  }

  //---------------------------------------------------------------------------
  /**
   * Grabs the details about a single role.
   *
   * @param int|string $role
   *
   * @return object|null
   */
  public function role($role): ?object {
    if (is_numeric($role)) {
      return $this->roleModel->find((int)$role);
    }
    return $this->roleModel->where('name', $role)->first();
  }

  //---------------------------------------------------------------------------
  /**
   * Grabs an array of all roles.
   *
   * @return array
   */
  public function roles(): array {
    return $this->roleModel->orderBy('name', 'asc')->findAll();
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all permissions in the system for a role.
   * The role can be either the ID or the name of the role.
   *
   * @param int|string $role
   *
   * @return array
   */
  public function rolePermissions($role): array {
    if (is_numeric($role)) {
      return $this->roleModel->getPermissionsForRole((int)$role);
    } else {
      $r = $this->roleModel->where('name', $role)->first();
      /** @var object $r */
      return $this->roleModel->getPermissionsForRole($r->id);
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Allows the consuming application to pass in a reference to the
   * model that should be used.
   *
   * @param Model $model
   *
   * @return self
   */
  public function setUserModel(Model $model): self {
    $this->userModel = $model;
    return $this;
  }

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
  public function updateGroup(int $id, string $name, string $description = ''): bool {
    $data = [
      'name' => $name,
    ];

    if (!empty($description)) {
      $data['description'] = $description;
    }

    if (!$this->groupModel->update($id, $data)) {
      $this->error = $this->groupModel->errors();
      return false;
    }

    return true;
  }

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
  public function updatePermission(int $id, string $name, string $description = ''): bool {
    $data = [
      'name' => $name,
    ];

    if (!empty($description)) {
      $data['description'] = $description;
    }

    if (!$this->permissionModel->update((int)$id, $data)) {
      $this->error = $this->permissionModel->errors();
      return false;
    }

    return true;
  }

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
  public function updateRole(int $id, string $name, string $description = '', string $bscolor = 'primary'): bool {
    $data = [
      'name' => $name,
      'description' => $description,
      'bscolor' => $bscolor,
    ];

    if (!$this->roleModel->update($id, $data)) {
      $this->error = $this->roleModel->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all users in a group.
   * The group can be either the ID or the name of the group.
   *
   * @param int|string $group
   *
   * @return array
   */
  public function usersInGroup($group): array {
    if (is_numeric($group)) {
      return $this->groupModel->getUsersForGroup((int)$group);
    } else {
      $g = $this->groupModel->where('name', $group)->first();
      /** @var object $g */
      return $this->groupModel->getUsersForGroup($g->id);
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all users in a role.
   * The role can be either the ID or the name of the role.
   *
   * @param int|string $role
   *
   * @return array
   */
  public function usersInRole($role): array {
    if (is_numeric($role)) {
      return $this->roleModel->getUsersForRole((int)$role);
    } else {
      $g = $this->roleModel->where('name', $role)->first();
      /** @var object $g */
      return $this->roleModel->getUsersForRole($g->id);
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all groups of a user.
   *
   * @param int $userId
   *
   * @return array|bool
   */
  public function userGroups($userId): array|bool {
    return $this->groupModel->getGroupsForUser((int)$userId);
  }

  //---------------------------------------------------------------------------
  /**
   * Returns an array of all roles of a user.
   *
   * @param int $userId
   *
   * @return array|bool
   */
  public function userRoles($userId): array|bool {
    return $this->roleModel->getRolesForUser((int)$userId);
  }
}


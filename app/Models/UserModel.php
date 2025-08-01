<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\GroupModel;
use App\Models\RoleModel;
use App\Entities\User;

class UserModel extends Model {
  protected $table = 'users';
  protected $primaryKey = 'id';

  protected $returnType = User::class;
  protected $useSoftDeletes = false;

  protected $allowedFields = [
    'email',
    'username',
    'lastname',
    'firstname',
    'displayname',
    'hidden',
    'password_hash',
    'secret_hash',
    'reset_hash',
    'reset_at',
    'reset_expires',
    'activate_hash',
    'status',
    'status_message',
    'active',
    'force_pass_reset',
    'permissions',
    'deleted_at',
  ];

  protected $useTimestamps = true;

  protected $validationRules = [
    'email' => [ 'required', 'valid_email', 'is_unique[users.email,id,{id}]' ],
    'username' => [ 'required', 'alpha_numeric_punct', 'min_length[3]', 'max_length[30]', 'is_unique[users.username,id,{id}]' ],
    'firstname' => 'max_length[120]',
    'lastname' => 'max_length[120]',
    'displayname' => 'max_length[120]',
    'password_hash' => 'required',
  ];

  protected $validationMessages = [
    'email' => [
      'required' => 'You must enter an email address.',
      'valid_email' => 'Please enter a valid email address.',
      'is_unique[users.email,email,{$data["name"]}]' => 'This email address is already taken.',
    ],
    'username' => [
      'required' => 'You must enter a username.',
      'max_length[80]' => 'The username cannot be longer than 80 characters.',
      'is_unique[users.username,username,{$data["username"]}]' => 'This username is already taken.',
    ],
    'firstname' => [
      'max_length[120]' => 'The first name cannot be longer than 120 characters.',
    ],
    'lastname' => [
      'max_length[120]' => 'The last name cannot be longer than 120 characters.',
    ],
    'displayname' => [
      'max_length[120]' => 'The display name cannot be longer than 120 characters.',
    ],
  ];

  protected $skipValidation = false;

  protected $afterInsert = [ 'addToRole' ];

  /**
   * The id of a group to assign.
   * Set internally by withRole.
   *
   * @var int|null
   */
  protected $assignGroup;

  /**
   * The id of a role to assign.
   * Set internally by withRole.
   *
   * @var int|null
   */
  protected $assignRole;

  /**
   * --------------------------------------------------------------------------
   * Add to Group.
   * --------------------------------------------------------------------------
   *
   * If a default role is assigned in Config\Auth, will add this user to that
   * role. Will do nothing if the role cannot be found.
   *
   * @param mixed $data
   *
   * @return mixed
   */
  protected function addToGroup($data): mixed {
    if (is_numeric($this->assignGroup)) {
      $groupModel = model(GroupModel::class);
      $groupModel->addUserToGroup($data['id'], $this->assignGroup);
    }

    return $data;
  }

  /**
   * --------------------------------------------------------------------------
   * Add to Role.
   * --------------------------------------------------------------------------
   *
   * If a default role is assigned in Config\Auth, will
   * add this user to that role. Will do nothing
   * if the role cannot be found.
   *
   * @param mixed $data
   *
   * @return mixed
   */
  protected function addToRole($data): mixed {
    if (is_numeric($this->assignRole)) {
      $roleModel = model(RoleModel::class);
      $roleModel->addUserToRole($data['id'], $this->assignRole);
    }

    return $data;
  }

  /**
   * --------------------------------------------------------------------------
   * Clear Group.
   * --------------------------------------------------------------------------
   *
   * Clears the group to assign to newly created users.
   *
   * @return $this
   */
  public function clearGroup(): UserModel {
    $this->assignGroup = null;
    return $this;
  }

  /**
   * --------------------------------------------------------------------------
   * Clear Role.
   * --------------------------------------------------------------------------
   *
   * Clears the role to assign to newly created users.
   *
   * @return $this
   */
  public function clearRole(): UserModel {
    $this->assignRole = null;
    return $this;
  }

  /**
   * --------------------------------------------------------------------------
   * Create User.
   * --------------------------------------------------------------------------
   *
   * Creates a user.
   *
   * @param array $data User data
   *
   * @return mixed
   */
  public function createUser($data): mixed {
    $validation = service('validation', null, false);
    $validation->setRules($this->validationRules, $this->validationMessages);

    if (!$validation->run($data)) {
      $this->error = $validation->getErrors();
      return false;
    }

    $id = $this->skipValidation()->insert($data);

    if (is_numeric($id)) {
      return (int)$id;
    }

    $this->error = $this->errors();

    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Delete User.
   * --------------------------------------------------------------------------
   *
   * Deletes a user.
   *
   * @param int $id
   *
   * @return bool
   */
  public function deleteUser(int $id): bool {
    if (!$this->delete($id)) {
      $this->error = $this->errors();
      return false;
    }
    return true;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Basic Info.
   * --------------------------------------------------------------------------
   *
   * Gets one user records basic information.
   *
   * @param int $id User ID
   *
   * @return mixed
   */
  public function getBasicInfo($id): mixed {
    if ($result = $this->db->table($this->table)
      ->select('id, email, username, lastname, firstname, displayname, hidden')
      ->where([ 'id' => $id ])
      ->get()->getResult()) {
      return $result;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Basic Info All.
   * --------------------------------------------------------------------------
   *
   * Gets all user records basic information.
   *
   * @return mixed
   */
  public function getBasicInfoAll(): mixed {
    if ($result = $this->db->table($this->table)
      ->select('id, email, username, lastname, firstname, displayname, hidden')
      ->orderBy('lastname', 'ASC')
      ->get()->getResult()) {
      return $result;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Basic Info Like.
   * --------------------------------------------------------------------------
   *
   * Gets like user records basic information.
   *
   * @param string $match String to match
   *
   * @return mixed
   */
  public function getBasicInfoLike($match): mixed {
    if ($result = $this->db->table($this->table)
      ->select('id, email, username, lastname, firstname, displayname, hidden')
      ->like('username', $match)
      ->orLike('lastname', $match)
      ->orLike('firstname', $match)
      ->orLike('displayname', $match)
      ->orderBy('lastname', 'ASC')
      ->get()->getResult()) {
      return $result;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get by Email.
   * --------------------------------------------------------------------------
   *
   * Gets one user record.
   *
   * @param string $email E-mail
   *
   * @return mixed
   */
  public function getByEmail($email): mixed {
    if ($row = $this->db->table($this->table)->where([ 'email' => $email ])->get()->getRow()) {
      return $row;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get by Username.
   * --------------------------------------------------------------------------
   *
   * Gets one user record.
   *
   * @param string $username Username
   *
   * @return mixed
   */
  public function getByUsername($username): mixed {
    if ($row = $this->db->table($this->table)->where([ 'username' => $username ])->get()->getRow()) {
      return $row;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get by Displayname.
   * --------------------------------------------------------------------------
   *
   * Gets a user's display name.
   *
   * @param int $id User ID
   *
   * @return mixed
   */
  public function getDisplayname($id): mixed {
    if ($row = $this->db->table($this->table)->where([ 'id' => $id ])->get()->getRow()) {
      if (!empty($row->displayname)) {
        return $row->displayname;
      } else {
        $displayName = $row->lastname . ', ' . $row->firstname;
        $this->db->table($this->table)->where([ 'id' => $id ])->set([ 'displayname' => $displayName ])->update();
      }
      return $displayName;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Get Username.
   * --------------------------------------------------------------------------
   *
   * Gets a user's username.
   *
   * @param int $id User ID
   *
   * @return mixed
   */
  public function getUsername($id): mixed {
    if ($row = $this->db->table($this->table)->where([ 'id' => $id ])->get()->getRow()) {
      return $row->username;
    }
    return false;
  }

  /**
   * --------------------------------------------------------------------------
   * Log Activation Attempt.
   * --------------------------------------------------------------------------
   *
   * Logs an activation attempt for posterity sake.
   *
   * @param string|null $token
   * @param string|null $ipAddress
   * @param string|null $userAgent
   *
   * @return void
   */
  public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null): void {
    $this->db->table('activation_attempts')->insert([
      'ip_address' => $ipAddress,
      'user_agent' => $userAgent,
      'token' => $token,
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Log Reset Attempt.
   * --------------------------------------------------------------------------
   *
   * Logs a password reset attempt for posterity sake.
   *
   * @param string      $email
   * @param string|null $token
   * @param string|null $ipAddress
   * @param string|null $userAgent
   *
   * @return void
   */
  public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null): void {
    $this->db->table('reset_attempts')->insert([
      'email' => $email,
      'ip_address' => $ipAddress,
      'user_agent' => $userAgent,
      'token' => $token,
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * With Group.
   * --------------------------------------------------------------------------
   *
   * Sets the group to assign when a user is created.
   *
   * @param string $groupName
   *
   * @return $this
   */
  public function withGroup(string $groupName): UserModel {
    $group = $this->db->table('groups')->where('name', $groupName)->get()->getFirstRow();
    $this->assignGroup = $group->id;
    return $this;
  }

  /**
   * --------------------------------------------------------------------------
   * With Role.
   * --------------------------------------------------------------------------
   *
   * Sets the role to assign when a user is created.
   *
   * @param string $roleName
   *
   * @return $this
   */
  public function withRole(string $roleName) {
    $role = $this->db->table('roles')->where('name', $roleName)->get()->getFirstRow();
    $this->assignRole = $role->id;
    return $this;
  }
}

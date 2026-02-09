<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;

/**
 * UserModel
 */
class UserModel extends Model
{
  /** @var mixed */
  public $error;

  protected $table              = 'users';
  protected $primaryKey         = 'id';
  protected $returnType         = User::class;
  protected $useSoftDeletes     = false;
  protected $allowedFields      = [
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
  protected $useTimestamps      = true;
  protected $validationRules    = [
    'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
    'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
    'firstname'     => 'max_length[120]',
    'lastname'      => 'max_length[120]',
    'displayname'   => 'max_length[120]',
    'password_hash' => 'required',
  ];
  protected $validationMessages = [
    'email'       => [
      'required'                                     => 'You must enter an email address.',
      'valid_email'                                  => 'Please enter a valid email address.',
      'is_unique[users.email,email,{$data["name"]}]' => 'This email address is already taken.',
    ],
    'username'    => [
      'required'                                               => 'You must enter a username.',
      'max_length[80]'                                         => 'The username cannot be longer than 80 characters.',
      'is_unique[users.username,username,{$data["username"]}]' => 'This username is already taken.',
    ],
    'firstname'   => [
      'max_length[120]' => 'The first name cannot be longer than 120 characters.',
    ],
    'lastname'    => [
      'max_length[120]' => 'The last name cannot be longer than 120 characters.',
    ],
    'displayname' => [
      'max_length[120]' => 'The display name cannot be longer than 120 characters.',
    ],
  ];
  protected $skipValidation     = false;
  protected $afterInsert        = ['addToRole'];

  /**
   * The id of a group to assign.
   * Set internally by withRole.
   */
  protected ?int $assignGroup = null;

  /**
   * The id of a role to assign.
   * Set internally by withRole.
   */
  protected ?int $assignRole = null;

  //---------------------------------------------------------------------------
  /**
   * Adds this user to a group if prescribed.
   *
   * @param array $data User record.
   *
   * @return array The original data array.
   */
  protected function addToGroup(array $data): array {
    if ($this->assignGroup !== null) {
      $groupModel = model(GroupModel::class);
      $groupModel->addUserToGroup((int) $data['id'], $this->assignGroup);
    }

    return $data;
  }

  //---------------------------------------------------------------------------
  /**
   * Adds this user to a role if prescribed.
   *
   * @param array $data User record.
   *
   * @return array The original data array.
   */
  protected function addToRole(array $data): array {
    if ($this->assignRole !== null) {
      $roleModel = model(RoleModel::class);
      $roleModel->addUserToRole((int) $data['id'], $this->assignRole);
    }

    return $data;
  }

  //---------------------------------------------------------------------------
  /**
   * Clears the group to assign to newly created users.
   *
   * @return $this
   */
  public function clearGroup(): self {
    $this->assignGroup = null;
    return $this;
  }

  //---------------------------------------------------------------------------
  /**
   * Clears the role to assign to newly created users.
   *
   * @return $this
   */
  public function clearRole(): self {
    $this->assignRole = null;
    return $this;
  }

  //---------------------------------------------------------------------------
  /**
   * Creates a user.
   *
   * @param array $data User data.
   *
   * @return int|bool Result ID or false on failure.
   */
  public function createUser(array $data): int|bool {
    $validation = service('validation', null, false);
    $validation->setRules($this->validationRules, $this->validationMessages);

    if (!$validation->run($data)) {
      $this->error = $validation->getErrors();
      return false;
    }

    $id = $this->skipValidation()->insert($data);

    if (is_numeric($id)) {
      return (int) $id;
    }

    $this->error = $this->errors();

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Deletes a user.
   *
   * @param int $id User ID.
   *
   * @return bool True if successful, false otherwise.
   */
  public function deleteUser(int $id): bool {
    if (!$this->delete($id)) {
      $this->error = $this->errors();
      return false;
    }

    return true;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets one user record's basic information.
   *
   * @param int|string $id User ID.
   *
   * @return array|bool Array of basic info objects or false if not found.
   */
  public function getBasicInfo(int|string $id): array|bool {
    if (
      $result = $this->db->table($this->table)
        ->select('id, email, username, lastname, firstname, displayname, hidden')
        ->where(['id' => $id])
        ->get()->getResult()
    ) {
      return $result;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets all user record's basic information.
   *
   * @return array|bool Array of all basic info objects or false on failure.
   */
  public function getBasicInfoAll(): array|bool {
    if (
      $result = $this->db->table($this->table)
        ->select('id, email, username, lastname, firstname, displayname, hidden')
        ->orderBy('lastname', 'ASC')
        ->get()->getResult()
    ) {
      return $result;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets user record's basic information matching a search string.
   *
   * @param string $match String to match.
   *
   * @return array|bool Array of basic info objects or false.
   */
  public function getBasicInfoLike(string $match): array|bool {
    if (
      $result = $this->db->table($this->table)
        ->select('id, email, username, lastname, firstname, displayname, hidden')
        ->like('username', $match)
        ->orLike('lastname', $match)
        ->orLike('firstname', $match)
        ->orLike('displayname', $match)
        ->orderBy('lastname', 'ASC')
        ->get()->getResult()
    ) {
      return $result;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets one user record by email.
   *
   * @param string $email E-mail.
   *
   * @return object|bool User object or false if not found.
   */
  public function getByEmail(string $email): object|bool {
    if ($row = $this->db->table($this->table)->where(['email' => $email])->get()->getRow()) {
      return $row;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets one user record by username.
   *
   * @param string $username Username.
   *
   * @return object|bool User object or false if not found.
   */
  public function getByUsername(string $username): object|bool {
    if ($row = $this->db->table($this->table)->where(['username' => $username])->get()->getRow()) {
      return $row;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets a user's display name.
   *
   * @param int|string $id User ID.
   *
   * @return string|bool Display name or false if not found.
   */
  public function getDisplayname(int|string $id): string|bool {
    if ($row = $this->db->table($this->table)->where(['id' => $id])->get()->getRow()) {
      /** @var object $row */
      if (!empty($row->displayname)) {
        return (string) $row->displayname;
      }

      $displayName = (string) $row->lastname . ', ' . (string) $row->firstname;
      $this->db->table($this->table)->where(['id' => $id])->set(['displayname' => $displayName])->update();

      return $displayName;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Gets a user's username.
   *
   * @param int|string $id User ID.
   *
   * @return string|bool Username or false if not found.
   */
  public function getUsername(int|string $id): string|bool {
    if ($row = $this->db->table($this->table)->where(['id' => $id])->get()->getRow()) {
      /** @var object $row */
      return (string) $row->username;
    }

    return false;
  }

  //---------------------------------------------------------------------------
  /**
   * Logs an activation attempt.
   *
   * @param string|null $token     Activation token.
   * @param string|null $ipAddress IP address.
   * @param string|null $userAgent User agent.
   *
   * @return void
   */
  public function logActivationAttempt(?string $token = null, ?string $ipAddress = null, ?string $userAgent = null): void {
    $this->db->table('activation_attempts')->insert([
      'ip_address' => $ipAddress,
      'user_agent' => $userAgent,
      'token'      => $token,
      'created_at' => date('Y-m-d H:i:s'),
    ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Logs a password reset attempt.
   *
   * @param string      $email     User email.
   * @param string|null $token     Reset token.
   * @param string|null $ipAddress IP address.
   * @param string|null $userAgent User agent.
   *
   * @return void
   */
  public function logResetAttempt(string $email, ?string $token = null, ?string $ipAddress = null, ?string $userAgent = null): void {
    $this->db->table('reset_attempts')->insert([
      'email'      => $email,
      'ip_address' => $ipAddress,
      'user_agent' => $userAgent,
      'token'      => $token,
      'created_at' => date('Y-m-d H:i:s'),
    ]);
  }

  //---------------------------------------------------------------------------
  /**
   * Sets the group to assign when a user is created.
   *
   * @param string $groupName Group name.
   *
   * @return $this
   */
  public function withGroup(string $groupName): self {
    $group = $this->db->table('groups')->where('name', $groupName)->get()->getFirstRow();

    if ($group) {
      /** @var object $group */
      $this->assignGroup = (int) $group->id;
    }

    return $this;
  }

  //---------------------------------------------------------------------------
  /**
   * Sets the role to assign when a user is created.
   *
   * @param string $roleName Role name.
   *
   * @return $this
   */
  public function withRole(string $roleName): self {
    $role = $this->db->table('roles')->where('name', $roleName)->get()->getFirstRow();

    if ($role) {
      /** @var object $role */
      $this->assignRole = (int) $role->id;
    }

    return $this;
  }
}


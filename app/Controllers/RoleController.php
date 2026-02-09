<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Authorization\FlatAuthorization;
use App\Models\RoleModel;
use CodeIgniter\Validation\Validation;
use Config\Auth as AuthConfig;

/**
 * Class RoleController
 */
class RoleController extends BaseController
{
  /**
   * Check the BaseController for inherited properties and methods.
   */

  /**
   * @var string Log type used in log entries from this controller.
   */
  protected string $logType;

  /**
   * @var FlatAuthorization
   */
  protected FlatAuthorization $auth;

  /**
   * @var AuthConfig
   */
  protected AuthConfig $authConfig;

  /**
   * @var Validation
   */
  protected Validation $validation;

  //---------------------------------------------------------------------------
  /**
   * Constructor.
   */
  public function __construct() {
    $this->logType    = 'Role';
    $this->authConfig = config('Auth');
    $this->auth       = service('authorization');
    $this->validation = service('validation');
  }

  //---------------------------------------------------------------------------
  /**
   * Shows all role records.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function roles(): \CodeIgniter\HTTP\RedirectResponse|string {
    $roles    = model(RoleModel::class);
    $allRoles = $roles->orderBy('name', 'asc')->findAll();

    $data = [
      'config' => $this->authConfig,
      'roles'  => $allRoles,
    ];

    $rolePermissions = [];

    foreach ($allRoles as $role) {
      /** @var object $role */
      $rolePermissions[$role->id][] = $roles->getPermissionsForRole($role->id);
    }
    $data['rolePermissions'] = $rolePermissions;

    if ($this->request->is('post')) {
      //
      // A form was submitted. Let's see what it was...
      //
      if (array_key_exists('btn_delete', $this->request->getPost())) {
        //
        // [Delete]
        //
        $recId = $this->request->getPost('hidden_id');
        $role  = $roles->where('id', $recId)->first();
        /** @var object|null $role */
        if (!$role) {
          return redirect()->route('roles')->with('errors', str_replace('{0}', (string)$recId, lang('Auth.role.not_found')));
        } else {
          if (!$roles->deleteRole($recId)) {
            $this->session->set('errors', $roles->errors());
            return $this->_render($this->authConfig->views['roles'], $data);
          }
          logEvent(
            [
              'type'  => $this->logType,
              'event' => str_replace('{0}', $role->name, lang('Auth.role.delete_success')),
              'user'  => user_username(),
              'ip'    => $this->request->getIPAddress(),
            ]
          );
          return redirect()->route('roles')->with('success', str_replace('{0}', $role->name, lang('Auth.role.delete_success')));
        }
      } elseif (
        array_key_exists('btn_search', $this->request->getPost()) && array_key_exists(
          'search',
          $this->request->getPost()
        )
      ) {
        //
        // [Search]
        //
        $search         = $this->request->getPost('search');
        $where          = '`name` LIKE "%' . $search . '%" OR `description` LIKE "%' . $search . '%"';
        $data['roles']  = $roles->where($where)->orderBy('name', 'asc')->findAll();
        $data['search'] = $search;
      }
    }

    return $this->_render($this->authConfig->views['roles'], $data);
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the role create page.
   *
   * @param int|null $id Role ID
   *
   * @return string
   */
  public function rolesCreate($id = null): string {
    return $this->_render($this->authConfig->views['rolesCreate'], ['config' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Attempt to create a new role.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function rolesCreateDo(): \CodeIgniter\HTTP\RedirectResponse {
    $roles = model(RoleModel::class);
    $form  = [];

    //
    // Get form fields
    //
    $form['name']        = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');
    $form['bscolor']     = $this->request->getPost('bscolor');

    //
    // Set validation rules for adding a new role
    //
    $validationRules = [
      'name'        => [
        'label'  => lang('Auth.role.name'),
        'rules'  => 'required|trim|max_length[255]|is_unique[roles.name]',
        'errors' => [
          'is_unique' => str_replace('{0}', $form['name'], lang('Auth.role.not_unique')),
        ],
      ],
      'description' => [
        'label' => lang('Auth.role.description'),
        'rules' => 'permit_empty|trim|max_length[255]',
      ],
    ];

    //
    // Validate input
    //
    $this->validation->setRules($validationRules);
    if (!$this->validation->run($form)) {
      //
      // Return validation error
      //
      return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    } else {
      //
      // Save the role
      // Return to Create screen on fail
      //
      $id = $this->auth->createRole(
        $this->request->getPost('name'),
        $this->request->getPost('description'),
        $this->request->getPost('bscolor')
      );
      if (!$id) {
        return redirect()->back()->withInput()->with('errors', $roles->errors());
      }

      //
      // Success! Go back to role list
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => str_replace('{0}', $this->request->getPost('name'), lang('Auth.role.create_success')),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->route('roles')->with(
        'success',
        str_replace('{0}', $this->request->getPost('name'), lang('Auth.role.create_success'))
      );
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the role edit page.
   *
   * @param int|null $id Role ID
   *
   * @return mixed
   */
  public function rolesEdit($id = null): mixed {
    $roles = model(RoleModel::class);

    $role = $roles->where('id', $id)->first();
    /** @var object|null $role */
    if (!$role) {
      return redirect()->to('roles');
    }

    $permissions     = $this->auth->permissions();
    $rolePermissions = $roles->getPermissionsForRole($id);

    return $this->_render(
      $this->authConfig->views['rolesEdit'],
      [
        'config'          => $this->authConfig,
        'role'            => $role,
        'permissions'     => $permissions,
        'rolePermissions' => $rolePermissions,
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Attempt to create a new role.
   *
   * @param int|null $id Role ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function rolesEditDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $roles = model(RoleModel::class);
    $form  = [];

    //
    // Get the role to edit. If not found, return to roles list page.
    //
    $role = $roles->where('id', $id)->first();
    /** @var object|null $role */
    if (!$role) {
      return redirect()->to('roles');
    }

    //
    // Set basic validation rules for editing an existing role.
    //
    $validationRules = [
      'name'        => [
        'label' => lang('Auth.role.name'),
        'rules' => 'required|trim|max_length[255]',
      ],
      'description' => [
        'label' => lang('Auth.role.description'),
        'rules' => 'permit_empty|trim|max_length[255]',
      ],
    ];

    //
    // Get form fields
    //
    $form['name']        = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');
    $form['bscolor']     = $this->request->getPost('bscolor');

    //
    // If the role name changed, make sure the validator checks its uniqueness.
    //
    if ($form['name'] !== $role->name) {
      $validationRules['name'] = [
        'label'  => lang('Auth.role.name'),
        'rules'  => 'required|trim|max_length[255]|is_unique[roles.name]',
        'errors' => [
          'is_unique' => str_replace('{0}', $form['name'], lang('Auth.role.not_unique')),
        ],
      ];
    }

    //
    // Validate input
    //
    $this->validation->setRules($validationRules);
    if (!$this->validation->run($form)) {
      //
      // Return validation error
      //
      return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    } else {
      //
      // Save the role name, description and bscolor
      //
      $res = $this->auth->updateRole($id, $form['name'], $form['description'], $form['bscolor']);
      if (!$res) {
        return redirect()->back()->withInput()->with('errors', $roles->errors());
      }

      //
      // Save the permissions given to this role.
      // First, delete all permissions, then add each selected one.
      //
      $roles->removeAllPermissionsFromRole((int)$id);
      if (array_key_exists('sel_permissions', $this->request->getPost())) {
        foreach ($this->request->getPost('sel_permissions') as $perm) {
          $roles->addPermissionToRole($perm, $id);
        }
      }

      //
      // Success! Go back to roles list
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => str_replace('{0}', $role->name, lang('Auth.role.update_success')),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', str_replace('{0}', $role->name, lang('Auth.role.update_success')));
    }
  }
}

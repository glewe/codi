<?php

namespace App\Controllers;

use CodeIgniter\Session\Session;

use Config\Auth as AuthConfig;
use App\Models\PermissionModel;

use App\Controllers\BaseController;
use Config\Validation;
use App\Models\LogModel;

class PermissionController extends BaseController {
  /**
   * @var string Log type used in log entries from this controller.
   */
  protected $logType;

  protected $auth;

  /**
   * @var AuthConfig
   */
  protected $authConfig;

  /**
   * @var Session
   */
  protected $session;

  /**
   * @var \CodeIgniter\Validation\Validation
   */
  protected $validation;

  /**
   * --------------------------------------------------------------------------
   * Constructor.
   * --------------------------------------------------------------------------
   */
  public function __construct() {
    //
    // Most services in this controller require the session to be started
    //
    $this->LOG = model(LogModel::class);
    $this->logType = 'Permission';
    $this->session = service('session');
    $this->authConfig = config('Auth');
    $this->auth = service('authorization');
    $this->validation = service('validation');
  }

  /**
   * --------------------------------------------------------------------------
   * Permissions.
   * --------------------------------------------------------------------------
   *
   * Shows all permission records.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function permissions(): \CodeIgniter\HTTP\RedirectResponse | string {
    $permissions = model(PermissionModel::class);

    $data = [
      'config' => $this->authConfig,
      'permissions' => $permissions->orderBy('name', 'asc')->findAll(),
    ];

    if ($this->request->withMethod('POST')) {
      //
      // A form was submitted. Let's see what it was...
      //
      if (array_key_exists('btn_delete', $this->request->getPost())) {
        //
        // [Delete]
        //
        $recId = $this->request->getPost('hidden_id');
        $permission = $permissions->where('id', $recId)->first();
        /** @var object|null $permission */
        if (!$permission) {
          return redirect()->route('permissions')->with('errors', lang('Auth.permission.not_found', [ $recId ]));
        } else {
          if (!$permissions->deletePermission($recId)) {
            $this->session->set('errors', $permissions->errors());
            return $this->_render($this->authConfig->views['permissions'], $data);
          }
          logEvent(
            [
              'type' => $this->logType,
              'event' => lang('Auth.permission.delete_success', [ $permission->name ]),
              'user' => user_username(),
              'ip' => $this->request->getIPAddress(),
            ]
          );
          return redirect()->route('permissions')->with('success', lang('Auth.permission.delete_success', [ $permission->name ]));
        }
      } elseif (array_key_exists('btn_search', $this->request->getPost()) && array_key_exists('search', $this->request->getPost())) {
        //
        // [Search]
        //
        $search = $this->request->getPost('search');
        $where = '`name` LIKE "%' . $search . '%" OR `description` LIKE "%' . $search . '%"';
        $data['permissions'] = $permissions->where($where)->orderBy('name', 'asc')->findAll();
        $data['search'] = $search;
      }
    }

    //
    // Show the list view
    //
    return $this->_render($this->authConfig->views['permissions'], $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Permissions Create.
   * --------------------------------------------------------------------------
   *
   * Displays the user create page.
   *
   * @return mixed
   */
  public function permissionsCreate($id = null): mixed {
    return $this->_render($this->authConfig->views['permissionsCreate'], [ 'config' => $this->authConfig ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Permissions Create Do.
   * --------------------------------------------------------------------------
   *
   * Attempt to create a new user.
   * To be be used by administrators. User will be activated automatically.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function permissionsCreateDo(): \CodeIgniter\HTTP\RedirectResponse {
    $permissions = model(PermissionModel::class);
    $form = array();

    //
    // Get form fields
    //
    $form['name'] = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');

    //
    // Set validation rules for adding a new group
    //
    $validationRules = [
      'name' => [
        'label' => lang('Auth.permission.name'),
        'rules' => 'required|trim|max_length[255]|lower_alpha_dash_dot|is_unique[permissions.name]',
        'errors' => [
          'is_unique' => lang('Auth.permission.not_unique', [ $form['name'] ])
        ]
      ],
      'description' => [
        'label' => lang('Auth.permission.description'),
        'rules' => 'permit_empty|trim|max_length[255]'
      ]
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
      // Save the permission
      // Return to Create screen on fail
      //
      $id = $this->auth->createPermission(strtolower($this->request->getPost('name')), $this->request->getPost('description'));
      if (!$id) {
        return redirect()->back()->withInput()->with('errors', $permissions->errors());
      }

      //
      // Success! Go back to permission list
      //
      logEvent(
        [
          'type' => $this->logType,
          'event' => lang('Auth.permission.create_success', [ $this->request->getPost('name') ]),
          'user' => user_username(),
          'ip' => $this->request->getIPAddress(),
        ]
      );
      return redirect()->route('permissions')->with('success', lang('Auth.permission.create_success', [ $this->request->getPost('name') ]));
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Permissions Edit.
   * --------------------------------------------------------------------------
   *
   * Displays the user edit page.
   *
   * @param int $id Permission ID
   *
   * @return mixed
   */
  public function permissionsEdit($id = null): mixed {
    $permissions = model(PermissionModel::class);
    $permission = $permissions->where('id', $id)->first();
    /** @var object|null $permission */
    if (!$permission) {
      return redirect()->to('permissions');
    }

    $permGroups = $permissions->getGroupsForPermission($id);
    $permRoles = $permissions->getRolesForPermission($id);
    $permUsers = $permissions->getUsersForPermission($id);

    return $this->_render($this->authConfig->views['permissionsEdit'], [
      'config' => $this->authConfig,
      'permission' => $permission,
      'permGroups' => $permGroups,
      'permRoles' => $permRoles,
      'permUsers' => $permUsers,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Permissions edit do.
   * --------------------------------------------------------------------------
   *
   * Attempt to create a new permission.
   *
   * @param int $id Permission ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function permissionsEditDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $permissions = model(PermissionModel::class);
    $form = array();

    //
    // Get the permission to edit. If not found, return to permissions list page.
    //
    $permission = $permissions->where('id', $id)->first();
    /** @var object|null $permission */
    if (!$permission) {
      return redirect()->to('permissions');
    }

    //
    // Set basic validation rules for editing an existing permission.
    //
    $validationRules = [
      'name' => [
        'label' => lang('Auth.permission.name'),
        'rules' => 'required|trim|max_length[255]|lower_alpha_dash_dot'
      ],
      'description' => [
        'label' => lang('Auth.permission.description'),
        'rules' => 'permit_empty|trim|max_length[255]'
      ]
    ];

    //
    // Get form fields
    //
    $form['name'] = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');

    //
    // If the permission name changed, make sure the validator checks its uniqueness.
    //
    if ($form['name'] != $permission->name) {
      $validationRules['name'] = [
        'label' => lang('Auth.permission.name'),
        'rules' => 'required|trim|max_length[255]|lower_alpha_dash_dot|is_unique[permissions.name]',
        'errors' => [
          'is_unique' => lang('Auth.permission.not_unique', [ $form['name'] ])
        ]
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
      // Save the permission
      //
      $id = $this->auth->updatePermission($id, strtolower($form['name']), $form['description']);
      if (!$id) {
        return redirect()->back()->withInput()->with('errors', $permissions->errors());
      }

      //
      // Success! Go back to permissions list
      //
      logEvent(
        [
          'type' => $this->logType,
          'event' => lang('Auth.permission.update_success', [ $permission->name ]),
          'user' => user_username(),
          'ip' => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', lang('Auth.permission.update_success', [ $permission->name ]));
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Format permission name.
   * --------------------------------------------------------------------------
   *
   * @param string $name
   *
   * @return string
   */
  protected function _formatPermission(string $name): string {
    return "";
  }
}

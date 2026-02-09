<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Authorization\FlatAuthorization;
use App\Models\GroupModel;
use CodeIgniter\Validation\Validation;
use Config\Auth as AuthConfig;

/**
 * Class GroupController
 */
class GroupController extends BaseController
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
    //
    // Most services in this controller require the session to be started
    //
    $this->validation = service('validation');
    $this->logType    = 'Group';
    $this->authConfig = config('Auth');
    $this->auth       = service('authorization');
  }

  //---------------------------------------------------------------------------
  /**
   * Shows all user records.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   */
  public function groups(): \CodeIgniter\HTTP\RedirectResponse|string {
    $groups    = model(GroupModel::class);
    $allGroups = $groups->orderBy('name', 'asc')->findAll();

    $data = [
      'config' => $this->authConfig,
      'groups' => $allGroups,
    ];

    $groupPermissions = [];

    foreach ($allGroups as $group) {
      /** @var object $group */
      $groupPermissions[$group->id][] = $groups->getPermissionsForGroup($group->id);
    }
    $data['groupPermissions'] = $groupPermissions;

    if ($this->request->is('post')) {
      //
      // A form was submitted. Let's see what it was...
      //
      if (array_key_exists('btn_delete', $this->request->getPost())) {
        //
        // [Delete]
        //
        $recId = $this->request->getPost('hidden_id');
        /** @var object|null $group */
        if (!$group = $groups->where('id', $recId)->first()) {
          return redirect()->route('groups')->with('errors', str_replace('{0}', (string)$recId, lang('Auth.group.not_found')));
        } else {
          if (!$groups->deleteGroup((int) $recId)) {
            $this->session->set('errors', $groups->errors());
            return $this->_render($this->authConfig->views['groups'], $data);
          }
          logEvent(
            [
              'type'  => $this->logType,
              'event' => str_replace('{0}', $group->name, lang('Auth.group.delete_success')),
              'user'  => user_username(),
              'ip'    => $this->request->getIPAddress(),
            ]
          );
          return redirect()->route('groups')->with('success', str_replace('{0}', $group->name, lang('Auth.group.delete_success')));
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
        $data['groups'] = $groups->where($where)->orderBy('name', 'asc')->findAll();
        $data['search'] = $search;
      }
    }

    return $this->_render($this->authConfig->views['groups'], $data);
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the user create page.
   *
   * @param string|null $id
   *
   * @return string
   */
  public function groupsCreate($id = null): string {
    return $this->_render($this->authConfig->views['groupsCreate'], ['config' => $this->authConfig]);
  }

  //---------------------------------------------------------------------------
  /**
   * Attempt to create a new user.
   * To be be used by administrators. User will be activated automatically.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function groupsCreateDo(): \CodeIgniter\HTTP\RedirectResponse {
    $groups = model(GroupModel::class);
    $form   = [];

    //
    // Get form fields
    //
    $form['name']        = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');

    //
    // Set validation rules for adding a new group
    //
    $validationRules = [
      'name'        => [
        'label'  => lang('Auth.group.name'),
        'rules'  => 'required|trim|max_length[255]|is_unique[groups.name]',
        'errors' => [
          'is_unique' => str_replace('{0}', $form['name'], lang('Auth.group.not_unique')),
        ],
      ],
      'description' => [
        'label' => lang('Auth.group.description'),
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
      // Save the group
      // Return to Create screen on fail
      //
      $id = $this->auth->createGroup($this->request->getPost('name'), $this->request->getPost('description'));
      if (!$id) {
        return redirect()->back()->withInput()->with('errors', $groups->errors());
      }

      //
      // Success! Go back to user list
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => str_replace('{0}', $this->request->getPost('name'), lang('Auth.group.create_success')),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->route('groups')->with(
        'success',
        str_replace('{0}', $this->request->getPost('name'), lang('Auth.group.create_success'))
      );
    }
  }

  //---------------------------------------------------------------------------
  /**
   * Displays the user edit page.
   *
   * @param int|string|null $id Group ID
   *
   * @return string|\CodeIgniter\HTTP\RedirectResponse
   */
  public function groupsEdit($id = null): string|\CodeIgniter\HTTP\RedirectResponse {
    $groups = model(GroupModel::class);

    $group = $groups->where('id', $id)->first();
    /** @var object|null $group */
    if (!$group) {
      return redirect()->to('groups');
    }

    $permissions      = $this->auth->permissions();
    $groupPermissions = $groups->getPermissionsForGroup($id);

    return $this->_render(
      $this->authConfig->views['groupsEdit'],
      [
        'config'           => $this->authConfig,
        'group'            => $group,
        'permissions'      => $permissions,
        'groupPermissions' => $groupPermissions,
      ]
    );
  }

  //---------------------------------------------------------------------------
  /**
   * Attempt to edit a group.
   *
   * @param int|string|null $id Group ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function groupsEditDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $groups = model(GroupModel::class);
    $form   = [];

    //
    // Get the group to edit. If not found, return to groups list page.
    //
    $group = $groups->where('id', $id)->first();
    /** @var object|null $group */
    if (!$group) {
      return redirect()->to('groups');
    }

    //
    // Set basic validation rules for editing an existing group.
    //
    $validationRules = [
      'name'        => [
        'label' => lang('Auth.group.name'),
        'rules' => 'required|trim|max_length[255]',
      ],
      'description' => [
        'label' => lang('Auth.group.description'),
        'rules' => 'permit_empty|trim|max_length[255]',
      ],
    ];

    //
    // Get form fields
    //
    $form['name']        = $this->request->getPost('name');
    $form['description'] = $this->request->getPost('description');

    //
    // If the group name changed, make sure the validator checks its uniqueness.
    //
    if ($form['name'] != $group->name) {
      $validationRules['name'] = [
        'label'  => lang('Auth.group.name'),
        'rules'  => 'required|trim|max_length[255]|is_unique[groups.name]',
        'errors' => [
          'is_unique' => str_replace('{0}', $form['name'], lang('Auth.group.not_unique')),
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
      // Save the group name and description
      //
      $groups->update($id, $form);
      //
      // Now, save the permissions given to this group.
      // First, delete all permissions, then add each selected one.
      //
      $groups->removeAllPermissionsFromGroup((int) $id);
      if (array_key_exists('sel_permissions', $this->request->getPost())) {
        foreach ($this->request->getPost('sel_permissions') as $perm) {
          $groups->addPermissionToGroup((int) $perm, (int) $id);
        }
      }
      //
      // Success! Go back to groups list
      //
      logEvent(
        [
          'type'  => $this->logType,
          'event' => str_replace('{0}', $group->name, lang('Auth.group.update_success')),
          'user'  => user_username(),
          'ip'    => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', str_replace('{0}', $group->name, lang('Auth.group.update_success')));
    }
  }
}

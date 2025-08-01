<?php

namespace App\Controllers;

use CodeIgniter\Session\Session;

use App\Config\Auth as AuthConfig;
use App\Entities\User;
use App\Models\UserModel;
use App\Models\UserOptionModel;

use App\Controllers\BaseController;
use Config\Validation;
use App\Libraries\Gravatar;
use App\Models\SettingsModel;
use App\Models\LogModel;

class UserController extends BaseController {
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
   * @var SettingsModel
   */
  protected $settings;

  /**
   * @var UserOptionModel
   */
  protected $UOP;

  /**
   * @var Validation
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
    $this->logType = 'User';
    $this->settings = model(SettingsModel::class);
    $this->session = service('session');
    $this->authConfig = config('Auth');
    $this->authorize = service('authorization');
    $this->validation = service('validation');
    $this->UOP = model(UserOptionModel::class);
  }

  /**
   * --------------------------------------------------------------------------
   * Users.
   * --------------------------------------------------------------------------
   *
   * Shows all user records.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function users(): \CodeIgniter\HTTP\RedirectResponse|string {
    $users = model(UserModel::class);

    $data = [
      'config' => $this->authConfig,
      'users' => $users->orderBy('username', 'asc')->findAll(),
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
        if (!$user = $users->where('id', $recId)->first()) {
          return redirect()->route('users')->with('errors', lang('Auth.user.not_found', [ $recId ]));
        } else {
          if (!$users->deleteUser($recId)) {
            $this->session->set('errors', $users->errors());
            return $this->_render($this->authConfig->views['users'], $data);
          }
          logEvent(
            [
              'type' => $this->logType,
              'event' => lang('Auth.user.delete_success', [ $user->username, $user->email ]),
              'user' => user_username(),
              'ip' => $this->request->getIPAddress(),
            ]
          );
          return redirect()->route('users')->with('success', lang('Auth.user.delete_success', [ $user->username, $user->email ]));
        }
      } elseif (array_key_exists('btn_remove_secret', $this->request->getPost())) {
        //
        // [Remove Secret]
        //
        $recId = $this->request->getPost('hidden_id');
        if (!$user = $users->where('id', $recId)->first()) {
          return redirect()->route('users')->with('errors', lang('Auth.user.not_found', [ $recId ]));
        } else {
          $user->removeSecret();
          if (!$users->update($recId, $user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
          } else {
            logEvent(
              [
                'type' => $this->logType,
                'event' => lang('Auth.user.remove_secret_success', [ $user->username, $user->email ]),
                'user' => user_username(),
                'ip' => $this->request->getIPAddress(),
              ]
            );
            return redirect()->route('users')->with('success', lang('Auth.user.remove_secret_success', [ $user->username, $user->email ]));
          }
        }
      } elseif (array_key_exists('btn_search', $this->request->getPost()) && array_key_exists('search', $this->request->getPost())) {
        //
        // [Search]
        //
        $search = $this->request->getPost('search');
        $where = '`username` LIKE "%' . $search . '%" OR `email` LIKE "%' . $search . '%"';
        $data['users'] = $users->where($where)->orderBy('username', 'asc')->findAll();
        $data['search'] = $search;
      }
    }

    return $this->_render($this->authConfig->views['users'], $data);
  }

  /**
   * --------------------------------------------------------------------------
   * Users Create.
   * --------------------------------------------------------------------------
   *
   * Displays the user create page.
   *
   * @param int $id User ID
   *
   * @return string
   */
  public function usersCreate($id = null): string {
    return $this->_render($this->authConfig->views['usersCreate'], [ 'config' => $this->authConfig ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Users Create Do.
   * --------------------------------------------------------------------------
   *
   * Attempt to create a new user.
   * To be be used by administrators. User will be activated automatically.
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function usersCreateDo(): \CodeIgniter\HTTP\RedirectResponse {
    $users = model(UserModel::class);

    //
    // Validate basics first since some password rules rely on these fields
    //
    $rules = [
      'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
      'email' => 'required|valid_email|is_unique[users.email]',
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    //
    // Validate passwords since they can only be validated properly here
    //
    $rules = [
      'password' => 'required|strong_password',
      'pass_confirm' => 'required|matches[password]',
      'firstname' => 'max_length[80]',
      'lastname' => 'max_length[80]',
      'displayname' => 'max_length[80]',
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    //
    // Create the user entity
    //
    $allowedPostFields = array_merge([ 'password' ], $this->authConfig->validFields, $this->authConfig->personalFields);
    $user = new User($this->request->getPost($allowedPostFields));
    $user->activate();
    $user->setAttribute('firstname', $this->request->getPost('firstname'));
    $user->setAttribute('lastname', $this->request->getPost('lastname'));
    if ($this->request->getPost('displayname') === '') {
      $user->setAttribute('displayname', $this->request->getPost('lastname') . ', ' . $this->request->getPost('firstname'));
    } else {
      $user->setAttribute('displayname', $this->request->getPost('displayname'));
    }

    //
    // Assign default role if set
    //
    if (!empty($this->authConfig->defaultUserRole)) {
      $users = $users->withRole($this->authConfig->defaultUserRole);
    }

    //
    // Generate password reset hash
    //
    if ($this->request->getPost('pass_resetmail')) {
      $user->forcePasswordReset();
      // $user->generateResetHash()
    }

    //
    // Hide user from calendar if selected
    //
    if ($this->request->getPost('hidden')) {
      $user->hide();
    }

    //
    // Save user record. Return to Create screen on fail.
    //
    if (!$users->save($user)) {
      return redirect()->back()->withInput()->with('errors', $users->errors());
    }

    //
    // Set default options
    //
    $newUser = $users->getByUsername($this->request->getPost('username'));
    $this->UOP->saveOption([ 'user_id' => $newUser->id, 'option' => 'avatar', 'value' => 'default_male.png' ]);
    $this->UOP->saveOption([ 'user_id' => $newUser->id, 'option' => 'theme', 'value' => 'default' ]);
    $this->UOP->saveOption([ 'user_id' => $newUser->id, 'option' => 'menu', 'value' => 'navbar' ]);
    $this->UOP->saveOption([ 'user_id' => $newUser->id, 'option' => 'language', 'value' => 'default' ]);

    //
    // Send password reset email to the created user
    //
    if ($this->request->getPost('pass_resetmail')) {
      $resetter = service('resetter');
      $sent = $resetter->send($user);
//      $sent = sendResetEmail($user); // TODO uncomment for PROD
      if (!$sent) {
        return redirect()->back()->withInput()->with('error', $resetter->error() ?? lang('Auth.exception.unknown_error'));
      }
    }

    //
    // Success! Go back to user list
    //
    logEvent(
      [
        'type' => $this->logType,
        'event' => lang('Auth.user.create_success', [ $user->username, $user->email ]),
        'user' => user_username(),
        'ip' => $this->request->getIPAddress(),
      ]
    );
    return redirect()->route('users')->with('success', lang('Auth.user.create_success', [ $user->username, $user->email ]));
  }

  /**
   * --------------------------------------------------------------------------
   * Users Edit.
   * --------------------------------------------------------------------------
   *
   * Displays the user edit page.
   *
   * @param int $id User ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function usersEdit($id = null): \CodeIgniter\HTTP\RedirectResponse|string {
    $users = model(UserModel::class);

    if (!$user = $users->where('id', $id)->first()) {
      return redirect()->to('users');
    }

    $groups = $this->authorize->groups();
    $permissions = $this->authorize->permissions();
    $roles = $this->authorize->roles();

    $userGroups = $this->authorize->userGroups($id);
    $userAllPermissions = $user->getPermissions();
    $userPersonalPermissions = $user->getPersonalPermissions();
    $userRoles = $this->authorize->userRoles($id);

    return $this->_render($this->authConfig->views['usersEdit'], [
      'auth' => $this->authorize,
      'config' => $this->authConfig,
      'user' => $user,
      'groups' => $groups,
      'permissions' => $permissions,
      'roles' => $roles,
      'userGroups' => $userGroups,
      'userAllPermissions' => $userAllPermissions,
      'userPersonalPermissions' => $userPersonalPermissions,
      'userRoles' => $userRoles,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Users Edit Do.
   * --------------------------------------------------------------------------
   *
   * Attempt to create a new user.
   * To be be used by administrators. User will be activated automatically.
   *
   * @param int $id User ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function usersEditDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $users = model(UserModel::class);

    //
    // Get the user to edit. If not found, return to users list page.
    //
    if (!$user = $users->where('id', $id)->first()) {
      return redirect()->to('users');
    }

    //
    // Validate basics first since some password rules rely on these fields
    //
    $rules = [
      'email' => 'required|valid_email|is_unique[users.email]',
      'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
      'firstname' => 'max_length[80]',
      'lastname' => 'max_length[80]',
      'displayname' => 'max_length[80]',
    ];

    //
    // Don't validate uniqueness on email and username if the post will not change them.
    //
    $emailChange = true;
    if ($this->request->getPost('email') == $user->email) {
      $rules['email'] = 'required|valid_email';
      $emailChange = false;
    }

    $usernameChange = true;
    if ($this->request->getPost('username') == $user->username) {
      $rules['username'] = 'required|alpha_numeric_space|min_length[3]|max_length[30]';
      $usernameChange = false;
    }

    $lastnameChange = true;
    if ($this->request->getPost('lastname') == $user->lastname) {
      $lastnameChange = false;
    }

    $firstnameChange = true;
    if ($this->request->getPost('firstname') == $user->firstname) {
      $firstnameChange = false;
    }

    $displaynameChange = true;
    if ($this->request->getPost('displayname') == $user->displayname) {
      $displaynameChange = false;
    }

    //
    // Let's check whether there is any changed value at all.
    //
    if (
      $emailChange ||
      $usernameChange ||
      $lastnameChange ||
      $firstnameChange ||
      $displaynameChange ||
      $this->request->getPost('password')
    ) {
      //
      // Validate input so far
      //
      if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
      }

      $user->setAttribute('firstname', $this->request->getPost('firstname'));
      $user->setAttribute('lastname', $this->request->getPost('lastname'));
      $user->setAttribute('displayname', $this->request->getPost('displayname'));

      if ($emailChange) {
        $user->setAttribute('email', $this->request->getPost('email'));
      }
      if ($usernameChange) {
        $user->setAttribute('username', $this->request->getPost('username'));
      }

      if ($this->request->getPost('password')) {
        //
        // Password change detected. Add it to the post fields and set it.
        //
        $rules = [
          'password' => 'required|strong_password',
          'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
          return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

//        $allowedPostFields = array_merge([ 'password' ], $this->authConfig->validFields, $this->authConfig->personalFields)
        $user->setPassword($this->request->getPost('password'));
//      } else {
        //
        // Do not add Password to the post fields
        //
//        $allowedPostFields = array_merge($this->authConfig->validFields, $this->authConfig->personalFields);
      }

      //
      // Go back if update fails
      //
      if (!$users->update($id, $user)) {
        return redirect()->back()->withInput()->with('errors', $users->errors());
      }
    }

    //
    // Get the Active switch.
    //
    if ($this->request->getPost('active')) {
      $user->setAttribute('active', 1);
    } else {
      $user->setAttribute('active', 0);
    }

    //
    // Get the Banned switch.
    //
    if ($this->request->getPost('banned')) {
      $user->setAttribute('status', 'banned');
    } else {
      $user->setAttribute('status', null);
    }

    //
    // Get the Hidden switch.
    //
    if ($this->request->getPost('hidden')) {
      $user->setAttribute('hidden', 1);
    } else {
      $user->setAttribute('hidden', null);
    }

    //
    // Make sure that user with ID 1 (admin) is never deactivated or banned.
    // Disable this if statement if you want that to be allowed.
    //
    if ($id == 1) {
      $user->setAttribute('active', 1);
      $user->setAttribute('status', null);
    }

    $users->update($id, $user);

    //
    // Handle the Groups tab
    //
    if (array_key_exists('sel_groups', $this->request->getPost())) {
      //
      // Delete all existing groups for this user first. Then add the posted ones.
      //
      $this->authorize->removeUserFromAllGroups((int)$id);

      foreach ($this->request->getPost('sel_groups') as $group) {

        $this->authorize->addUserToGroup($id, $group);
      }
    }

    //
    // Handle the Permissions tab
    //
    if (array_key_exists('sel_permissions', $this->request->getPost())) {
      //
      // Delete all existing permissions for this user first. Then add the posted ones.
      //
      $this->authorize->removeAllPermissionsFromUser((int)$id);
      foreach ($this->request->getPost('sel_permissions') as $perm) {
        $this->authorize->addPermissionToUser($perm, $id);
      }
    }

    //
    // Handle the Roles tab
    //
    if (array_key_exists('sel_roles', $this->request->getPost())) {
      //
      // Delete all existing groups for this user first. Then add the posted ones.
      //
      $this->authorize->removeUserFromAllRoles((int)$id);

      foreach ($this->request->getPost('sel_roles') as $role) {

        $this->authorize->addUserToRole($id, $role);
      }
    }

    //
    // Success! Go back to user list
    //
    logEvent(
      [
        'type' => $this->logType,
        'event' => lang('Auth.user.update_success', [ $user->username, $user->email ]),
        'user' => user_username(),
        'ip' => $this->request->getIPAddress(),
      ]
    );
    return redirect()->back()->withInput()->with('success', lang('Auth.user.update_success', [ $user->username, $user->email ]));
  }

  /**
   * --------------------------------------------------------------------------
   * Profile Edit.
   * --------------------------------------------------------------------------
   *
   * Displays the profile edit page.
   *
   * @param int $id User ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse | string
   */
  public function profileEdit($id = null): \CodeIgniter\HTTP\RedirectResponse|string {
    $users = model(UserModel::class);
    $userOptions = model(UserOptionModel::class);

    if ((int)$id !== user_id() && !has_permission('user.edit')) {
      //
      // Someone's trying to edit someone else profile without permission.
      //
      $redirectURL = '/error_auth';
      unset($_SESSION['redirect_url']);
      return redirect()->to($redirectURL)->with('error', lang('Auth.exception.insufficient_permissions'));
    }

    //
    // Read user record and user option records
    //
    if (!$user = $users->where('id', $id)->first()) {
      return redirect()->back()->with('errors', lang('Auth.user.not_found', [ $id ]));
    }
    $profile = $userOptions->getOptionsForUser($id);

    //
    // Set defaults
    //
    if (!array_key_exists('theme', $profile)) {
      $profile['theme'] = 'light';
    }
    if (!array_key_exists('menu', $profile)) {
      $profile['menu'] = 'navbar';
    }
    if (!array_key_exists('region', $profile)) {
      $profile['region'] = '1';
    }
    if (!array_key_exists('avatar', $profile)) {
      $profile['avatar'] = 'default_male.png';
    }

    //
    // Get languages
    //
    $supportedLanguages = config('App')->supportedLocales;
    $languageOptions = [];
    $languageOptions[] = [ 'title' => lang('App.locales.default'), 'value' => 'default', 'selected' => (array_key_exists('language', $profile) && $profile['language'] === 'default' ? true : false) ];
    foreach ($supportedLanguages as $lang) {
      $languageOptions[] = [ 'title' => lang('App.locales.' . $lang), 'value' => $lang, 'selected' => (array_key_exists('language', $profile) && $profile['language'] === $lang ? true : false) ];
    }

    //
    // Get avatars
    //
    $avatars = directory_map('./upload/avatars/', 1);
    $avatarUrl = base_url() . 'upload/avatars/';
    $gravatar = new Gravatar();
    $gravatarUrl = $gravatar->get($user->email);
    if ($profile['avatar'] === 'gravatar') {
      $profileAvatar = $gravatarUrl;
    } else {
      $profileAvatar = $profile['avatar'];
    }

    return $this->_render($this->authConfig->views['profilesEdit'], [
      'auth' => $this->authorize,
      'config' => $this->authConfig,
      'user' => $user,
      'profile' => $profile,
      'languageOptions' => $languageOptions,
      'gravatarUrl' => $gravatarUrl ?? '',
      'profileAvatar' => $profileAvatar ?? '',
      'avaUrl' => $avatarUrl,
      'avatars' => $avatars,
    ]);
  }

  /**
   * --------------------------------------------------------------------------
   * Profile Edit Do.
   * --------------------------------------------------------------------------
   *
   * Attempt to edit a profile.
   *
   * @param int $id Group ID
   *
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function profileEditDo($id = null): \CodeIgniter\HTTP\RedirectResponse {
    $users = model(UserModel::class);
    $userOptions = model(UserOptionModel::class);
    $form = array();

    //
    // Get the user for this profile. If not found, return to groups list page.
    //
    if (!$user = $users->where('id', $id)->first()) {
      return redirect()->back()->with('errors', lang('Auth.user.not_found', [ $id ]));
    }

    //
    // Set basic validation rules
    //
    $validationRules = [
      'lastname' => 'max_length[80]',
      'firstname' => 'max_length[80]',
      'organization' => 'max_length[80]',
      'position' => 'max_length[80]',
      'id' => 'max_length[40]',
      'phone' => [
        'label' => lang('Profile.phone'),
        'rules' => 'permit_empty|valid_phone'
      ],
      'mobile' => [
        'label' => lang('Profile.mobile'),
        'rules' => 'permit_empty|valid_phone'
      ]
    ];

    //
    // Get form fields for validation
    //
    $form['avatar'] = $this->request->getPost('opt_avatar');
    $form['facebook'] = $this->request->getPost('facebook');
    $form['id'] = $this->request->getPost('id');
    $form['instagram'] = $this->request->getPost('instagram');
    $form['language'] = $this->request->getPost('language');
    $form['linkedin'] = $this->request->getPost('linkedin');
    $form['mobile'] = $this->request->getPost('mobile');
    $form['organization'] = $this->request->getPost('organization');
    $form['phone'] = $this->request->getPost('phone');
    $form['position'] = $this->request->getPost('position');
    $form['theme'] = $this->request->getPost('theme');
    $form['menu'] = $this->request->getPost('menu');
    $form['xing'] = $this->request->getPost('xing');

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
      // Save Personal
      //
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'organization', 'value' => $form['organization'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'position', 'value' => $form['position'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'id', 'value' => $form['id'] ]);
      //
      // Save Contact
      //
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'phone', 'value' => $form['phone'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'mobile', 'value' => $form['mobile'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'facebook', 'value' => $form['facebook'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'instagram', 'value' => $form['facebook'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'linkedin', 'value' => $form['linkedin'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'xing', 'value' => $form['xing'] ]);
      //
      // Save Options
      //
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'theme', 'value' => $form['theme'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'menu', 'value' => $form['menu'] ]);
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'language', 'value' => $form['language'] ]);
      //
      // Switch language if the user is editing his own profile
      //
      if ($this->session->get('lang') !== $form['language'] && $id === user_id() && in_array($form['language'], config('App')->supportedLocales)) {
        $this->session->set('lang', $form['language']);
      }
      //
      // Save Avatar
      //
      $userOptions->saveOption([ 'user_id' => $id, 'option' => 'avatar', 'value' => $form['avatar'] ]);
      //
      // Remove Secret
      //
      if (array_key_exists('btn_remove_secret',$this->request->getPost())) {
        $users = model(UserModel::class);
        if ($user = $users->where('id', $id)->first()) {
          $user->removeSecret();
          $users->update($id, $user);
        }
      }
      //
      // Success! Go back from where the user came.
      //
      logEvent(
        [
          'type' => $this->logType,
          'event' => lang('Auth.profile.update_success', [ $user->username, $user->email ]),
          'user' => user_username(),
          'ip' => $this->request->getIPAddress(),
        ]
      );
      return redirect()->back()->withInput()->with('success', lang('Auth.profile.update_success', [ $user->username, $user->email ]));
    }
  }
}

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {

  // --------------------------------------------------------------------------
  // Lewe CI4-Auth
  // --------------------------------------------------------------------------
  //
  // If you want to use group, login, permission or role filters in your route
  // definitions, you need to add the filter aliases to your Config/Filters.php file.
  // (see CI4-Auth readme).
  //
  // Sample routes with filters:
  // $routes->match(['get', 'post'], 'roles', 'RoleController::index', ['filter' => 'group:Disney']);
  // $routes->match(['get', 'post'], 'roles', 'RoleController::index', ['filter' => 'login']);
  // $routes->match(['get', 'post'], 'roles', 'RoleController::index', ['filter' => ['permission:role.view', 'permission:role.edit']]); // Must have both permissions
  // $routes->match(['get', 'post'], 'roles', 'RoleController::index', ['filter' => 'role:Administrator']);

  $routes->get('/error_auth', 'AuthController::error');

  // Authentication
  $routes->get('login', 'AuthController::login', ['as' => 'login']);
  $routes->post('login', 'AuthController::loginDo');
  $routes->get('logout', 'AuthController::logout');
  $routes->get('register', 'AuthController::register', ['as' => 'register']);
  $routes->post('register', 'AuthController::registerDo');
  $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
  $routes->get('resend-activate-account', 'AuthController::activateAccountResend', ['as' => 'resend-activate-account']);
  $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
  $routes->post('forgot', 'AuthController::forgotPasswordDo');
  $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
  $routes->post('reset-password', 'AuthController::resetPasswordDo');
  $routes->get('setup2fa', 'AuthController::setup2fa', ['as' => 'setup2fa']);
  $routes->post('setup2fa', 'AuthController::setup2faDo');
  $routes->get('login2fa', 'AuthController::login2fa', ['as' => 'login2fa']);
  $routes->post('login2fa', 'AuthController::login2faDo');
  $routes->get('whoami', 'AuthController::whoami', ['filter' => 'login']);

  // Groups
  $routes->match(['get', 'post'], 'groups', 'GroupController::groups', ['as' => 'groups', 'filter' => 'permission:group.view']);
  $routes->get('groups/create', 'GroupController::groupsCreate', ['as' => 'groupsCreate', 'filter' => 'permission:group.create']);
  $routes->post('groups/create', 'GroupController::groupsCreateDo', ['filter' => 'permission:group.create']);
  $routes->get('groups/edit/(:num)', 'GroupController::groupsEdit/$1', ['as' => 'groupsEdit', 'filter' => 'permission:group.edit']);
  $routes->post('groups/edit/(:num)', 'GroupController::groupsEditDo/$1', ['filter' => 'permission:group.edit']);

  // Permissions
  $routes->match(['get', 'post'], 'permissions', 'PermissionController::permissions', ['as' => 'permissions', 'filter' => 'permission:permission.view']);
  $routes->get('permissions/create', 'PermissionController::permissionsCreate', ['as' => 'permissionsCreate', 'filter' => 'permission:permission.create']);
  $routes->post('permissions/create', 'PermissionController::permissionsCreateDo', ['filter' => 'permission:permission.create']);
  $routes->get('permissions/edit/(:num)', 'PermissionController::permissionsEdit/$1', ['as' => 'permissionsEdit', 'filter' => 'permission:permission.edit']);
  $routes->post('permissions/edit/(:num)', 'PermissionController::permissionsEditDo/$1', ['filter' => 'permission:permission.edit']);

  // Roles
  $routes->match(['get', 'post'], 'roles', 'RoleController::roles', ['as' => 'roles', 'filter' => 'permission:role.view']);
  $routes->get('roles/create', 'RoleController::rolesCreate', ['as' => 'rolesCreate', 'filter' => 'permission:role.create']);
  $routes->post('roles/create', 'RoleController::rolesCreateDo', ['filter' => 'permission:role.create']);
  $routes->get('roles/edit/(:num)', 'RoleController::rolesEdit/$1', ['as' => 'rolesEdit', 'filter' => 'permission:role.edit']);
  $routes->post('roles/edit/(:num)', 'RoleController::rolesEditDo/$1', ['filter' => 'permission:role.edit']);

  // Users
  $routes->match(['get', 'post'], 'users', 'UserController::users', ['as' => 'users', 'filter' => 'permission:user.view']);
  $routes->get('users/create', 'UserController::usersCreate', ['as' => 'usersCreate', 'filter' => 'permission:user.create']);
  $routes->post('users/create', 'UserController::usersCreateDo', ['filter' => 'permission:user.create']);
  $routes->get('users/edit/(:num)', 'UserController::usersEdit/$1', ['as' => 'usersEdit', 'filter' => 'permission:user.edit']);
  $routes->post('users/edit/(:num)', 'UserController::usersEditDo/$1', ['filter' => 'permission:user.edit']);
  $routes->get('users/profile/(:num)', 'UserController::profileEdit/$1', ['as' => 'profileEdit', 'filter' => 'login']);
  $routes->post('users/profile/(:num)', 'UserController::profileEditDo/$1', ['filter' => 'login']);

  // --------------------------------------------------------------------------
  // Lewe CI4-Lic
  // --------------------------------------------------------------------------
  //
  $routes->match(['get', 'post'], 'license', 'LicController::index', ['as' => 'license']);

  // --------------------------------------------------------------------------
  // System Routes
  // --------------------------------------------------------------------------
  //
  // Database
  $routes->match(['get', 'post'], 'database', 'DatabaseController::database', ['as' => 'database', 'filter' => 'permission:database.edit']);

  // Log
  $routes->match(['get', 'post'], 'log', 'LogController::log', ['as' => 'log', 'filter' => 'permission:log.view']);

  // PHPInfo
  $routes->match(['get', 'post'], 'phpinformation', 'PhpInformationController::phpinfo', ['as' => 'phpinformation', 'filter' => 'permission:application.manage']);

  // Settings
  $routes->get('settings', 'SettingsController::edit', ['as' => 'settingsEdit', 'filter' => 'permission:application.manage']);
  $routes->post('settings', 'SettingsController::editDo', ['filter' => 'permission:application.manage']);

  // --------------------------------------------------------------------------
  // Application Routes
  // --------------------------------------------------------------------------
  //
  // Options
  $routes->get('options', 'OptionsController::edit', ['as' => 'optionsEdit', 'filter' => 'permission:options.manage']);
  $routes->post('options', 'OptionsController::editDo', ['filter' => 'permission:options.manage']);

  // Labels
  $routes->match(['get', 'post'], 'labels', 'LabelController::list', ['as' => 'labels', 'filter' => 'permission:label.view']);
  $routes->get('labels/create', 'LabelController::create', ['as' => 'labelCreate', 'filter' => 'permission:label.create']);
  $routes->post('labels/create', 'LabelController::createDo', ['filter' => 'permission:label.create']);
  $routes->get('labels/edit/(:num)', 'LabelController::edit/$1', ['as' => 'labelEdit', 'filter' => 'permission:label.edit']);
  $routes->post('labels/edit/(:num)', 'LabelController::editDo/$1', ['filter' => 'permission:label.edit']);

  // Priorities
  $routes->match(['get', 'post'], 'priorities', 'PriorityController::list', ['as' => 'priorities', 'filter' => 'permission:priority.view']);
  $routes->get('priorities/create', 'PriorityController::create', ['as' => 'priorityCreate', 'filter' => 'permission:priority.create']);
  $routes->post('priorities/create', 'PriorityController::createDo', ['filter' => 'permission:priority.create']);
  $routes->get('priorities/edit/(:num)', 'PriorityController::edit/$1', ['as' => 'priorityEdit', 'filter' => 'permission:priority.edit']);
  $routes->post('priorities/edit/(:num)', 'PriorityController::editDo/$1', ['filter' => 'permission:priority.edit']);

  // Products
  $routes->match(['get', 'post'], 'products', 'ProductController::list', ['as' => 'products', 'filter' => 'permission:product.view']);
  $routes->get('products/create', 'ProductController::create', ['as' => 'productCreate', 'filter' => 'permission:product.create']);
  $routes->post('products/create', 'ProductController::createDo', ['filter' => 'permission:product.create']);
  $routes->get('products/edit/(:num)', 'ProductController::edit/$1', ['as' => 'productEdit', 'filter' => 'permission:product.edit']);
  $routes->post('products/edit/(:num)', 'ProductController::editDo/$1', ['filter' => 'permission:product.edit']);

  // Status Categories
  $routes->match(['get', 'post'], 'statuscategories', 'StatusCategoryController::list', ['as' => 'statuscategories', 'filter' => 'permission:statuscategory.view']);
  $routes->get('statuscategories/create', 'StatusCategoryController::create', ['as' => 'statuscategoryCreate', 'filter' => 'permission:statuscategory.create']);
  $routes->post('statuscategories/create', 'StatusCategoryController::createDo', ['filter' => 'permission:statuscategory.create']);
  $routes->get('statuscategories/edit/(:num)', 'StatusCategoryController::edit/$1', ['as' => 'statuscategoryEdit', 'filter' => 'permission:statuscategory.edit']);
  $routes->post('statuscategories/edit/(:num)', 'StatusCategoryController::editDo/$1', ['filter' => 'permission:statuscategory.edit']);

  // --------------------------------------------------------------------------
  // Public Routes
  // --------------------------------------------------------------------------
  //
  $routes->get('_template', '_TemplateController::index');
  $routes->get('/', 'HomeController::index');
  $routes->get('home', 'HomeController::index');
  $routes->get('/about', 'HomeController::about');
  $routes->get('dataprivacy', 'HomeController::dataprivacy');
  $routes->get('imprint', 'HomeController::imprint');
  $routes->get('lang/{locale}', 'LanguageController::index');
  $routes->get('sample/view', 'HomeController::sample/view');
  $routes->get('sample/edit', 'HomeController::sample/edit', ['filter' => 'license:active']);
  $routes->get('undermaintenance', 'HomeController::undermaintenance');
});

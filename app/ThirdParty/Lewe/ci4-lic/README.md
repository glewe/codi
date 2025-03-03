# CI4-Lic
[![PHP](https://img.shields.io/badge/Language-PHP-8892BF.svg)](https://www.php.net/)
[![Bootstrap 5](https://img.shields.io/badge/Styles-Bootstrap%205-7952b3.svg)](https://www.getbootstrap.com/)
[![Font Awesome](https://img.shields.io/badge/Icons-Font%20Awesome%205-1e7cd6.svg)](https://www.fontawesome.com/)
[![Maintained](https://img.shields.io/badge/Maintained-yes-009900.svg)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity)

CI4-Lic is a software license manager modul for Codeigniter 4, connecting to WordPress license server based on [Software License Manager Plugin](https://wordpress.org/plugins/software-license-manager/).

## Requirements

- PHP 8.0+
- CodeIgniter 4.4+

## Features

- activate/deactivate a license key
- register/deregister a domain for a license key
- display license information

## Installation

### Install Software License Manager on your WordPress site

- Install WordPress on your license server
- Install the Software License Manager Plugin on that server
- Configure the plugin, e.g. setting the secret key for validation

### Install Codeigniter

Install an appstarter project with Codigniter 4 as described [here](https://codeigniter.com/user_guide/installation/installing_composer.html).

Make sure your app and database is configured right and runs fine showing the Codigniter 4 welcome page.

### Download CI4-Lic

Download the CI4-Lic archive from this repo here.

### Copy CI4-Lic to your ThirdParty folder

*Note: CI4-Lic is not available as a Composer package yet. It works from your ThirdParty folder.*

Unzip the CI4-Lic archive and copy the 'Lewe' directory to your **\app\ThirdParty** folder in your Codeigniter project.
You should see this tree section then:
```
project-root
- app
  - ThirdParty
    - lewe
      - ci4-lic
        - src
```
### Configuration

1. Add the Psr4 path in your **app/Config/Autoload.php** file as follows:
```php
public $psr4 = [
    APP_NAMESPACE  => APPPATH, // For custom app namespace
    'Config'       => APPPATH . 'Config',
    'CI4\Lic'      => APPPATH . 'ThirdParty/lewe/ci4-lic/src',
];
```

2. For easier access the the helper functions, add the helper names 'lic' and 'bs5' to your **app/Controller/BaseCopntroller.php**. It might look like this (do not reomve existing helper entries):
```php
    protected $helpers = ['auth', 'bs5', 'lic', 'session'];
];
```
### Routes

The CI4-Lic routes are defined in **lewe/ci4-lic/src/Config/Routes.php**. Copy the routes group from there to your
**app/Config/Routes.php** file, right after the 'Route Definitions' header comment.
```php
/*
* --------------------------------------------------------------------
* Route Definitions
* --------------------------------------------------------------------
*/
//
// CI4-Lic Routes
//
$routes->group('', ['namespace' => 'CI4\Lic\Src\Controllers'], function ($routes) {

    // Sample route with role filter
    // $routes->match(['get', 'post'], 'roles', 'RoleController::index', ['filter' => 'role:Administrator']);

    $routes->get('/license', 'LicController::welcome');
    
    ...

});
```

### Views

The views that come with CI4-Lic are based on [Bootstrap 5](http://getbootstrap.com/) and [Font Awesome 5](https://fontawesome.com/).

If you like to use your own view you can override them editing the `$views` array in
**lewe/ci4-lic/src/Config/Auth.php**:
```php
public $views = [

    // Welcome page
    'welcome'            => 'CI4\Auth\Views\welcome',

    // Auth
    'login'              => 'CI4\Auth\Views\auth\login',
    'register'           => 'CI4\Auth\Views\auth\register',
    'forgot'             => 'CI4\Auth\Views\auth\forgot',
    'reset'              => 'CI4\Auth\Views\auth\reset',

    // Groups
    'groups'             => 'CI4\Auth\Views\groups\list',
    'groupsCreate'       => 'CI4\Auth\Views\groups\create',
    'groupsEdit'         => 'CI4\Auth\Views\groups\edit',

    // Permissions
    'permissions'        => 'CI4\Auth\Views\permissions\list',
    'permissionsCreate'  => 'CI4\Auth\Views\permissions\create',
    'permissionsEdit'    => 'CI4\Auth\Views\permissions\edit',

    // Roles
    'roles'              => 'CI4\Auth\Views\roles\list',
    'rolesCreate'        => 'CI4\Auth\Views\roles\create',
    'rolesEdit'          => 'CI4\Auth\Views\roles\edit',

    // Users
    'users'              => 'CI4\Auth\Views\users\list',
    'usersCreate'        => 'CI4\Auth\Views\users\create',
    'usersEdit'          => 'CI4\Auth\Views\users\edit',

    // Emails
    'emailForgot'        => 'CI4\Auth\Views\emails\forgot',
    'emailActivation'    => 'CI4\Auth\Views\emails\activation',
];
```

### Database Migration

Assuming that your database is setup correctly but still empty you need to run the migrations now.

Copy the file **lewe/CI4-Lic/src/Database/Migrations/2021-12-14-000000_create_lic_tables.php** to
**app/Database/Migrations**. Then run the command:

    > php spark migrate

### Database Seeding

Assuming that the migrations have been completed successfully, you can run the seeders now to create the CI4-Lic sample data.

Copy the files **lewe/CI4-Lic/src/Database/Seeds/*.php** to **app/Database/Seeds**.
Then run the following command:

    > php spark db:seed CI4LicSeeder

### Run Application

Start your browser and navigate to your public directory. Use the menu to check out the views that come with
CI4-Lic.

## Services

The Services did not change and are from the Myth-Auth core. See there for their documentation. 

## Helper Functions (Lic)

In addition to the helper functions that come with Myth-Auth, CI4-Lic provides these:

**dnd()**

* Function: Dump'n'Die. Returns a preformatted output of objects and variables.
* Parameters: Variable/Object, Switch to die after output or not
* Returns: Preformatted output

## Helper Functions (Bootstrap 5)

In order to create Bootstrap objects quicker and to avoid duplicating code in views, these helper functions are
provided:

**bs5Alert()**

* Function: Creates a Bootstrap 5 alert box.
* Parameters: Array with alert box details.
* Returns: HTML

**bs5CardHeader()**

* Function: Creates a Bootstrap card header.
* Parameters: Array with card header details.
* Returns: HTML

**bs5FormRow()**

* Function: Creates a two-column form field div (text, email, select, password).
* Parameters: Array with form field details.
* Returns: HTML

**bs5Modal()**

* Function: Creates a modal dialog.
* Parameters: Array with modal dialog details.
* Returns: HTML

**bs5SearchForm()**

* Function: Creates a search form field.
* Parameters: Array with search form details.
* Returns: HTML

## Disclaimer

The CI4-Lic library is not perfect. It may very well contain bugs or things that can be done better. If you stumble upon such things, let me know.
Otherwise I hope the library will help you. Feel free to change anything to meet the requirements in your environment.

Enjoy,
George Lewe

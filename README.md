<img width="80" height="80" style="margin-bottom: 12px;" src="https://github.com/glewe/codi/blob/main/public/images/icons/app-icon-80.png">

# CODI - A PHP application boilerplate based on CodeIgniter 4

[![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4-c9340a.svg)](https://codeigniter.com/)
[![PHP](https://img.shields.io/badge/Language-PHP-8892BF.svg)](https://www.php.net/)

## What is CODI?

**CODI** is a PHP application boilerplate based based on the CodeIgniter 4 framework, enriched by several useful public web application modules. 
It is an "opinionated boilerplate" with Bootstrap 5 visuals offering user, group and role management as well as the integration of Lewe CI4-Auth 
for authentication and authorization and Lewe CI4-Lic for license management. The separate repositories for that latter two will not be further meintained.

## Server Requirements

PHP version 8.1 or higher is required, More requirements can be fond here:

- [CodeIgniter 4 User Guide - Server Requirements](https://codeigniter.com/user_guide/intro/requirements.html)

## Installation ##
1. Clone the repository: `git clone https://github.com/glewe/leaf-ci4.git`
2. Run `composer install`
3. Create a new database
4. Edit the `app/Config/Database.php` file and add your database information
5. Run `php spark migrate`
6. Run `php spark db:seed LeafCi4Seeder`
7. Navigate to your application in a browser, e.g. `http://localhost/leaf-ci4/public`
8. The home page provides login information

## Making Changes ##
Should you make changes to the CSS or JavaScript files, you will need to run the following commands to compile them:

`composer run build`

That will compile the files and overwrite the old ones in the `public/css` and `public/js` directories.

## Features
- User, group and role management
- Authentication and authorization
- 2FA (Two Factor Authentication)
- Permission management
- [Software License Manager](https://wordpress.org/plugins/software-license-manager/) support
- Multi-language support
- Navbar or sidebar menu
- Dark or light theme
- Narrow or wide layout
- Registration with email verification
- Gravatar profile icons

## Modules
- [Lewe CI4-Auth](https://github.com/glewe/ci4-auth)
- [Lewe CI4-Lic](https://github.com/glewe/ci4-lic)
- Bootstrap
- Bootstrap Icons
- Chart.js
- Coloris color picker
- Cookie Consent
- DateTime picker
- Font Awesome
- Freepik and Iconshock avatars
- Highlight.js
- Lightbox2
- ... see the About page for more details and versions

## License
You can use and modify this boilerplate for your own projects. It is licensed under the MIT license. Please keep the original author information in the files and link to this repo in your application's footer..

## Support
Feel free to let me know if you have any questions or suggestions or if you encounter bugs. Open an [issue](https://github.com/glewe/leaf-ci4/issues) here in the repository.

## Enjoy
Have fun with LeAF CI4!

George

<img width="80" height="80" style="margin-bottom: 12px;" src="https://github.com/glewe/codi/blob/main/public/images/icons/app-icon-80.png">

# CODI - Application boilerplate based on CodeIgniter 4

[![CodeIgniter](https://img.shields.io/badge/Framework-CodeIgniter_4-c9340a.svg)](https://codeigniter.com/)
[![Bootstrap](https://img.shields.io/badge/Design-Bootstrap_5-563d7c.svg)](https://getbootstrap.com/)
[![Bootstrap Icons](https://img.shields.io/badge/Design-Bootstrap_Icons-563d7c.svg)](https://icons.getbootstrap.com/)
[![FontAwesome](https://img.shields.io/badge/Design-FontAwesome_6-339af0.svg)](https://fontawesome.com/)

[![PHP](https://img.shields.io/badge/PHP-8.4-8892BF.svg)](https://www.php.net/)
[![JS](https://img.shields.io/badge/JS-ES6-f1e05a.svg)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![HTML](https://img.shields.io/badge/HTML-5-e34c26.svg)](https://developer.mozilla.org/en-US/docs/Web/HTML)
[![CSS](https://img.shields.io/badge/CSS-3-563d7c.svg)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=glewe_codi&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=glewe_codi)

## What is CODI?

**CODI** is a PHP application boilerplate based on the CodeIgniter 4 framework, enriched by several useful public web application modules. 
It is an "_opinionated boilerplate_" with Bootstrap 5 visuals offering user, group and role management as well as the integration of 
Lewe CI4-Auth for authentication and authorization and Lewe CI4-Lic for license management. The separate repositories for that latter 
two will not be further maintained.

## Server Requirements

PHP 8.1 / 8.2 / 8.4 is required.

More requirements can be found here:

- [CodeIgniter 4 User Guide - Server Requirements](https://codeigniter.com/user_guide/intro/requirements.html)

## Installation ##
1. Download the latest release from here: [CODI Releases](https://github.com/glewe/codi/releases)
2. Unzip code to a folder reachable by your local webserver
3. Go to the folder and run `composer install`
4. Create a new database
5. Edit the `app/Config/Database.php` file and add your database information
6. Edit the `app/Config/App.php` file and change `$baseUrl` to your localhost path, e.g. `http://localhost/codi/public`
7. Run `php spark migrate`
8. Run `php spark db:seed CODISeeder`
9. Navigate to your application in a browser, e.g. `http://localhost/codi/public`
10. The home page provides login information

## Making Changes ##
Should you make changes to the CSS or JavaScript files, you will need to run the following commands to compile them:

`composer run build`

That will compile and minimize the files and overwrite the old ones in the `public/css` and `public/js` directories.

## Features
- User, group and role management
- Authentication and authorization
- 2FA (Two-Factor Authentication)
- Permission management
- [Software License Manager](https://wordpress.org/plugins/software-license-manager/) support
- Multi-language support
- Navbar or sidebar menu
- Dark or light theme
- Narrow or wide layout
- Registration with email verification
- Gravatar profile icons

## Modules
- [Lewe CI4-Auth](https://github.com/glewe/ci4-auth) (integrated in CODI since 6.0.0)
- [Lewe CI4-Lic](https://github.com/glewe/ci4-lic) (integrated in CODI since 6.0.0)
- Bootstrap
- Bootstrap Icons
- Chart.js
- Coloris color picker
- Cookie Consent
- DateTime picker
- Font Awesome
- Freepik and Iconshock avatars
- Gravatar Library for CodeIgniter
- Highlight.js
- Lightbox2
- ... see the About page for more details and versions

## License
You can use and modify this boilerplate for your own projects. It is licensed under the MIT license. Please keep the original author 
information in the files and link to this repo in your application's footer.

## Support
Feel free to let me know if you have any questions or suggestions or if you encounter bugs. 
Open an [issue](https://github.com/glewe/codi/issues) here in the repository.

## Enjoy
Have fun with CODI !

George

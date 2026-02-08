# CODI - Development Guide

## Project Overview
**CODI** is a PHP application boilerplate based on the CodeIgniter 4 framework. It provides a robust foundation for building web applications with built-in features such as:
- User, group, and role management
- Authentication and authorization (via Lewe CI4-Auth)
- Two-Factor Authentication (2FA)
- Permission management
- Software License Manager support (via Lewe CI4-Lic)
- Multi-language support (English, German, Spanish, French)
- Responsive design with dark/light theme options

## Technical Stack
- **Backend:** PHP 8.1 - 8.4 (CodeIgniter 4.6)
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 5, Bootstrap Icons, FontAwesome 6, Coloris, Highlight.js, Lightbox2
- **Security:** TOTP 2FA, CSRF Protection, Auth Persistence, Permission Management
- **Visualization:** Chart.js
- **Utilities:** Endroid QR Code, MatthiasMullie Minify

## Project Structure
The application follows the standard CodeIgniter 4 structure:

- **`app/`**: Application source code.
  - **`Config/`**: Framework and application configuration.
  - **`Controllers/`**: Handle HTTP requests and logic (extends `BaseController`).
  - **`Models/`**: Database interactions (Active Record).
  - **`Views/`**: PHP-based templates for UI.
  - **`Helpers/`**: Custom helper functions (e.g., `auth`, `session`).
  - **`Language/`**: Internationalization files (en, de, es, fr).
  - **`Libraries/`**: Custom application libraries (e.g., `Bootstrap`, `Gravatar`).
- **`public/`**: Web root directory.
  - **`css/`**: Stylesheets (original and minified).
  - **`js/`**: JavaScript files (original and minified).
  - **`images/`**: Static image assets.
  - **`upload/`**: Dynamic assets like avatars and attachments.
- **`tests/`**: PHPUnit test suite.
- **`writable/`**: Temporary data, logs, and cache.

## Development Tools & Scripts
Development tasks are managed via **Composer** scripts.

| Command | Description |
| :--- | :--- |
| `composer build` | Lints CSS and executes `minify.php` to compress assets. |
| `composer build:prod` | Prepares for production: builds assets and installs dependencies without dev-tools. |
| `composer test` | Runs the PHPUnit test suite. |
| `php spark` | Access CodeIgniter's CLI tool (migrations, seeding, generators). |
| `php spark migrate` | Runs pending database migrations. |
| `php spark db:seed CODISeeder` | Seeds the database with initial developer data. |

## Development Rules & Standards

### Coding Standards
Refer to **`RULES.md`** for authoritative coding standards.
- **Indentation:** 2 spaces.
- **Strict Types:** `declare(strict_types=1);` is **MANDATORY** for all PHP files.
- **Naming:** `PascalCase` for classes, `camelCase` for methods/properties.
- **DocBlocks:** Required for all classes and methods following the format in `RULES.md`.

### Architecture Guidelines
1. **MVC Pattern:** Adhere to the CodeIgniter 4 MVC implementation. Business logic should be encapsulated in Models or specialized Libraries.
2. **BaseController:** All controllers must extend `App\Controllers\BaseController`. Use `$this->_render()` for view rendering to ensure consistent data availability (theme, menu, user data).
3. **Views:** Use PHP-based view fragments and layouts. Avoid complex business logic in view files.
4. **i18n:** Use the `lang()` function for all UI strings. Ensure all 4 supported languages are updated when adding new strings.
5. **Assets:** Edit `.css` and `.js` files in `public/`. Run `composer build` before committing to update the `.min` versions used in the application.

### Workflow
- **Verify State:** Always check file contents and existing patterns before making edits.
- **Migrations:** Use Spark migrations for any database schema changes.
- **Testing:** Verify changes with existing tests and add new ones for significant features.
- **Static Analysis:** Aim for zero errors at PHPStan level 4.

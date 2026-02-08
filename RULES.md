# Project Rules & Coding Standards

## 1. PHP Standards (PSR-12 Extended)
All PHP code MUST adhere to the PSR-12 specification.

### General
- **Indentation:** Use 2 spaces. No tabs.
- **Line Endings:** Unix LF only.
- **Line Length:** Soft limit of 240 characters; aim for 120.
- **Files:** Must use `<?php` tag and UTF-8 (no BOM). Omit `?>` in pure PHP files.
- **Editor Config:** Use `.editorconfig` file for consistent code style.

### Structure & Declarations
- **Strict Types:** Every file MUST start with `declare(strict_types=1);` after the opening tag.
- **Namespaces:** One blank line after `namespace`. 
- **Imports:** `use` statements must be after the namespace, one per line, and sorted alphabetically.
- **Visibility:** MUST be declared on all properties and methods (`public`, `protected`, `private`).
- **Modifiers:** `abstract` and `final` go before visibility; `static` goes after.

### Braces & Spacing
- **Classes/Methods:** Opening brace `{` on its own line. Closing brace `}` on its own line.
- **Control Structures:** One space after keywords (if, for, while). All control structures have opening and closing braces. Opening brace `{` on the SAME line as the condition.
- **Anonymous Classes:** Follow the same logic as methods.

### Types & Naming
- **Naming:** Classes use `PascalCase`. Methods and properties use `camelCase`.
- **Type Hinting:** Use scalar types (string, int, bool) and return type hints on all methods.
- **Short Form:** Use `bool` instead of `boolean`, `int` instead of `integer`.

### Comments
- **Single Line:** Use `//` for single line comments.
- **Multi Line:** Start with an empty line and end with an empty line starting with `//`. All lines inbetween must start with `//`.

### DocBlocks
- **Single Line:** Use `/** */` for single line comments.
- **Multi Line:** Use `/** */` for multi line comments.
- **Method DocBlock:** Use the following structure for method docblocks:
  ```php
  //---------------------------------------------------------------------------
  /**
   * Summary of what the function does.
   *
   * @param string $paramString Description of parameter
   * @param int    $paramInt    Description of parameter
   * @param bool   $paramBool   Description of parameter
   *
   * @return string Description of return value
   */
  ```
---

## 2. API & Tooling Rules (Bruno)
This project uses the **Bruno** API client for integration testing and scripting.

- **`res.getBody()` Handling:** In this environment, `res.getBody()` is pre-configured to return a **parsed JavaScript object**. 
- **Rule:** Do NOT use `JSON.parse(res.getBody())` unless the response is explicitly a raw string. 
- **Example:**
  ```javascript
  // Correct
  const data = res.getBody();
  const id = data.id;
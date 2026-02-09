<?php

declare(strict_types=1);

/**
 * Script to update product version and release date in app/Config/AppInfo.php
 * based on the version in composer.json.
 */

$composerJsonFile = __DIR__ . '/../composer.json';
$appInfoFile      = __DIR__ . '/../app/Config/AppInfo.php';

if (!file_exists($composerJsonFile)) {
  die("Error: composer.json not found at {$composerJsonFile}\n");
}

if (!file_exists($appInfoFile)) {
  die("Error: app/Config/AppInfo.php not found at {$appInfoFile}\n");
}

// Get version from composer.json
$composerData = json_decode(file_get_contents($composerJsonFile), true);
$version = $composerData['version'] ?? '0.0.0';
$releaseDate = date('Y-m-d');

echo "Updating app/Config/AppInfo.php to version {$version} and release date {$releaseDate}...\n";

// Read AppInfo.php
$content = file_get_contents($appInfoFile);

// Update version
$content = preg_replace(
  '/public string \$version = \'.*?\';/',
  "public string \$version = '{$version}';",
  $content
);

// Update release date
$content = preg_replace(
  '/public string \$releaseDate = \'.*?\';/',
  "public string \$releaseDate = '{$releaseDate}';",
  $content
);

file_put_contents($appInfoFile, $content);

echo "Done.\n";

<?php
declare(strict_types=1);

/**
 * CODI Release Script
 * Automates the git commands to tag and push a release.
 *
 * @author     George Lewe <george@lewe.com>
 * @copyright  Copyright (c) 2014-2026 by George Lewe
 * @link       https://www.lewe.com
 *
 * @package    CODI
 * @subpackage Tools
 * @since      6.3.0
 */

$root = dirname(__DIR__);

// ANSI Color Constants
define('CLR_RED', "\033[0;31m");
define('CLR_GRN', "\033[0;32m");
define('CLR_YLW', "\033[1;33m");
define('CLR_BLU', "\033[0;34m");
define('CLR_CYN', "\033[0;36m");
define('CLR_RST', "\033[0m");

echo CLR_CYN . "\n\n===============================================================================\n" . CLR_RST;
echo CLR_CYN . "CODI Release Automation\n" . CLR_RST;
echo CLR_CYN . "===============================================================================\n\n" . CLR_RST;

// 1. Get version from composer.json
echo CLR_YLW . "1. Reading version from composer.json...\n" . CLR_RST;
$composerPath = $root . '/composer.json';
if (!file_exists($composerPath)) {
  echo CLR_RED . "[ERROR] composer.json not found at $composerPath\n" . CLR_RST;
  exit(1);
}

$composerJson = json_decode(file_get_contents($composerPath), true);
$version      = $composerJson['version'] ?? '';

if (empty($version)) {
  echo CLR_RED . "[ERROR] Could not detect version from composer.json\n" . CLR_RST;
  exit(1);
}

echo "Detected version: " . CLR_GRN . "v$version" . CLR_RST . "\n\n";

// 2. Check if tag exists on remote
echo CLR_YLW . "2. Checking for existing tag on remote...\n" . CLR_RST;
$cmd = "git ls-remote --tags origin v$version";
exec($cmd, $output, $returnVar);

// Check if any line in output matches the tag exactly
$tagExists = false;
foreach ($output as $line) {
  if (strpos($line, "refs/tags/v$version") !== false) {
    $tagExists = true;
    break;
  }
}

// Check for force flag
$force = in_array('--force', $argv);

if ($tagExists) {
  if (!$force) {
    echo CLR_RED . "\n[WARNING] Tag v$version already exists on remote!\n" . CLR_RST;
    echo "Aborting release process to avoid conflicts.\n";
    echo "To overwrite, run: " . CLR_YLW . "composer release:force" . CLR_RST . "\n\n";
    exit(1);
  }
  else {
    echo CLR_YLW . "\n[INFO] Tag v$version exists, but --force was used.\n" . CLR_RST;
    echo "The existing tag will be deleted and recreated.\n\n";
  }
}
else {
  echo CLR_GRN . "Tag v$version is available.\n\n" . CLR_RST;
}

// 3. Confirmation
echo CLR_YLW . "3. Confirmation\n" . CLR_RST;
echo "This script will:\n";
echo "  - git add .\n";
echo "  - git commit -m \"Release v$version\"\n";
echo "  - git push origin main\n";

if ($force && $tagExists) {
  echo CLR_RED . "  - git tag -d v$version (Delete local)\n" . CLR_RST;
  echo CLR_RED . "  - git push origin --delete v$version (Delete remote)\n" . CLR_RST;
}

echo "  - git tag v$version\n";
echo "  - git push origin v$version\n\n";
echo "IMPORTANT: Ensure you have updated app/Views/partials/releaseinfo.phtml!\n\n";
echo "Press Enter to continue, or Ctrl+C to cancel...";

$handle = fopen("php://stdin", "r");
fgets($handle);
fclose($handle);

echo "\n";

/**
 * --------------------------------------------------------------------------
 * Run Step
 * --------------------------------------------------------------------------
 *
 * Helper function to run commands and check exit codes.
 *
 * @param string $description Description of the step.
 * @param string $command     The command to execute.
 *
 * @return void
 */
function runStep(string $description, string $command): void {
  echo CLR_YLW . ">>> $description...\n" . CLR_RST;
  echo CLR_CYN . "$ $command\n" . CLR_RST;
  passthru($command, $returnVar);
  if ($returnVar !== 0) {
    echo CLR_RED . "\n[ERROR] Command failed with exit code $returnVar. Aborting.\n" . CLR_RST;
    exit(1);
  }
  echo "\n";
}

// 4. Execution
$status = shell_exec("git status --porcelain");
if (trim($status ?? '') !== '') {
  runStep("Adding files", "git add .");
  runStep("Committing changes", "git commit -m \"Release v$version\"");
}
else {
  echo CLR_YLW . ">>> No file changes detected. Skipping add/commit.\n" . CLR_RST;
}

runStep("Pushing to main", "git push origin main");

if ($force && $tagExists) {
  runStep("Deleting local tag", "git tag -d v$version");
  runStep("Deleting remote tag", "git push origin --delete v$version");
}

runStep("Creating tag", "git tag v$version");
runStep("Pushing tag", "git push origin v$version");

echo CLR_GRN . "[SUCCESS] Release v$version pushed to GitHub.\n" . CLR_RST;
echo "The GitHub Action should now pick up the tag and build the release.\n\n";

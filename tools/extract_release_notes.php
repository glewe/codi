<?php
declare(strict_types=1);

/**
 * Extract Release Notes from app/Views/partials/releaseinfo.phtml
 * Usage: php tools/extract_release_notes.php <version>
 *
 * @author     George Lewe <george@lewe.com>
 * @copyright  Copyright (c) 2014-2026 by George Lewe
 * @link       https://www.lewe.com
 *
 * @package    CODI
 * @subpackage Tools
 * @since      6.3.0
 */

if ($argc < 2) {
  echo "Usage: php tools/extract_release_notes.php <version>\n";
  exit(1);
}

$version = $argv[1];

// Handle cases where version might come with 'v' prefix
if (strpos($version, 'v') === 0) {
  $version = substr($version, 1);
}

// Load the releases array
// Capture output to prevent HTML trailing part of the file from printing
ob_start();
// Define dummy lang function and variables to prevent errors in the HTML part of releaseinfo.phtml
if (!function_exists('lang')) {
  function lang($key) { return $key; }
}
$LANG     = [];
$oldLevel = error_reporting(0);
include_once dirname(__DIR__) . '/app/Views/partials/releaseinfo.phtml';
error_reporting($oldLevel);
ob_end_clean();

/** @var array $releases */
if (!isset($releases) || !is_array($releases)) {
  echo "Error: \$releases array not found in releaseinfo.phtml\n";
  exit(1);
}

$targetRelease = null;
foreach ($releases as $release) {
  if ($release['version'] === $version) {
    $targetRelease = $release;
    break;
  }
}

if (!$targetRelease) {
  echo "Release note for version $version not found.\n";
  exit(0); // Exit successfully with empty output (optional) or fail. Let's output nothing.
}

// Build Markdown Output
$output = "";

if (!empty($targetRelease['info'])) {
  $output .= $targetRelease['info'] . "\n\n";
}

$sections = [
  'bugfixes'     => '**Bugfixes**',
  'features'     => '**Features**',
  'improvements' => '**Improvements**',
  'removals'     => '**Removals**',
];

foreach ($sections as $key => $header) {
  if (!empty($targetRelease[$key]) && is_array($targetRelease[$key])) {
    $output .= $header . "\n";
    foreach ($targetRelease[$key] as $item) {
      $line = "- " . $item['summary'];
      if (!empty($item['issue'])) {
        $line .= " ([Issue](" . $item['issue'] . "))";
      }
      $output .= $line . "\n";
    }
    $output .= "\n";
  }
}

echo trim($output);

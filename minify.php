<?php
include 'vendor/autoload.php';
use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

/**
 * Open console output
 */
ob_start();

/**
 * Minify CSS
 */
echo "\n-------------------------------------------------------------------------------\nMinifying CSS files...\n-------------------------------------------------------------------------------\n";
$styleSheets = [
  'public/css/lewe.css',
  'public/css/styles.css',
  'public/css/custom.css'
];
foreach ($styleSheets as $styleSheet) {
  $minifier = new CSS();
  $minifier->add($styleSheet);
  $minifier->minify(str_replace('.css', '.min.css', $styleSheet));
  echo "Minified '$styleSheet' => '" . str_replace('.css', '.min.css', $styleSheet) . "'.\n";
}

/**
 * Minify JS
 */
echo "\n-------------------------------------------------------------------------------\nMinifying JS files...\n-------------------------------------------------------------------------------\n";
$scripts = [
  'public/js/color-modes.js',
  'public/js/width-modes.js',
  'public/js/script.js',
  'public/js/custom.js'
];
foreach ($scripts as $script) {
  $minifier = new JS();
  $minifier->add($script);
  $minifier->minify(str_replace('.js', '.min.js', $script));
  echo "Minified '$script' => '" . str_replace('.js', '.min.js', $script) . "'.\n";
}

/**
 * Close console output
 */
ob_end_flush();

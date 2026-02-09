<?php
$cssFile = dirname(__DIR__) . '/php_doc/css/template.css';
$darkCss = __DIR__ . '/phpdoc_dark_mode.css';

if (file_exists($cssFile) && file_exists($darkCss)) {
  $currentContent = file_get_contents($cssFile);
  $darkContent    = file_get_contents($darkCss);

  // Check if already appended to avoid duplication
  if (strpos($currentContent, '/* Custom dark mode CSS overrides */') === false) {
    file_put_contents($cssFile, "\n\n/* Custom dark mode CSS overrides */\n" . $darkContent, FILE_APPEND);
    echo "Dark mode CSS applied successfully.\n";
  }
  else {
    echo "Dark mode CSS already present.\n";
  }
}
else {
  echo "Error: Target or Source CSS file not found.\n";
  echo "Target: $cssFile\n";
  echo "Source: $darkCss\n";
  exit(1);
}

<?php



// Locate system/Test/bootstrap.php
$systemPath = __DIR__ . '/vendor/codeigniter4/framework/system';
if (! is_dir($systemPath)) {
    // Fallback if structure is different
    $systemPath = __DIR__ . '/vendor/codeigniter4/codeigniter4/system';
}

require $systemPath . '/Test/bootstrap.php';

// Helper loading - these are common helpers used in views/controllers
helper(['url', 'form', 'text', 'html', 'date', 'number', 'filesystem', 'file', 'security', 'cookie']);

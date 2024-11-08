<?php

//
// Lewe CI4-Lic Routes
//
$routes->group('', [ 'namespace' => 'CI4\Lic\Controllers' ], function ($routes) {
  $routes->match([ 'get', 'post' ], 'license', 'LicController::index', [ 'as' => 'license' ]);
});

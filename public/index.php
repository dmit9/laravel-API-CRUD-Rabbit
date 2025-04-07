<?php

use Illuminate\Http\Request;
<<<<<<< HEAD
//echo ('111111111111111111');
=======

>>>>>>> 32571635c3cf78df90e016052fa98bb7d2cef48a
define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}
<<<<<<< HEAD
///echo ('222222222222');
// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';
//echo ('33333333333333');
=======

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

>>>>>>> 32571635c3cf78df90e016052fa98bb7d2cef48a
// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());

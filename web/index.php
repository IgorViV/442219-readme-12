<?php
/**
 * This file - Entry point to site Readme
 */

use Readme\app\services\Router;

require_once '../app/services/helpers.php';
require_once '../app/services/data.php';

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'nouser-layout');

date_default_timezone_set("Europe/Moscow");

spl_autoload_register(function ($class)
{
    $class = str_replace('\\', '/', str_replace('Readme\\', '', $class));
    $file = ROOT . "/{$class}.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// Default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

$query = trim($_SERVER['REQUEST_URI'], '/');

Router::dispatch($query);

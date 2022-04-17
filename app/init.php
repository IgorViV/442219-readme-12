<?php
require_once './helpers.php';

use app\exceptions\ExceptionDbConnect;

date_default_timezone_set("Europe/Moscow");
$is_auth = rand(0, 1);
$user_name = 'Igor';
$error = null;
$popular_posts = '';

$db = require_once './config/config.php';

try {
    $connect = new mysqli($db['host'], $db['user'], $db['password'], $db['database']);
} catch(ExceptionDbConnect $e) {
    $error = 'Ошибка подключения к БД: ' . $e->getMessage();
    $page_content = include_template('views/error.php', [
        'error' => $error,
    ]);
    $layout_content = include_template('layouts/layout.php', [
        'content' => $page_content,
        'title_page' => 'readme: популярное',
        'is_auth' => $is_auth,
        'user_name' => $user_name,
    ]);
    print($layout_content);
    exit;
}

$connect->set_charset("utf8");

spl_autoload_register('autoloader');

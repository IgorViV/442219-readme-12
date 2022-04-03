<?php
declare(strict_types=1);

use app\Db;

require_once 'config/general.php';
require_once 'helpers.php';
require_once 'data.php';

$is_auth = rand(0, 1);
$user_name = 'Igor';
$error = null;
$popular_posts = '';

function autoloader($class)
{
    $class = str_replace("\\", '/', $class);
    $file = __DIR__ . "/{$class}.php";

    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('autoloader');

$db = require_once 'config/db-config.php';
$sql_types = 'SELECT title, alias FROM types';
$sql_posts = 'SELECT posts.created_at, COUNT(likes.id) like_count, posts.title, '
    . 'posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, '
    . 'posts.view_counter, users.avatar_url, '
    . 'user_name AS author, types.title AS type_content, types.alias AS type_alias '
    . 'FROM posts '
    . 'JOIN  users ON posts.user_id = users.id '
    . 'JOIN types ON posts.type_id = types.id '
    . 'JOIN likes ON posts.id = likes.post_id '
    . 'GROUP BY posts.id ORDER BY COUNT(likes.id) DESC  ;';

try {
    $newDb = new Db($db['host'], $db['user'], $db['password'], $db['database']);
} catch(Exception $e) {
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
    die;
}

$types = $newDb->executeQuery($sql_types);
$posts = $newDb->executeQuery($sql_posts);

foreach($posts as $post) {
    $post['diff_time'] = get_diff_time_public_post($post['created_at']);
    $popular_posts .= include_template('views/post-popular.php', [
        'post' => $post,
    ]);
}

$page_content = include_template('views/main-popular.php', [
    'popular_posts' => $popular_posts,
    'types' => $types,
]);

$layout_content = include_template('layouts/layout.php', [
    'content' => $page_content,
    'title_page' => 'readme: популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);

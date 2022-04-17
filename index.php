<?php
declare(strict_types=1);

use app\Db;
use app\models\Model;
use app\models\Post;
use app\models\Type;

require_once 'helpers.php';
require_once 'data.php';
require_once 'app/init.php';
require_once 'app/models/Post.php';
require_once 'app/models/Type.php';

/**
 *
 */
$type = new Type($connect);
$post = new Post($connect);

$types = $type->findFields(['title', 'alias']);

$posts = $post->getPopularPosts();

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

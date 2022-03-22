<?php
declare(strict_types=1);

require_once('config.php');
require_once('helpers.php');
require_once('data.php');

$is_auth = rand(0, 1);

$user_name = 'Igor';

$popular_posts = '';

foreach($posts as $post) {
    $post['date'] = generate_random_date(key($post));
    $post['diff_time'] = get_diff_time_public_post($post['date']);
    $popular_posts .= include_template('views/post-popular.php', [
        'post' => $post,
    ]);
}

$page_content = include_template('views/main-popular.php', [
    'popular_posts' => $popular_posts,
]);

$layout_content = include_template('layouts/layout.php', [
    'content' => $page_content,
    'title_page' => 'readme: популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);

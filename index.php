<?php
require_once('helpers.php');

$is_auth = rand(0, 1);

$user_name = 'Igor'; 
				
$posts = [
    [
        'title' => 'Цитата',
        'type' => 'quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ],				
    [
        'title' => 'Игра престолов',
        'type' => 'text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ], 				
    [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'photo',
        'content' => 'rock-medium.jpg',
        'name' => 'Виктор',
        'avatar' => 'userpic-mark.jpg',
    ], 				
    [
        'title' => 'Моя мечта',
        'type' => 'photo',
        'content' => 'coast-medium.jpg',
        'name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg',
    ], 				
    [
        'title' => 'Лучшие курсы',
        'type' => 'link',
        'content' => 'www.htmlacademy.ru',
        'name' => 'Владик',
        'avatar' => 'userpic.jpg',
    ],
];

$page_content = include_template('main.php', [
    'posts' => $posts,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content, 
    'title_page' => 'readme: популярное',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);
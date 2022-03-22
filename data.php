<?php
/**
 * Main data content
 */

define('MINUTE', 60);
define('HOUR', 60);
define('DAY', 24 * HOUR);
define('WEEK', 7 * DAY);
define('MONTH', 5 * WEEK);
define('DATE_TITLE', 'd.m.Y H:i');
define('MAX_LENGTH_TEXT', 300);
define('MAX_POSTS', 10);

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

<?php
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

/**
 * Truncates the text to the specified number of characters
 *
 * @param string $text Input text
 * @param int $length Maximum number of characters
 *
 * @return string Output text 
 */
function cut_text($text, $length = 300) {

    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }

    $words = explode(' ', $text);
    $output_string = '';

    foreach ($words as $word) {
        $output_string .= $word;

        if (mb_strlen($output_string, 'UTF-8') > $length) {
            break;
        } else {
            $output_string .= ' ';
        }
    };

    return $output_string . '...';
}
?>
<?php require('templates/layout.php'); ?>
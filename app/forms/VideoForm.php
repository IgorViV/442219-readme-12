<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of VideoForm
 */
class VideoForm extends Form
{
    // protected $fields = [
    //     'heading',
    //     'video-url',
    //     'tags',
    // ];

    protected array $fields_db = [
        'title' => 'heading',
        'video_url' => 'video-url',
    ];

    protected array $rules = [
        'heading' => ['required'],
        'video-url' => ['video'], // required, url
        'tags' => ['tags'],
    ];

    protected array $labels = [
        'heading' => 'Заголовок',
        'video-url' => 'Ссылка youtube',
        'tags' => 'Теги',
    ];

    /**
     * Validate video
     *
     * @var string Field name
     */
    protected function runVideoValidator(string $field_name)
    {
        // TODO Implementation method()
        // === Валидация записи типа «Видео»:
        // При заполнении формы пользователь обязательно указывает ссылку на видео,
        // размещённое на сайте YouTube.
        // Сперва следует проверить правильность формата. Значение поля должно быть корректным URL-адресом.
        // Используйте встроенную функцию filter_var и фильтр FILTER_VALIDATE_URL.
        // Затем происходит проверка существования видео по указанной ссылке на платформе YouTube.
        // Эту проверку можно провести с помощью функции check_youtube_url, которая лежит
        // в папке с проектом в сценарии helpers.php.
        if (!$this->runRequiredValidator($field_name)) {
            return false;
        }

        if (!$this->runUrlValidator($field_name)) {
            return false;
        }

        $id = $this->extractYoutubeId(filter_input(INPUT_POST, $field_name, FILTER_SANITIZE_SPECIAL_CHARS));

        set_error_handler(function () {}, E_WARNING);
        $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v=' . $id);
        restore_error_handler();

        if (!is_array($headers)) {
            $this->errors[$field_name][] = 'Видео по такой ссылке не найдено. Проверьте ссылку на видео';

            return false;
        }

        $err_flag = strpos($headers[0], '200') ? 200 : 404;

        if ($err_flag !== 200) {
            $this->errors[$field_name][] = 'Видео по такой ссылке не найдено. Проверьте ссылку на видео';

            return false;
        }

        return true;
    }

    /**
     * Извлекает из ссылки на youtube видео его уникальный ID
     *
     * @param string $youtube_url Ссылка на youtube видео
     * @return array
     */
    protected function extractYoutubeId($youtube_url)
    {
        $id = false;

        $parts = parse_url($youtube_url);

        if ($parts) {
            if (($parts['path'] ?? '') === '/watch') {
                parse_str($parts['query'], $vars);
                $id = $vars['v'] ?? null;
            } else {
                if (($parts['host'] ?? '') === 'youtu.be') {
                    $id = substr($parts['path'], 1);
                }
            }
        }

        return $id;
    }
}

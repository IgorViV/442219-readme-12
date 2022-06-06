<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of VideoForm
 */
class VideoForm extends Form
{
    protected $rules = [
        'heading' => ['required'],
        'video-url' => ['required', 'url', 'video'],
        'tags' => ['tags'],
    ];

    protected $labels = [
        'heading' => 'Заголовок',
        'video-url' => 'Ссылка youtube',
        'tags' => 'Теги',
    ];
}

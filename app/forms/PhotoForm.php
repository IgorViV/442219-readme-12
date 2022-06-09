<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of PhotoForm
 */
class PhotoForm extends Form
{
    protected $fields = [
        'heading',
        'photo-url',
        'tags',
        'file',
    ];

    protected $rules = [
        'heading' => ['required'],
        'photo-url' => ['url'],
        'tags' => ['tags'],
        'file' => ['img'],
    ];

    protected $labels = [
        'heading' => 'Заголовок',
        'photo-url' => 'Ссылка из интернета',
        'tags' => 'Теги',
        'file' => 'Фото'
    ];
}

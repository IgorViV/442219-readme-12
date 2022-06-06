<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of TextForm
 */
class TextForm extends Form
{
    protected $rules = [
        'heading' => ['required'],
        'text' => ['required'],
        'tags' => ['tags'],
    ];

    protected $labels = [
        'heading' => 'Заголовок',
        'text' => 'Текст поста',
        'tags' => 'Теги',
    ];
}

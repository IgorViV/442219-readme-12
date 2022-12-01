<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of TextForm
 */
class TextForm extends Form
{
    protected array $fields_db = [
        'title' => 'heading',
        'text_content' => 'text',
    ];

    protected array $rules = [
        'heading' => ['required'],
        'text' => ['required'],
        'tags' => ['tags'],
    ];

    protected array $labels = [
        'heading' => 'Заголовок',
        'text' => 'Текст поста',
        'tags' => 'Теги',
    ];
}

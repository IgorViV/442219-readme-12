<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of LinkForm
 */
class LinkForm extends Form
{
    protected array $fields = [
        'heading',
        'link',
        'tags',
    ];

    protected array $fields_db = [
        'title' => 'heading',
        'site_url' => 'link',
    ];

    protected array $rules = [
        'heading' => ['required'],
        'link' => ['required', 'url'],
        'tags' => ['tags'],
    ];

    protected array $labels = [
        'heading' => 'Заголовок',
        'link' => 'Ссылка',
        'tags' => 'Теги',
    ];
}

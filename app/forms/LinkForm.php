<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of LinkForm
 */
class LinkForm extends Form
{
    protected $fields = [
        'heading',
        'link',
        'tags',
    ];

    protected $fields_db = [
        'title' => 'heading',
        'site_url' => 'link',
    ];

    protected $rules = [
        'heading' => ['required'],
        'link' => ['required', 'url'],
        'tags' => ['tags'],
    ];

    protected $labels = [
        'heading' => 'Заголовок',
        'link' => 'Ссылка',
        'tags' => 'Теги',
    ];
}

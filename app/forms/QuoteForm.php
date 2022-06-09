<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of QuoteForm
 */
class QuoteForm extends Form
{
    protected $fields = [
        'heading',
        'quote',
        'quote-author',
        'tags',
    ];

    protected $rules = [
        'heading' => ['required'],
        'quote' => ['required'],
        'quote-author' => ['required'],
        'tags' => ['tags'],
    ];

    protected $labels = [
        'heading' => 'Заголовок',
        'quote' => 'Текст цитаты',
        'quote-author' => 'Автор',
        'tags' => 'Теги',
    ];
}

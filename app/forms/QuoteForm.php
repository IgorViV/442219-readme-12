<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of QuoteForm
 */
class QuoteForm extends Form
{
    protected array $fields = [
        'heading',
        'quote',
        'quote-author',
        'tags',
    ];

    protected array $fields_db = [
        'title' => 'heading',
        'text_content' => 'quote',
        'author_quote' => 'quote-author',
    ];

    protected array $rules = [
        'heading' => ['required'],
        'quote' => ['required'],
        'quote-author' => ['required'],
        'tags' => ['tags'],
    ];

    protected array $labels = [
        'heading' => 'Заголовок',
        'quote' => 'Текст цитаты',
        'quote-author' => 'Автор',
        'tags' => 'Теги',
    ];
}

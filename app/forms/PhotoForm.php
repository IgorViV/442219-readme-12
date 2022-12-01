<?php
namespace Readme\app\forms;

use Readme\app\forms\Form;

/**
 * Description of PhotoForm
 */
class PhotoForm extends Form
{
    protected array $fields_db = [
        'title' => 'heading',
        'img_url' => 'file-photo',
    ];

    protected array $rules = [
        'heading' => ['required'],
        'photo-url' => ['link'],
        'tags' => ['tags'],
        'file-photo' => ['file'],
    ];

    protected array $labels = [
        'heading' => 'Заголовок',
        'photo-url' => 'Ссылка из интернета',
        'tags' => 'Теги',
        'file-photo' => 'Файл изображения'
    ];

    /**
     * Validation of the image file selection field
     *
     * @var string $field_name Field name
     */
    protected function runFileValidator(string $field_name): bool
    {
        if (empty($_FILES[$field_name]['name']) && empty($_POST['photo-url'])) {
            $this->errors[$field_name][] = 'Загрузите изображение или укажите ссылку';
            $this->errors['photo-url'][] = 'Загрузите изображение или укажите ссылку';

            return false;
        }

        if (!$this->runImgValidator($field_name)) {
            return false;
        }

        return true;
    }

    /**
     * Validation of the image file link field
     *
     * @var string $field_name Field name
     */
    protected function runLinkValidator(string $field_name): bool
    {
        if (!$this->runUrlValidator($field_name)) {
            return false;
        }

        // TODO - Валидация поля «Ссылка из интернета»
        // Сперва следует проверить правильность формата. Значение поля должно быть
        // корректным URL-адресом. Используйте встроенную функцию filter_var и фильтр FILTER_VALIDATE_URL.
        // Затем по указанной ссылке необходимо скачать файл изображения, сохранить его в публичной папке
        // и добавить ссылку на изображение в таблицу постов вместе с остальной информацией.
        // Получить содержимое удалённого файла можно, например, встроенной функцией file_get_contents.
        // Если функция вернула false или пустую строку, значит файл загрузить не получилось.
        // Такая ситуация должна являться ошибкой валидации поля.

        return true;
    }
}

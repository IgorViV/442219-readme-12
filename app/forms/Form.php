<?php
namespace Readme\app\forms;

use finfo;
use Readme\app\models\Post;

/**
 * Base class for form processing
 */
abstract class Form
{
    protected $rules = [];
    protected $labels = [];
    protected $form_data = [];
    protected $errors = [];
    protected $fields_db = [];
    protected $file_url = '';
    protected $data_db = [];
    protected $name_model_class = 'Post';

    public function __construct()
    {
        $this->fillFormData();
    }

    /**
     * Performs validation of form fields according to the rules
     */
    public function validate()
    {
        foreach($this->rules as $field => $rules) {
            foreach($rules as $rule_name) {
                $this->runValidator($field, $rule_name);
            }
        }
    }

    /**
     * Launches the validator for the field
     *
     * @var string Field name
     * @var string Rule name
     */
    protected function runValidator($field, $rule_name)
    {
        $method_name = 'run' . ucfirst($rule_name) . 'Validator';

        if (method_exists($this, $method_name)) {
            $this->$method_name($field);
        }
    }

    /**
     * Validate required field
     *
     * @var string Field name
     */
    protected function runRequiredValidator(string $field_name)
    {
        if (strlen(trim($_POST[$field_name])) === 0) {
            $this->errors[$field_name][] = 'Это поле должно быть заполнено';

            return false;
        }

        return true;
    }

    /**
     * Validate email field
     *
     * @var string Field name
     */
    protected function runEmailValidator(string $field_name)
    {
        if (filter_input(INPUT_POST, $field_name) && !filter_input(INPUT_POST, $field_name, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field_name][] = 'Введите корректный email';

            return false;
        }

        return true;
    }

    /**
     * Validate length value field
     *
     * @var string Field name
     * @var int Minimal value field
     * @var int Maximal value field
     */
    protected function runLengthValidator(string $field_name, int $min = MIN_LENGTH, int $max = MAX_LENGTH)
    {
        $len = strlen(trim($_POST[$field_name]));

        if ($len < $min or $len > $max) {
            $this->errors[$field_name][] = "Значение должно быть от $min до $max символов";

            return false;
        }

        return true;
    }

    /**
     * Validate link
     *
     * @var string Field name
     */
    protected function runUrlValidator(string $field_name)
    {
        if (filter_input(INPUT_POST, $field_name) && !filter_input(INPUT_POST, $field_name, FILTER_VALIDATE_URL)) {
            $this->errors[$field_name][] = 'Введите корректный URL';

            return false;
        }

        return true;
    }

    /**
     * Validate tags
     *
     * @var string Field name
     */
    protected function runTagsValidator(string $field_name)
    {
        // TODO - Валидация поля «Теги»
        // В этом поле пользователь вводит теги, к которым относится публикация.
        // Теги разделяются пробелом. Выполняя валидацию, нужно убедиться,
        // что в поле одно или больше слов, а сами слова разделены пробелом.
        // Каждый тег состоит только из одного слова.
        // - Привязка тегов к публикации
        // Информацию из поля «Теги» надо разделить на отдельные теги-слова.
        // Эти теги сохраняются в отдельной таблице и ссылаются на запись из таблицы постов

        return true;
    }

    /**
     * Validate image
     *
     * @var string Field name
     */
    protected function runImgValidator(string $field_name)
    {

        if (!empty($_FILES[$field_name]['name'])) {
            $tmp_name = $_FILES[$field_name]['tmp_name'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $file_type = $finfo->file($tmp_name);
            $file_ext = $this->getFileExtension($file_type, IMAGE_EXT);

            if (!$file_ext) {
                $this->errors[$field_name][] = 'Загрузите изображение в формате JPEG, PNG или GIF';

                return false;
            }
        }

        return true;
    }

    /**
     * Gets the file extension by its type
     *
     * @var string File type
     * @var array File extensions
     *
     * @return string Extention | false
     */
    protected function getFileExtension(string $file_type, array $file_ext)
    {
        foreach($file_ext as $type => $extension) {
            if ($file_type === $type) {
                return $extension;
            }
        }

        return false;
    }

    /**
     * Get all errors
     *
     * @return array
     */
    public function getAllErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get a field error
     *
     * @var string Field name
     */
    public function getError(string $field) {
        return $this->errors[$field] ?? null;
    }

    /**
     * Get all labels form
     */
    public function getAllLabels(): array
    {
        return $this->labels;
    }

    /**
     * Get data from all form fields
     */
    public function getData()
    {
        return $this->form_data;
    }

    /**
     * Fills the array with data from the form
     */
    protected function fillFormData()
    {
        $fields = array_values($this->fields_db);
        foreach($fields as $field) {
            if ($field === 'file-photo') {
                $this->form_data[$field] = $this->file_url;
            } else {
                $this->form_data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
    }

    /**
     * Uploads file
     */
    public function uploadsFile()
    {
        if (isset($_FILES['file-photo']['name'])) {
            $file_name = $_FILES['file-photo']['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_ext;
            $file_path = './uploads/';
            $this->file_url = './uploads/' . $file_name;
            move_uploaded_file($_FILES['file-photo']['tmp_name'], $file_path . $file_name);
            $this->fillFormData();
        }
    }

    /**
     * Prepares data for writing to the database
     */
    protected function prepareDataDb(int $user_id, int $type_id)
    {
        foreach($this->fields_db as $field_db => $field_form) {
            foreach($this->form_data as $field => $value) {
                if ($field_form === $field) {
                    $this->data_db[$field_db] = $value;
                }
            }
        }
        $this->data_db['user_id'] = $user_id;
        $this->data_db['type_id'] = $type_id;
    }

    /**
     * Writing to the database
     *
     * @param object Object of the model class
     */
    public function writeDb(object $model, $user_id, $type_id)
    {
        $this->prepareDataDb($user_id, $type_id);

        if(count($this->data_db)){
            $model->add(array_keys($this->data_db), array_values($this->data_db));
            var_dump($this->data_db);
        }

        return $model->getLastId();
    }
}

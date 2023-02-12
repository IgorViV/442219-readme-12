<?php
namespace Readme\app\forms;

use finfo;
use Readme\app\models\User;

/**
 * Base class for form processing
 */
abstract class Form
{
    protected string $form_name = 'adding-post';
    protected array $rules = [];
    protected array $labels = [];
    protected array $form_data = [];
    protected array $errors = [];
    protected array $fields = [];
    protected array $types_fields = [];
    protected array $fields_db = [];
    protected string $file_field = 'file-photo'; // TODO refactoring: exclude
    protected string $file_url = '';
    protected string $file_path = './uploads/';
    protected array $data_db = [];
    protected array $placeholders;

    public function __construct()
    {
        $this->fillFormData();
    }

    /**
     * Performs validation of form fields according to the rules
     */
    public function validate(): void
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
     * @param string $field Field name
     * @param string $rule_name Rule name
     */
    protected function runValidator(string $field, string $rule_name): void
    {
        $method_name = 'run' . ucfirst($rule_name) . 'Validator';

        if (method_exists($this, $method_name)) {
            $this->$method_name($field);
        }
    }

    /**
     * Validate required field
     *
     * @param string $field_name Field name
     * @return bool
     */
    protected function runRequiredValidator(string $field_name): bool
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
     * @param string $field_name Email field name
     * @return bool
     */
    protected function runEmailValidator(string $field_name): bool
    {
        if (filter_input(INPUT_POST, $field_name) &&
            !filter_input(INPUT_POST, $field_name, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field_name][] = 'Введите корректный email';

            return false;
        }

        if (empty($this->errors[$field_name])) {
            $email = filter_input(INPUT_POST, $field_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user = new User();
            $id_users_for_email = $user->findUserEmail($email);

            if (!empty($id_users_for_email)) {
                $this->errors[$field_name][] = 'Пользователь с этим email уже зарегистрирован';

                return false;
            }
        }

        return true;
    }

    /**
     * Validate length value field
     *
     * @param string $field_name Field name
     * @param int $min Minimal value field
     * @param int $max Maximal value field
     * @return bool
     */
    protected function runLengthValidator(string $field_name, int $min = MIN_LENGTH, int $max = MAX_LENGTH): bool
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
     * @param string $field_name Field name
     * @return bool
     */
    protected function runUrlValidator(string $field_name): bool
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
     * @param string $field_name Field name
     * @return bool
     */
    protected function runTagsValidator(string $field_name): bool
    {
        // TODO - Валидация поля «Теги»
        // В этом поле пользователь вводит теги, к которым относится публикация.
        // Теги разделяются пробелом. Выполняя валидацию, нужно убедиться,
        // что в поле одно или больше слов, а сами слова разделены пробелом.
        // Каждый тег состоит только из одного слова.
        // - Привязка тегов к публикации
        // Информацию из поля «Теги» надо разделить на отдельные теги-слова.
        // Эти теги сохраняются в отдельной таблице и ссылаются на запись из таблицы постов
        // /(^#[a-zа-яё0-9]{1,30})/i регулярное выражение ?
        // (#(?<tag>[A-Za-zА-Яа-я]{1,19})\s*)+

        if (!empty(filter_input(INPUT_POST, $field_name))) {
            $tags = explode(' ', filter_input(INPUT_POST, $field_name));

            foreach ($tags as $tag) {
                if (substr($tag, 0) !== '#') {
                    $this->errors[$field_name][] = 'Хэштег должен начинаться символом #'; // ?
                }
                // TODO implement on regexp
            }

//            if (false) {
//                $this->errors[$field_name][] = 'Теги нужно разделять пробелом';
//            }

            if (count($this->errors[$field_name])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate image
     *
     * @param string $field_name Field name
     * @return bool
     */
    protected function runImgValidator(string $field_name): bool
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
     * @param string $file_type File type
     * @param array $file_ext File extensions
     *
     * @return string|bool Extention | false
     */
    protected function getFileExtension(string $file_type, array $file_ext): string | bool
    {
        foreach($file_ext as $type => $extension) {
            if ($file_type === $type) {
                return $extension;
            }
        }

        return false;
    }

    /**
     * Get all fields form
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Get all fields for db
     *
     * @return array
     */
    public function getFieldsDb(): array
    {
        return $this->fields_db;
    }

    /**
     * Get type of field
     *
     * @var string $name_field Name field
     * @return string Type of field
     */
    public function getTypeField(string $name_field): string
    {
        return $this->types_fields[$name_field];
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
     * @param string $field Field name
     * @return string | null
     */
    public function getError(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }

    /**
     * Get all labels form
     * @return array
     */
    public function getAllLabels(): array
    {
        return $this->labels;
    }

    /**
     * Get label field
     *
     * @param string $name_field Name field
     * @return string
     */
    public function getLabel(string $name_field): string
    {
        return $this->labels[$name_field];
    }

    /**
     * Get all rules for field
     *
     * @param string $name_field
     * @return array
     */
    public function getRulesField(string $name_field): array
    {
        return $this->rules[$name_field];
    }

    /**
     * Get name the form
     *
     * @return string
     */
    public function getFormName(): string
    {
        return $this->form_name;
    }

    /**
     * Get placeholder input field
     *
     * @param string $name_field
     * @return string
     */
    public function getPlaceholder(string $name_field): string
    {
        if (array_key_exists($name_field, $this->placeholders)) {
            return $this->placeholders[$name_field];
        }

        return '';
    }

    /**
     * Get data from all form
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->form_data;
    }

    /**
     * Fills the array with data from the form
     */
    protected function fillFormData(): void
    {
        $fields = array_values($this->fields_db);

        foreach($fields as $field) {
            if ($field === $this->file_field) {
                $this->form_data[$field] = $this->file_url;
            } else {
                $this->form_data[$field] = filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }

        if (in_array('password-repeat', $this->fields)) {
            $this->form_data['password-repeat'] = filter_input(
                INPUT_POST,
                'password-repeat',
                FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

    /**
     * Uploads file
     */
    public function uploadsFile(): void
    {
        if (isset($_FILES[$this->file_field]['name'])) {
            $file_name = $_FILES[$this->file_field]['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_ext;
            $this->file_url = $this->file_path . $file_name;
            move_uploaded_file($_FILES[$this->file_field]['tmp_name'], $this->file_url);
            $this->fillFormData();
        }
    }

    /**
     * Prepares data for writing to the database
     *
     */
    protected function prepareDataDb(): void
    {
        foreach($this->fields_db as $field_db => $field_form) {
            foreach($this->form_data as $field => $value) {
                if (($field_form === $field) && ($field !== 'password')) {
                    $this->data_db[$field_db] = $value;
                }
                if (($field_form === $field) && ($field === 'password')) {
                    $this->data_db[$field_db] = password_hash($value, PASSWORD_DEFAULT);
                }
            }
        }
    }

    /**
     * Set additional data for DB
     *
     * @param string $name_field
     * @param mixed $value_field
     * @return void
     */
    public function setDataDb(string $name_field, mixed $value_field): void
    {
        if(!empty($name_field)) {
            $this->data_db[$name_field] = $value_field;
        }
    }

    /**
     * Writing to the database
     *
     * @param object $model Object of the model class
     */
    public function writeDb(object $model): int
    {
        $this->prepareDataDb();

        if(count($this->data_db)){
            $model->add(array_keys($this->data_db), array_values($this->data_db));
        }

        return $model->getLastId();
    }

    /**
     * Add new data in form data for write database
     *
     * @param array $names_keys
     * @param array $values_keys
     * @return void
     */
    public function addData(array $names_keys, array $values_keys): void
    {
        $comb_array = array_combine($names_keys, $values_keys);
        foreach ($comb_array as $key => $value) {
            $this->form_data[$key] = $value;
        }
    }

    /**
     * Transaction
     */
    public function addTransaction()
    {
        // TODO implement method
    }
}

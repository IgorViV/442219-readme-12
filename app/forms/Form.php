<?php
namespace Readme\app\forms;

/**
 * Base class for form processing
 */
class Form
{
    protected $rules = [];
    protected $labels = [];
    protected $form_data = [];
    protected $errors = [];
    protected $fields = [];

    // protected $model;

    public function __construct()
    {
        // echo 'Form::__constructor'; // TODO What?
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
        if (empty(trim($_POST[$field_name]))) {
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
        if (!filter_input(INPUT_POST, $field_name, FILTER_VALIDATE_EMAIL)) {
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
        $len = strlen($_POST[$field_name]);

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
        if (!filter_input(INPUT_POST, $field_name, FILTER_VALIDATE_URL)) {
            $this->errors[$field_name][] = 'Введите корректный URL';

            return false;
        }

        return true;
    }

    /**
     * Validate file
     *
     * @var string Field name
     */
    protected function runFileValidator(string $field_name)
    {
        // TODO Implementation method()

        return true;
    }

    /**
     * Validate tags
     *
     * @var string Field name
     */
    protected function runTagsValidator(string $field_name)
    {
        // TODO Implementation method()
        // - Валидация поля «Теги»
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
        // TODO Implementation method()

        // === Валидация записи типа «Картинка» ===
        // - При заполнении формы пользователю обязательно надо выбрать файл изображения
        // со своего компьютера, либо указать прямую ссылку на изображение, размещенное в интернете.
        // Следовательно, надо написать правило валидации, которое проверяет, что минимум одно из
        // полей заполнено.
        // Если заполнены оба поля, то игнорировать содержимое поля «Ссылка из интернета».
        // - Валидация поля «Выбор файла»
        // Обязательно проверять MIME-тип загруженного файла. Формат загруженного файла
        // должен быть изображением одного из следующих типов: png, jpeg, gif.
        // Выбранный файл сохранить в отдельной,
        // публичной папке и добавить ссылку на изображение в таблицу постов вместе с остальной информацией.
        // - Валидация поля «Ссылка из интернета»
        // Сперва следует проверить правильность формата. Значение поля должно быть
        // корректным URL-адресом. Используйте встроенную функцию filter_var и фильтр FILTER_VALIDATE_URL.
        // Затем по указанной ссылке необходимо скачать файл изображения, сохранить его в публичной папке
        // и добавить ссылку на изображение в таблицу постов вместе с остальной информацией.
        // Получить содержимое удалённого файла можно, например, встроенной функцией file_get_contents.
        // Если функция вернула false или пустую строку, значит файл загрузить не получилось.
        // Такая ситуация должна являться ошибкой валидации поля.

        return true;
    }

    /**
     * Validate video
     *
     * @var string Field name
     */
    protected function validateVideo(string $field_name)
    {
        // TODO Implementation method()
        // === Валидация записи типа «Видео»:
        // При заполнении формы пользователь обязательно указывает ссылку на видео,
        // размещённое на сайте YouTube.
        // Сперва следует проверить правильность формата. Значение поля должно быть корректным URL-адресом.
        // Используйте встроенную функцию filter_var и фильтр FILTER_VALIDATE_URL.
        // Затем происходит проверка существования видео по указанной ссылке на платформе YouTube.
        // Эту проверку можно провести с помощью функции check_youtube_url, которая лежит
        // в папке с проектом в сценарии helpers.php.

        return true;
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
}

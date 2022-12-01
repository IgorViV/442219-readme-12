<?php

namespace Readme\app\forms;

class SignupForm extends Form
{
    protected string $form_name = 'registration';
    protected string $file_field = 'file'; // TODO refactoring: exclude
    protected string $file_path = './uploads/avatars/';
    protected array $fields = [
        'email',
        'login',
        'password',
        'password-repeat',
        'file',
    ];

    protected array $types_fields = [
        'email' => 'email',
        'login' => 'text',
        'password' => 'password',
        'password-repeat' => 'password',
        'file' => 'file',
    ];

    protected array $fields_db = [
        'email' => 'email',
        'user_name' => 'login',
        'user_password' => 'password',
        'avatar_url' => 'file',
    ];

    protected array $rules = [
        'email' => ['required', 'email'],
        'login' => ['required'],
        'password' => ['required'],
        'password-repeat' => ['required', 'repeat'],
        'file' => ['img'],
    ];

    protected array $labels = [
        'email' => 'Электронная почта',
        'login' => 'Логин',
        'password' => 'Пароль',
        'password-repeat' => 'Повтор пароля',
        'file' => 'Выбрать фото',
    ];

    protected array $placeholders = [
        'email' => 'Укажите эл.почту',
        'login' => 'Укажите логин',
        'password' => 'Придумайте пароль',
        'password-repeat' => 'Повторите пароль',
    ];

    /**
     * Validation of the password-repeat field
     *
     * @return bool
     */
    protected function runRepeatValidator(): bool
    {

        if (empty($this->errors['password-repeat']) && ($_POST['password'] !== $_POST['password-repeat'])) {
            $this->errors['password-repeat'][] = 'Пароли не совпадают';

            return false;
        }

        return true;
    }
}

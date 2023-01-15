<?php

namespace Readme\app\forms;

use Readme\app\models\User;

class LoginForm extends Form
{
    protected string $form_name = 'authorization';
    protected array $fields = [
        'email',
        'password',
    ];

    protected array $types_fields = [
        'email' => 'email',
        'password' => 'password',
    ];

    protected array $fields_db = [
        'email' => 'email',
        'user_password' => 'password',
    ];

    protected array $rules = [
        'email' => ['required', 'email'],
        'password' => ['required', 'password'],
    ];

    protected array $labels = [
        'email' => 'Электронная почта',
        'password' => 'Пароль',
    ];

    protected array $placeholders = [
        'email' => 'Укажите эл.почту',
        'password' => 'Укажите пароль',
    ];

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

            if (empty($user->findUserEmail($email))) {
                $this->errors[$field_name][] = 'Вы ввели неверный email';

                return false;
            }
        }

        return true;
    }

    /**
     * Validate password field
     *
     * @param string $field_name Password field name
     * @return bool
     */
    protected function runPasswordValidator(string $field_name): bool
    {
        $password = filter_input(INPUT_POST, $field_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user = new User();
        $user_password = '';

        if ($user->findUserEmail($email)) {
            $user_password = ($user->findFieldsOne(['user_password'], ($user->findUserEmail($email))['id']))['user_password'];
        }

        if (!password_verify($password, $user_password) && empty($this->errors[$field_name])) {
            $this->errors[$field_name][] = 'Вы ввели неверный пароль';

            return false;
        }

        return true;
    }

}

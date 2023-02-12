<?php

namespace Readme\app\controllers;

use Readme\app\exceptions\ExceptionDbWrite;
use Readme\app\forms\SignupForm;
use Readme\app\models\User;

/**
 * Description AuthController
 */
class AuthController extends BaseController
{
    protected ?string $layout = 'layout';
    protected string $title_page = 'Readme: регистрация';
    protected bool $is_search = false;
    protected bool $is_reg = true;

    public function actionSignup()
    {
        $input_block = '';
        $error_field = '';
        $form_errors = [];
        $block_invalid = '';

        $form = new SignupForm();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form->validate();
            $form_errors = array_filter($form->getAllErrors());
            $form_data = $form->getData();

            if (empty($form_errors)) {
                $form->uploadsFile();
                $new_user = new User();
                try {
                    $new_user_id = $form->writeDb($new_user);
                    header("Location: /");
                } catch(ExceptionDbWrite $e) {
                    echo 'Ошибка записи в БД: ' . $e->getMessage();
                    exit;
                }
            }
        }

        foreach ($form->getFields() as $name_field) {
            if (!empty($form_errors[$name_field])) {
                $error_field = $this->getTemplate("../form/block-form-error-field.php", [
                    'title_error' => $form->getLabel($name_field),
                    'errors' => $form_errors[$name_field],
                ]);
            }

            $input_block .= $this->getTemplate("../form/block-form-input.php", [
                'name_form' => $form->getFormName(),
                'label' => $form->getLabel($name_field),
                'id_input' => $form->getFormName() . '-' . $name_field,
                'type_input' => $form->getTypeField($name_field),
                'name_input' => $name_field,
                'placeholder' => $form->getPlaceholder($name_field),
                'value_input' => $form_data[$name_field] ?? '',
                'is_required' => in_array('required', $form->getRulesField($name_field)),
                'block_errors' => $error_field,
                'error_field' => $form_errors[$name_field] ?? '',
            ]);
        }

//        $block_file = $this->getTemplate("../form/block-form-file.php", []); // TODO refactoring: use dropzone.js

        if (count($form_errors)) {
            $block_invalid = $this->getTemplate("../form/block-form-invalid.php", [
                'form_errors' => $form_errors,
                'labels' => $form->getAllLabels(),
            ]);
        }

        $this->setData([
            'title_page' => $this->title_page,
            'is_auth' => $this->is_auth,
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
            'input_block' => $input_block,
//            'block_file' => $block_file, // TODO refactoring: use dropzone.js
            'block_invalid' => $block_invalid,
        ]);

        $this->getView();
    }

    public function actionLogout()
    {
        $_SESSION = [];

        if (!isset($_SESSION['auth'])) {
            header("Location: /");
            exit();
        }
    }
}

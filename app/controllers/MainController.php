<?php
namespace Readme\app\controllers;

use Readme\app\forms\LoginForm;
use Readme\app\models\User;

/**
 * Description of MainController
 */
class MainController extends BaseController
{
    public function actionIndex()
    {

        if (isset($_SESSION['auth'])) {
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                header("Location: /user/index?id=$user_id");
            }
            exit;
        }

        $form_data = [];
        $form_errors = [];

        $form = new LoginForm();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form->validate();
            $form_errors = array_filter($form->getAllErrors());
            $form_data = $form->getData();

            if (empty($form_errors)) {
                $_SESSION = [];
                $_SESSION['auth'] = true;
//                $user_id = (new User())->findUserEmail($form_data['email'])['id'];
                $user = (new User())->findUserEmail($form_data['email'], '*');
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];

                header("Location: /user/index?id={$user['id']}");
                exit;
            }
        }

        $this->setData([
            'form_data' => $form_data,
            'form_errors' => $form_errors,
        ]);

        $this->getView();
    }
}

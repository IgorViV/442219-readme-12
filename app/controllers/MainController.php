<?php
namespace Readme\app\controllers;

/**
 * Description of MainController
 */
class MainController extends BaseController
{
    public function actionIndex()
    {
        if (isset($_SESSION['auth'])) {
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'post';
            header("Location: http://$host$uri/$extra");
            exit;
        }

        $this->getView();
    }
}

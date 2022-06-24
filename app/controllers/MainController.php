<?php
namespace Readme\app\controllers;

use Readme\app\controllers\BaseController;

/**
 * Description of MainController
 */
class MainController extends BaseController
{
    public function actionIndex()
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'post';
        header("Location: http://$host$uri/$extra");
        exit;
    }
}

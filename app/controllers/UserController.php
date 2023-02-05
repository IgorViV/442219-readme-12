<?php

namespace Readme\app\controllers;

use Readme\app\models\User;

/**
 * Description of UserController
 */
class UserController extends BaseController
{
    protected ?string $layout = 'layout';
    protected string $title_page = 'Readme: моя лента';

    public function actionIndex()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: /");

            exit;
        }

        $this->uri_page = 'user'; // TODO ?

        $this->is_auth = $_SESSION['auth'];
//        $user_name = (new User())->findFieldsOne(['user_name'], $_SESSION['user_id'])['user_name'];
        $user_name = $_SESSION['user_name'];
        $this->setData([
//            'popular_posts' => $popular_posts,
//            'types' => $types,
//            'type_id' => $type_id,
//            'posts_sort' => $posts_sort,
            'is_auth' => $this->is_auth,
            'user_name' => $user_name,
            'title_page' => $this->title_page,
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
            'uri_page' => $this->uri_page,
        ]);

        $this->getView();
    }
}

<?php
namespace Readme\app\controllers;

use Readme\app\controllers\BaseController;
use Readme\app\models\Post;
use Readme\app\models\Type;

/**
 * Description of PostController
 */
class PostController extends BaseController
{
    protected $layout = 'layout';
    protected $title_page = 'Популярные посты';

    public function actionIndex()
    {
        // TODO Delete after authorization is implemented
        $is_auth = true;
        $user_name = 'Igor';

        $popular_posts = '';
        $type = new Type();
        $post = new Post();

        $types = $type->findAll();

        $type_id = filter_input(INPUT_GET, 'type') ?? TYPE_ALL;
        $posts_sort = filter_input(INPUT_GET, 'sort') ?? CURRENT_SORT;

        if ($type_id) {
            $posts = $post->getPopularPostsFromType($type_id);
        } else {
            $posts = $post->getPopularPosts();
        }

        if ($posts_sort) {
            // TODO Implement sorting
        }

        foreach($posts as $post) {
            $post['diff_time'] = get_diff_time_public_post($post['created_at']);
            $post_content = $this->getTemplate("blocks/block-{$post['type_alias']}.php", [
                'post' => $post,
            ]);
            $popular_posts .= $this->getTemplate('blocks/post-popular.php', [
                'post' => $post,
                'post_content' => $post_content,
            ]);
        }

        $this->setData([
            'popular_posts' => $popular_posts,
            'types' => $types,
            'type_id' => $type_id,
            'posts_sort' => $posts_sort,
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'title_page' =>$this->title_page,
        ]);

        $this->getView();
    }

    public function actionView()
    {
        echo 'PostController::actionView';
    }
}

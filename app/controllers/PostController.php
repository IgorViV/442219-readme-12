<?php
namespace Readme\app\controllers;

use Readme\app\controllers\BaseController;
use Readme\app\models\Post;
use Readme\app\models\Type;
use Readme\app\models\Comment;

/**
 * Description of PostController
 */
class PostController extends BaseController
{
    protected $layout = 'layout';
    protected $title_page = 'Популярные посты';

    /**
     * Actions for displaying popular posts
     */
    public function actionIndex()
    {
        // TODO Delete after authorization is implemented
        $is_auth = true;
        $user_name = 'Igor';
        // =================

        $popular_posts = '';
        $type = new Type();
        $post = new Post();
        $comment = new Comment();

        $types = $type->findAll();

        $type_id = filter_input(INPUT_GET, 'type') ?? TYPE_ALL;
        $posts_sort = filter_input(INPUT_GET, 'sort') ?? CURRENT_SORT;

        if ($type_id) {
            $posts = $post->findPopularPostsFromType($type_id);
        } else {
            $posts = $post->findPopularPosts();
        }

        if ($posts_sort) {
            // TODO Implement sorting
        }

        foreach($posts as $post) {
            $post['diff_time'] = get_diff_time_public_post($post['created_at']);
            $post_content = $this->getTemplate("blocks-popular/block-{$post['type_alias']}.php", [
                'post' => $post,
            ]);

            $count_comments = count($comment->findAllByPost($post['posts_id']));

            $popular_posts .= $this->getTemplate('blocks-popular/post-popular.php', [
                'post' => $post,
                'post_content' => $post_content,
                'count_comments' => $count_comments,
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

    /**
     * Actions to display the selected post
     */
    public function actionView()
    {
        // TODO Delete after authorization is implemented
        $is_auth = true;
        $user_name = 'Igor';
        // =================

        $post_id = filter_input(INPUT_GET, 'id');
        $post = new Post();
        $cur_post = $post->findPostById($post_id);

        $post_content = $this->getTemplate("blocks-popular/block-{$cur_post['type_alias']}.php", [
            'post' => $cur_post,
        ]);

        $comment = new Comment();
        $all_comments = $comment->findAllByPost($post_id);

        $this->setData([
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'title_page' =>$this->title_page,
            'post' => $cur_post,
            'post_content' => $post_content,
            'comments' => $all_comments,
        ]);
        $this->getView();

        // === REQUIRED DATA ===
        // +* @var array $post
        // +* @var string Typed site content (block template)
        // +* @var string Title post
        // * @var int Number of likes
        // +* @var int Number of comments
        // * @var int Number of repost
        // * @var array Hashtags
        // * @var string URL avatar current user for form new comments
        // * @var string URL avatar of the author of the comment
        // * @var string Name of the comment author
        // * @var string Datatime of writing the comment
        // * @var string Comment text
        // * @var string URL avatar of the author current post
        // * @var string Name of the current post author
        // * @var string Datetime registration author of the current post
        // * @var string Number of subscribers of the author current post
        // * @var string Number of publications of the author current post

        // TODO Если параметр запроса отсутствует, либо если по этому ID не нашли ни одной записи,
        // то вместо содержимого страницы возвращать код ответа 404.
    }

    /**
     * Actions to add a new post
     */
    public function actionAdd()
    {
        // TODO Delete after authorization is implemented
        $is_auth = true;
        $user_name = 'Igor';
        // =================

        $type = new Type();
        $types = $type->findAll();
        $filter_content = '';
        $tabs_content = '';
        $form_content = '';
        $form_file = '';
        $val_input = '';
        $form_errors = [];
        $block_error = '';
        $is_selected = false;
        $labels = [];

        $type_id = filter_input(INPUT_GET, 'type') ?? '1';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            $type_id = filter_input(INPUT_POST, 'type-post');
            $title_type = $type->findOne($type_id)['alias'];
            $form_name = 'Readme\app\forms\\' . ucfirst($title_type) . 'Form';

            $cur_form = new $form_name;
            $cur_form->validate();
            $form_errors = $cur_form->getAllErrors();
            $labels = $cur_form->getAllLabels();
        }

        foreach($types as $type) {

            if ((int)$type_id === $type['id']) {
                $is_selected = true;
            } else {
                $is_selected = false;
            }

            $filter_content .= $this->getTemplate("blocks-add/block-filter.php", [
                'type' => $type,
                'is_selected' => $is_selected,
            ]);

            if ($type['title'] === 'Фото') {
                $form_file = $this->getTemplate("blocks-add/block-form-file.php", [
                    // 'type' => $type,
                    // 'is_selected' => $is_selected,
                    // 'form_errors' => $form_errors,
                ]);
            } else {
                $form_file = '';
            }

            $block_error = $this->getTemplate("blocks-add/block-form-error-text.php", [
                // 'type' => $type,
                // 'is_selected' => $is_selected,
                // 'form_errors' => $form_errors,
                // 'val_input' => $val_input,
            ]);

            $form_content = $this->getTemplate("blocks-add/block-form-{$type['alias']}.php", [
                'form_errors' => $form_errors,
                'val_input' => $val_input,
                'block_error' => $block_error,
                'labels' => $labels,
            ]);

            $tabs_content .= $this->getTemplate("blocks-add/block-tabs.php", [
                'is_selected' => $is_selected,
                'form_errors' => $form_errors,
                'form_content' => $form_content,
                'form_file' => $form_file,
                'val_input' => $val_input,
                'block_error' => $block_error,
                'type_id' => $type_id,
                'labels' => $labels,
            ]);
        }

        $this->setData([
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'title_page' =>$this->title_page,
            'filter_content' => $filter_content,
            'tabs_content' => $tabs_content,
        ]);
        $this->getView();
    }
}

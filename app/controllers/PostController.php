<?php
namespace Readme\app\controllers;

use Readme\app\models\Post;
use Readme\app\models\Type;
use Readme\app\models\Comment;
use Readme\app\exceptions\ExceptionDbWrite;

/**
 * Description of PostController
 */
class PostController extends BaseController
{
    protected ?string $layout = 'layout';
    protected string $title_page = 'Readme: популярное';
//    protected $is_search = false;
//    protected $is_reg = true;

    /**
     * Actions for displaying popular posts
     */
    public function actionIndex()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: /");
            exit;
        }

        $this->is_auth = isset($_SESSION['auth']);
        $user_name = $_SESSION['user_name'];

        $this->uri_page = 'post';

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

        if ($posts_sort !== CURRENT_SORT) {
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
            'is_auth' => $this->is_auth,
            'user_name' => $user_name,
            'title_page' => $this->title_page,
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
            'uri_post' => $this->uri_page,
        ]);

        $this->getView();
    }

    /**
     * Actions to display the selected post
     */
    public function actionView()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: /");
            exit;
        }

        $this->is_auth = isset($_SESSION['auth']);
        $user_name = $_SESSION['user_name'];

        $post_id = filter_input(INPUT_GET, 'id');
        $post = new Post();
        $cur_post = $post->findPostById($post_id);

        $post_content = $this->getTemplate("blocks-popular/block-{$cur_post['type_alias']}.php", [
            'post' => $cur_post,
        ]);

        $comment = new Comment();
        $all_comments = $comment->findAllByPost($post_id);

        $this->setData([
            'is_auth' => $this->is_auth,
            'user_name' => $user_name,
            'title_page' =>$this->title_page,
            'post' => $cur_post,
            'post_content' => $post_content,
            'comments' => $all_comments,
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
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
        // * @var string URL avatar current auth for form new comments
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
        if (!isset($_SESSION['auth'])) {
            header("Location: /");
            exit;
        }

        $this->is_auth = isset($_SESSION['auth']);
        $user_name = $_SESSION['user_name'];
        $user_id = $_SESSION['user_id'];

        $filter_content = '';
        $tabs_content = '';
        $form_content = '';
        $form_file = '';
        $form_errors = [];
        $block_field_errors = [];
        $is_selected = false;
        $labels = [];
        $form_data = [];

        $type = new Type();
        $types = $type->findAll();

        $type_id = filter_input(INPUT_GET, 'type') ?? '1';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type_id = filter_input(INPUT_POST, 'type-post');
            $title_type = $type->findOne($type_id)['alias'];
            $form_name = 'Readme\app\forms\\' . ucfirst($title_type) . 'Form';

            $post_form = new $form_name;
            $post_form->validate();
            $form_errors = array_filter($post_form->getAllErrors());
            $labels = $post_form->getAllLabels();
            $form_data = $post_form->getData();

            foreach($form_errors as $field_name => $errors) {
                $block_errors = $this->getTemplate("blocks-add/block-form-error-text.php", [
                    'title' => $labels[$field_name],
                    'errors' => $errors,
                ]);
                $block_field_errors[$field_name] = $block_errors;
            }

            if (!$form_errors) {
                $post_form->uploadsFile();
                $form_data = $post_form->getData();
                $new_post = new Post();

                try {
                    $post_form->setDataDb('user_id', $user_id);
                    $post_form->setDataDb('type_id', $type_id);

                    $new_post_id = $post_form->writeDb($new_post);
                    header("Location: /post/view?id=" . $new_post_id);
                } catch(ExceptionDbWrite $e) {
                    echo 'Ошибка записи в БД: ' . $e->getMessage();
                    exit;
                }
            }
        }

        foreach($types as $type) {

            $is_selected = (int)$type_id === $type['id'];

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

            $form_content = $this->getTemplate("blocks-add/block-form-{$type['alias']}.php", [
                'form_errors' => $form_errors,
                'block_error' => $block_field_errors,
                'labels' => $labels,
                'post_data' => $form_data,
            ]);

            $tabs_content .= $this->getTemplate("blocks-add/block-tabs.php", [
                'is_selected' => $is_selected,
                'form_errors' => $form_errors,
                'form_content' => $form_content,
                'form_file' => $form_file,
                'block_error' => $block_field_errors,
                'type_id' => $type_id,
                'labels' => $labels,
                'post_data' => $form_data,
            ]);
        }

        $this->setData([
            'is_auth' => $this->is_auth,
            'user_name' => $user_name,
            'title_page' => 'Readme: публикация поста', //$this->title_page, // Readme: публикация поста
            'filter_content' => $filter_content,
            'tabs_content' => $tabs_content,
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
        ]);

        $this->getView();
    }

    public function actionSearch()
    {
        if (!isset($_SESSION['auth'])) {
            header("Location: /");
            exit;
        }

        $this->is_auth = isset($_SESSION['auth']);
        // TODO Delete after authorization is implemented
        $user_name = $_SESSION['user_name'];
//        $user_id = 1;
        // =================
        $posts = [];
        $found_posts = '';
        $search = '';

        $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!empty($search)) {
            $posts = (new Post())->findPostsFromSearch($search);

            foreach($posts as $post) {
                $post['diff_time'] = get_diff_time_public_post($post['created_at']);
                $post_content = $this->getTemplate("blocks-popular/block-{$post['type_alias']}.php", [
                    'post' => $post,
                ]);

                $count_comments = count((new Comment())->findAllByPost($post['posts_id']));

                $found_posts .= $this->getTemplate('blocks-popular/post-popular.php', [
                    'post' => $post,
                    'post_content' => $post_content,
                    'count_comments' => $count_comments,
                ]);
            }
        }

        $this->setData([
            'is_auth' => $this->is_auth,
            'user_name' => $user_name,
            'title_page' => 'Readme: результаты поиска', //$this->title_page, // Readme: публикация поста
            'is_search' => $this->is_search,
            'is_reg' => $this->is_reg,
            'search' => $search,
            'posts' => $posts,
            'found_posts' => $found_posts,
        ]);

        $this->getView();
    }
}

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
            $posts = $post->findPopularPostsFromType($type_id);
        } else {
            $posts = $post->findPopularPosts();
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
        // TODO Delete after authorization is implemented
        $is_auth = true;
        $user_name = 'Igor';

        $post_id = filter_input(INPUT_GET, 'id');
        $post = new Post();
        $cur_post = $post->findPostById($post_id);

        $post_content = $this->getTemplate("blocks/block-{$cur_post['type_alias']}.php", [
            'post' => $cur_post,
        ]);

        $comment = new Comment();
        $all_comments = $comment->findAllbyPost($post_id);

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
        // * @var int Number of comments
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
    }
}

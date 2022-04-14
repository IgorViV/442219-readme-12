<?php
namespace app\models;

/**
 *
 */
class Post extends Model
{
    protected $table = 'posts';
    // protected $fields = [];

    /**
     * Gets recordings of popular posts
     */
    public function getPopularPosts()
    {
        $sql = "SELECT posts.created_at, COUNT(likes.id) like_count, posts.title, "
            . "posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, "
            . "posts.view_counter, users.avatar_url, "
            . "user_name AS author, types.title AS type_content, types.alias AS type_alias "
            . "FROM posts "
            . "JOIN  users ON posts.user_id = users.id "
            . "JOIN types ON posts.type_id = types.id "
            . "JOIN likes ON posts.id = likes.post_id "
            . "GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

        return $this->db_resource->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}

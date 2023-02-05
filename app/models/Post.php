<?php
namespace Readme\app\models;

/**
 * Description of Post
 */
class Post extends Model
{
    protected string $table = 'posts';

    /**
     * Gets recordings of popular posts
     */
    public function findPopularPosts()
    {
        $sql = "SELECT posts.created_at, COUNT(likes.id) like_count, posts.id AS posts_id, posts.title, "
            . "posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, "
            . "posts.view_counter, users.avatar_url, "
            . "user_name AS author, types.id AS type_id, types.title AS type_content, types.alias AS type_alias "
            . "FROM posts "
            . "LEFT JOIN users ON posts.user_id = users.id "
            . "LEFT JOIN types ON posts.type_id = types.id "
            . "LEFT JOIN likes ON posts.id = likes.post_id "
            . "GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

        return $this->db_connect->query($sql);
    }

    /**
     * Gets recordings of popular posts sorted by type
     */
    public function findPopularPostsFromType(string $type_id)
    {
        $sql = "SELECT posts.created_at, COUNT(likes.id) like_count, posts.id AS posts_id, posts.title, "
            . "posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, "
            . "posts.view_counter, users.avatar_url, "
            . "user_name AS author, types.id AS type_id, types.title AS type_content, types.alias AS type_alias "
            . "FROM posts "
            . "JOIN users ON posts.user_id = users.id "
            . "JOIN types ON posts.type_id = types.id "
            . "JOIN likes ON posts.id = likes.post_id "
            . "WHERE type_id = ? "
            . "GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

        return $this->fetchAll($sql, [$type_id]);
    }

    /**
     * Gets recordings of popular posts sorted by post ID
     */
    public function findPostById(string $post_id)
    {
        $sql = "SELECT posts.created_at, posts.id AS posts_id, posts.title, "
            . "posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, "
            . "posts.view_counter, users.avatar_url, "
            . "user_name AS author, types.id AS type_id, types.title AS type_content, types.alias AS type_alias "
            . "FROM posts "
            . "JOIN users ON posts.user_id = users.id "
            . "JOIN types ON posts.type_id = types.id "
            . "WHERE posts.id = ? LIMIT 1";

        return $this->fetchAssoc($sql, [$post_id]);
    }

    /**
     * Gets recordings of posts sorted by type
     */
    public function findPostsFromSearch(string $search_value)
    {
        $sql = "SELECT posts.created_at, posts.id AS posts_id, posts.title, COUNT(likes.id) like_count, "
            . "posts.text_content, posts.author_quote, posts.img_url, posts.video_url, posts.site_url, "
            . "posts.view_counter, users.avatar_url, "
            . "user_name AS author, types.id AS type_id, types.title AS type_content, types.alias AS type_alias "
            . "FROM posts "
            . "LEFT JOIN users ON posts.user_id = users.id "
            . "LEFT JOIN types ON posts.type_id = types.id "
            . "LEFT JOIN likes ON posts.id = likes.post_id "
            . "WHERE MATCH(posts.title, posts.text_content) AGAINST(?) "
            . "GROUP BY posts.id ORDER BY COUNT(likes.id) DESC;";

        return $this->fetchAll($sql, [$search_value]);
    }
}

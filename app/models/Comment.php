<?php
namespace Readme\app\models;

use Readme\app\models\Model;

/**
 * Description of Comment
 */
class Comment extends Model
{
    protected string $table = 'comments';

    /**
     *
     */
    public function findAllByPost($post_id)
    {
        $sql = "SELECT comments.created_at, content, users.user_name "
        . "FROM comments "
        . "JOIN users ON author_id = users.id "
        . "JOIN posts ON posts.id = comments.id "
        . "WHERE post_id = ?";

        return $this->fetchAll($sql, [$post_id]);
    }
}

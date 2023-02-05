<?php
namespace Readme\app\models;

use Readme\app\exceptions\ExceptionDbConnect;

/**
 * Description of User
 */
class User extends Model
{
    protected string $table = 'users';

    /**
     * Gets an entry by id only specified fields
     *
     * @param string $email
     * @param string $name_field
     * @return mixed
     */
    public function findUserEmail(string $email, string $name_field = 'id'): mixed
    {
        $sql = "SELECT {$name_field} FROM {$this->table} WHERE email = ?";

        return $this->fetchAssoc($sql, [$email]);
    }
}

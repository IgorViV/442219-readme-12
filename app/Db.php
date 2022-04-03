<?php
/**
 * Class Database connect
 */
namespace app;

use Exception;
use mysqli;

class Db
{
    private $db_resource;
    private $last_error = null;

    public function __construct(string $host, string $login, string $password, string $db)
    {
        $mysqli = new mysqli($host, $login, $password, $db);

        if (!$mysqli) {
            throw new Exception('Ошибка подкючения к БД');
        }

        $mysqli->set_charset('utf8');
        $this->db_resource = $mysqli;
    }

    public function executeQuery(string $sql, string $types = null, array $values = null): array
    {
        $stmt = $this->db_resource->prepare($sql);
        if ($types && $values) {
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLastId(): string
    {
        return $this->db_resource->insert_id;
    }
}

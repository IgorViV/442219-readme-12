<?php
namespace Readme\app\services;

use Readme\app\exceptions\ExceptionDbConnect;
use Readme\app\exceptions\ExceptionPrepareData;

/**
 * Database connection class
 */
class Db
{
    protected $connect;
    protected static $instance;

    protected function __construct()
    {
        $db = require_once ROOT . '/config/database.php';
        try {
            $this->connect = new \mysqli($db['host'], $db['user'], $db['password'], $db['database']);
            $this->connect->set_charset("utf8");
        } catch(ExceptionDbConnect $e) {
            echo 'Ошибка подключения к БД: ' . $e->getMessage();
            exit;
        }
    }

    /**
     * Creates an instance of a database connection
     *
     * @return object instance
     */
    public static function instance(): object
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Executes the prepared expression
     *
     * @param string @sql SQL
     * @return boolean True - successfully
     */
    public function execute(string $sql): bool
    {
        $stmt = $this->prepare($sql);

        if (!$stmt) {
            throw new ExceptionPrepareData('Ошибка инициализации подготовленного выражения: ');
        }

        return $stmt->execute();
    }

    /**
     * Executes an sql query
     *
     * @param string $sql Query
     * @return array
     */
    public function query(string $sql): array
    {
        $stmt = $this->prepare($sql);

        if (!$stmt->execute()) {
            return [];
        }

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Prepare stmt
     *
     * @param string $sql Query
     * @return object
     */
    public function prepare(string $sql): object
    {
        return $this->connect->prepare($sql);
    }
}

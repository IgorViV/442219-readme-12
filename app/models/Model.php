<?php
namespace app\models;

use app\exceptions\ExceptionDbConnect;
use app\exceptions\ExceptionPrepareData;

/**
 * Model is the abstract class for data models.
 *
 */
abstract class Model
{
    protected $db_resource;
    protected $table;
    // protected $fields;

    public function __construct($connect)
    {
        return $this->db_resource = $connect;
    }

    /**
     * Adds an entry to the database table
     *
     * @param array $fields Name of fields
     * @param array Svalues Field values
     */
    public function add(array $fields, array $values)
    {
        if (count($fields) !== count($values)) {
            throw new ExceptionPrepareData('Ошибка входных данных: ');
        }

        $current_table = $this->table;

        $prepare_data = $this->getPrepareData($values);

        $sql = "INSERT INTO {$current_table} (" . implode(', ', $fields) . ") VALUES ("
            . $prepare_data['alias_values'] . ")";

        $stmt = $this->getPrepareStmt($sql, $values);

        if (!$stmt->execute()) {
            throw new ExceptionDbConnect('Ошибка записи в БД: ');
        }
    }

    /**
     * Gets an entry by id
     *
     * @param string $id Id of record
     */
    public function findOne(string $id) // TODO prepare
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";

        return $this->db_resource->query($sql)->fetch_assoc();
    }

    /**
     * Retrieves all records from the table
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        return $this->db_resource->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Retrieves records of only the specified fields
     *
     * @param array $fields Fields of table
     */
    public function findFields(array $fields)
    {
        $name_fields = implode(', ', $fields);
        $sql = "SELECT {$name_fields} FROM {$this->table}";

        return $this->db_resource->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Gets an entry by id only specified fields
     *
     * @param array $fields Fields of table
     * @param string @id Id of record
     */
    public function findFieldsOne(array $fields, string $id) //TODO prepare
    {
        $name_fields = implode(', ', $fields);
        $sql = "SELECT {$name_fields} FROM {$this->table} WHERE id = {$id}";

        return $this->db_resource->query($sql)->fetch_assoc();
    }

    /**
     * Gets the id of the last record made
     */
    public function getLastId()
    {
        return $this->db_resource->insert_id;
    }

    /**
     * Prepares the data display for the prepared expression
     *
     * @param array $data Data
     */
    protected function getPrepareData(array $data)
    {
        $alias_values = '?';
        $types = '';

        for ($i = 1; $i < count($data); $i++) {
            $alias_values .= ', ?';
        }

        foreach ($data as $value) {
            switch (true) {
                case is_int($value):
                    $type = 'i';
                    break;
                case is_string($value):
                    $type = 's';
                    break;
                case is_double($value):
                    $type = 'd';
                    break;
                default:
                    $type = 's';
            }

            if ($type) {
                $types .= $type;
            }
        }

        return [
            'alias_values' => $alias_values,
            'types' => $types,
        ];
    }

    /**
     * Creates a prepared expression based on a ready SQL query and the transmitted data
     *
     * @param string $sql SQL
     * @param array $data Values
     *
     * @return object stmt
     */
    protected function getPrepareStmt(string $sql, array $data)
    {
        $stmt = $this->db_resource->prepare($sql);

        if (!$stmt) {
            throw new ExceptionPrepareData('Ошибка инициализации подготовленного выражения: ');
        }

        $types = $this->getPrepareData($data)['types'];

        $stmt->bind_param($types, ...$data);
        if (!$stmt) {
            throw new ExceptionPrepareData('Не удалось связать подготовленное выражение с параметрами: ');
        }

        return $stmt;
    }
}

// ---------------- SQL --------------------
// -- INSERT INTO users (email, password)
// -- VALUES ('vasya@mail.ru','secret');

// -- SELECT id, email, password FROM users;

// -- SELECT столбцы
// -- FROM таблица
// -- [WHERE условие_фильтрации_строк]
// -- [GROUP BY столбцы_для_группировки]
// -- [HAVING условие_фильтрации_групп]
// -- [ORDER BY столбцы_для_сортировки]

// -- сортировка записей
// -- SELECT * FROM posts ORDER BY view_counter ASC;

// -- чтение по условию
// -- SELECT * FROM users WHERE email = 'anna@mail.ru';
// -- SELECT * FROM users WHERE id IN (2, 4);
// -- SELECT * FROM users WHERE avatar_url LIKE 'user%';

// -- обновление записей
// -- UPDATE users SET user_name = 'Анна В.' WHERE email = 'anna@mail.ru';

// -- объединение записей
// -- SELECT users.user_name, posts.title, posts.view_counter FROM users
// -- JOIN posts ON posts.user_id = users.id
// -- ORDER BY view_counter DESC;

// -- группировка и агрегация
// -- SELECT count(view_counter) FROM posts;
// -- SELECT title, count(*) FROM posts GROUP BY title;

// -- CREATE INDEX c_text ON comments(content);

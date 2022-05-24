<?php
namespace Readme\app\models;

use Readme\app\services\Db;
use Readme\app\exceptions\ExceptionDbConnect;
use Readme\app\exceptions\ExceptionPrepareData;

/**
 * Model is the abstract class for data models.
 *
 */
abstract class Model
{
    protected $db_connect;
    protected $table;

    public function __construct()
    {
        $this->db_connect = Db::instance();
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
    public function findOne(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";

        return $this->fetchAssoc($sql, [$id]);
    }

    /**
     * Retrieves all records from the table
     */
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";

        return $this->db_connect->query($sql);
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

        return $this->db_connect->query($sql);
    }

    /**
     * Gets an entry by id only specified fields
     *
     * @param array $fields Fields of table
     * @param string @id Id of record
     */
    public function findFieldsOne(array $fields, string $id)
    {
        $name_fields = implode(', ', $fields);
        $sql = "SELECT {$name_fields} FROM {$this->table} WHERE id = ?";

        return $this->fetchAssoc($sql, [$id]);
    }

    /**
     * Gets the id of the last record made
     */
    public function getLastId()
    {
        return $this->db_connect->insert_id;
    }

    /**
     * Prepares the data display for the prepared expression
     *
     * @param array $data Data
     * @return array
     */
    protected function getPrepareData(array $data): array
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
        $stmt = $this->db_connect->prepare($sql);

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

    /**
     * Description of fetchAssoc()
     */
    protected function fetchAssoc(string $sql, array $data)
    {
        $stmt = $this->getPrepareStmt($sql, $data);

        if (!$stmt->execute()) {
            throw new ExceptionDbConnect('Ошибка чтения из БД: ');
        }

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Description of fetchAll
     */
    protected function fetchAll(string $sql, array $data)
    {
        $stmt = $this->getPrepareStmt($sql, $data);

        if (!$stmt->execute()) {
            throw new ExceptionDbConnect('Ошибка чтения из БД: ');
        }

        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

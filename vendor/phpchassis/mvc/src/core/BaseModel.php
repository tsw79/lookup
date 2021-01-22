<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 6/19/2019
 * Time: 07:40
 */
namespace phpchassis\mvc\core;

use PDO;
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;
use phpchassis\mvc\db\Connection;
use phpchassis\mvc\db\SqlBuilder;

/**
 * Class BaseModel class manages the data and establish the connection with database
 * @package phpchassis\mvc
 */
abstract class BaseModel implements ModelInterface {

    /**
     * @var PDO
     */
    protected $connection = null;

    /**
     * @var string  Name of current entity's db table
     */
    protected $entityTable;

    /**
     * BaseModel constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection = null) {
        $this->connection = $connection;
    }

    /**
     * Get all the users as an associative array
     * @return array
     */
    public function findAll(string $columns = '*', int $fetchMethod = PDO::FETCH_ASSOC): ?array {

        $sql = SqlBuilder::select($this->entityTable, $columns)->build();
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll($fetchMethod);
    }
}

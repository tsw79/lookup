<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/6/2019
 * Time: 01:06
 */
namespace phpchassis\data\db\search;

/**
 * Class Engine
 *
 *      Note:
 *      -----
 *      The difference between $columns and $mapping is that $columns holds information that will ultimately appear in
 *      an HTML SELECT field (or the equivalent). For security reasons, we do not want to expose the actual names of the
 *      database columns, thus the need for another array $mapping.
 *
 * @package phpchassis\data\db\search
 */
class Engine {

  const ERROR_PREPARE = 'ERROR: unable to prepare statement';
  const ERROR_EXECUTE = 'ERROR: unable to execute statement';
  const ERROR_COLUMN = 'ERROR: column name not on list';
  const ERROR_OPERATOR= 'ERROR: operator not on list';
  const ERROR_INVALID = 'ERROR: invalid search criteria';

  protected $connection;
  protected $table;
  protected $columns;
  protected $mapping;
  protected $statement;
  protected $sql = '';

  /**
   * Supported operators
   * @var array
   */
  protected $operators = [
    'LIKE'     => 'Equals',
    '<'        => 'Less Than',
    '>'        => 'Greater Than',
    '<>'       => 'Not Equals',
    'NOT NULL' => 'Exists',
  ];

  /**
   * Engine constructor.
   * @param Connection $connection
   * @param $table
   * @param array $columns
   * @param array $mapping
   */
  public function __construct(Connect $connection, $table, array $columns, array $mapping) {
    $this->connection = $connection;
    $this->setTable($table);
    $this->setColumns($columns);
    $this->setMapping($mapping);
  }

  /**
   * @param Criteria $criteria
   * @return bool|\Generator
   */
  public function search(Criteria $criteria) {
    if (empty($criteria->key) || empty($criteria->operator)) {
        yield ['error' => self::ERROR_INVALID];
        return false;
    }

    try {
      if (!$statement = $this->buildStatement($criteria)) {
          yield ['error' => self::ERROR_PREPARE];
          return false;
      }

      // Build an array of parameters that will be supplied to execute(). 
      // The key represents the database column name that was used as a placeholder in the prepared statement. 
      //  Note: that instead of using =, we use the LIKE %value% construct.

      $params = array();

      switch ($criteria->operator) {
        case 'NOT NULL' :
          // do nothing: already in statement
          break;
        case 'LIKE' :
          $params[$this->mapping[$criteria->key]] = '%' . $criteria->item . '%';
          break;
        default :
          $params[$this->mapping[$criteria->key]] = $criteria->item;
      }
      $statement->execute($params);
      while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        yield $row;
      }
    }
    catch (Throwable $e) {
      error_log(__METHOD__ . ':' . $e->getMessage());
      throw new Exception(self::ERROR_EXECUTE);
    }
    return true;
  }

  /**
   * @param Criteria $criteria
   * @return mixed
   */
  public function buildStatement(Criteria $criteria) {

    $this->sql = 'SELECT * FROM ' . $this->table . ' WHERE ';
    $this->sql .= $this->mapping[$criteria->key] . ' ';

    switch ($criteria->operator) {
      case 'NOT NULL' :
        $this->sql .= ' IS NOT NULL OR ';
        break;
      default :
        $this->sql .= $criteria->operator
          . ' :'
          . $this->mapping[$criteria->key]
          . ' OR ';
    }

    // Remove any trailing OR keywords and add a clause that causes the result to be sorted
    // according to the search column

    $this->sql = substr($this->sql, 0, -4)
      . ' ORDER BY '
      . $this->mapping[$criteria->key];

    $statement = $this->connection->pdo->prepare($this->sql);
    return $statement;
  }

    // @TODO Getters and Setters here...
}
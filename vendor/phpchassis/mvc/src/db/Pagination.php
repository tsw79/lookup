<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/14/2019
 * Time: 22:55
 */
namespace phpchassis\mvc\db;

/**
 * Class Pagination provides a limited subset of the results of a database query
 * @package php7dev\src\db
 */
class Pagination {

  private const
    DEFAULT_LIMIT = 10,
    DEFAULT_OFFSET = 0;

  /**
   * @var null|string|string[]
   */
  protected $sql;

  /**
   * @var
   */
  protected $page;

  /**
   * @var
   */
  protected $linesPerPage;

  /**
   * Paginate constructor.
   * @param $sql
   * @param $page
   * @param $linesPerPage
   */
  public function __construct($sql, $page, $linesPerPage) {

    // Calculate the offset using the current page number and the number of lines per page.
    $offset = $page * $linesPerPage;

    if ($sql instanceof SqlBuilder) {
      $sql->limit($linesPerPage);
      $sql->offset($offset);
      $this->sql = $sql::build();
    }
    elseif (is_string($sql)) {
      switch (true) {
        case (stripos($sql, 'LIMIT') && strpos($sql, 'OFFSET')):
          // no action needed
          break;
        case (stripos($sql, 'LIMIT')):
          $sql .= ' LIMIT ' . self::DEFAULT_LIMIT;
          break;
        case (stripos($sql, 'OFFSET')):
          $sql .= ' OFFSET ' . self::DEFAULT_OFFSET;
          break;
        default:
          $sql .= ' LIMIT ' . self::DEFAULT_LIMIT;
          $sql .= ' OFFSET ' . self::DEFAULT_OFFSET;
          break;
      }
    }
    $this->sql = preg_replace(
      '/LIMIT \d+.*OFFSET \d+/Ui',
      'LIMIT ' . $linesPerPage . ' OFFSET ' . $offset,
      $sql
    );
  }

  /**
   * @param Connection $connection
   * @param $fetchMode
   * @param array $params
   * @return bool|\Generator
   */
  public function paginate(Connection $connection, $fetchMode, $params = array()) {

    try {
      $stmt = $connection->pdo->prepare($this->sql);
      if (!$stmt) {
        return false;
      }
      ($params) ? $stmt->execute($params) : $stmt->execute();

      while ($result = $stmt->fetch($fetchMode)) {
        yield $result;
      }
    }
    catch (\PDOException $e) {
      error_log($e->getMessage());
      return false;
    }
    catch (\Throwable $e) {
      error_log($e->getMessage());
      return false;
    }
  }

  /**
   * Getter/Setter for sql
   * @param array $results
   * @return array
   */
  public function sql(array $sql = null) {
    if(null === $sql) {
      return $this->sql;
    }
    else {
      $this->sql = $sql;
    }
  }
}
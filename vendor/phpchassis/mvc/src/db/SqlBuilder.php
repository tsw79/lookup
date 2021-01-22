<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/14/2019
 * Time: 05:23
 */
namespace phpchassis\mvc\db;

/**
 * Class SqlBuilder
 * @package php7dev\src\db
 */
class SqlBuilder {

  public const ORDER_ASC  = "ASC";
  public const ORDER_DESC = "DESC";

  private static $instance = null;
  private static $prefix = '';
  private $where = array();
  private $control = ['', '', ''];

  private function __construct() {}

  /**
   * @param string $table
   * @param null $cols
   * @return SqlBuilder
   */
  public static function select(string $table, $cols = null): self {

    self::$instance = new self();

    if ($cols) {
      if (is_array($cols)) {
        // TODO: Get all the values from the array and implode it with a comma
      }
      $prefix = "SELECT {$cols} FROM {$table}";
    }
    else {
      self::$prefix = "SELECT * FROM {$table}";
    }
    return self::$instance;
  }

  /**
   * @param $table
   * @param string $alias
   * @return SqlBuilder
   */
  public static function count($table, $alias = "count"): self {
    self::$instance = new self();
    self::$prefix = "SELECT COUNT(*) AS {$alias} FROM {$table}";
    return self::$instance;

  }

  /**
   * @param null $a
   * @return SqlBuilder
   */
  public function where($a = null): self {
    $this->where[0] = ' WHERE ' . $a;
    return self::$instance;
  }

  /**
   * @param $a
   * @param $b
   * @return SqlBuilder
   */
  public function like($a, $b): self {
    $this->where[] = trim($a . ' LIKE ' . $b);
    return self::$instance;
  }

  /**
   * @param null $a
   * @return SqlBuilder
   */
  public function and($a = null): self {
    $this->where[] = trim('AND ' . $a);
    return self::$instance;
  }

  /**
   * @param null $a
   * @return SqlBuilder
   */
  public function or($a = null): self {
    $this->where[] = trim('OR ' . $a);
    return self::$instance;
  }

  /**
   * @param array $a
   * @return SqlBuilder
   */
  public function in(array $a): self {
    $this->where[] = 'IN ( ' . implode(',', $a) . ' )';
    return self::$instance;
  }

  /**
   * @param null $a
   * @return SqlBuilder
   */
  public function not($a = null): self {
    $this->where[] = trim('NOT ' . $a);
    return self::$instance;
  }

  /**
   * @param $field
   * @param string $order
   * @return SqlBuilder
   */
  public function orderBy(string $field, string $order = self::ORDER_ASC): self {
    $this->control[0] = "ORDER BY {$field} {$order}";
    return self::$instance;
  }

  /**
   * @param $limit
   * @return SqlBuilder
   */
  public function limit($limit): self {
    $this->control[1] = 'LIMIT ' . $limit;
    return self::$instance;
  }

  /**
   * @param $offset
   * @return SqlBuilder
   */
  public function offset($offset): self {
    $this->control[2] = 'OFFSET ' . $offset;
    return self::$instance;
  }

  /**
   * @return string
   */
  public function build(): string {
    
    $sql = self::$prefix
        . implode(' ', $this->where)
        . ' '
        . $this->control[0]
        . ' '
        . $this->control[1]
        . ' '
        . $this->control[2];
    preg_replace('/ /', ' ', $sql);
    return trim($sql);
  }
}
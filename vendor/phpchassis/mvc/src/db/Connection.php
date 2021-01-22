<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/13/2019
 * Time: 11:34
 */
namespace phpchassis\mvc\db;

use PDO;
use Exception;
use PDOException;

/**
 * Class Connection
 * @package phpchassis\mvc\db
 */
class Connection {

  private const ERROR_UNABLE = 'ERROR: Unable to create database connection';

  /**
   * Holds a single instance of Connection
   * @var Connection $instance
   */
  private static $instance = null;

  /**
   * @var PDO
   */
  private static $conn = null;

  /**
   * Returns a Singleton instance of this class - Connection
   * @return Connection|static
   */
  public static function instance() : self {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Returns a PDP instance based on the db config paramater
   * @param array $config
   * @return PDO
   * @throws Exception
   */
  public function getConnection(array $config): PDO {

    if (!isset($config['driver'])) {
      throw new Exception(__METHOD__ . ' : ' . self::ERROR_UNABLE . PHP_EOL);
    }
    $dsn = $config["dsn"] ?? $this->makeDsn($config);

    try {
      self::$conn = new PDO($dsn, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => $config['errmode']]);
      return self::$conn;
    }
    catch (PDOException $e) {
      echo 'Exception Caught: ' . \get_class($e) . ':' . $e->getMessage() . PHP_EOL . '<br>';
      //error_log($e->getMessage());
    }
  }

  /**
   * Constructs a DSN
   * @param array $config
   * @return bool|string
   */
  private function makeDsn(array $config) {
    $dsn = $config['driver'] . ':';
    unset($config['driver']);

    foreach ($config as $key => $value) {
        $dsn .= $key . '=' . $value . ';';
    }
    return \substr($dsn, 0, -1); // remove the last semicolon
  }

  /**
   * Creates a series of PDO instances
   * @param $driver
   * @param $dbname
   * @param $host
   * @param $user
   * @param $pwd
   * @param array $options
   * @return PDO
   */
  public static function factory($driver, $dbname, $host, $user, $pwd, array $options = array()): PDO {
    $dsn = self::makeDsn([
      "driver" => $driver,
      "host"   => $host,
      "dbname" => $dbname,
    ]);

    try {
      return new PDO($dsn, $user, $pwd, $options);
    }
    catch (PDOException $e) {
      echo 'Exception Caught: ' . \get_class($e) . ':' . $e->getMessage() . PHP_EOL . '<br>';
      //error_log($e->getMessage());
    }
  }

  /**
   * DatabaseConnection constructor.
   *  Prevent creating multiple instances due to "private" constructor
   */
  private function __construct() {}

  /**
   * Prevent the instance from being cloned
   */
  private function __clone() {}

  /**
   * Prevent from being unserialized
   */
  private function __wakeup () {}
}
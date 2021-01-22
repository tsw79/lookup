<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/15/2019
 * Time: 18:31
 */
namespace php7dev\src\error;

use PDO;

/**
 * Class ThrowsExceptionTest
 * @package php7dev\src\error
 */
class ThrowsExceptionTest {

  /**
   * @var
   */
  protected $result;

  /**
   * ThrowsExceptionTest constructor.
   * @param array $config
   */
  public function __construct(array $config) {

    $dsn = $config['driver'] . ':';
    unset($config['driver']);

    foreach ($config as $key => $value) {
        $dsn .= $key . '=' . $value . ';';
    }
    $pdo = new PDO(
        $dsn,
        $config['user'],
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $stmt = $pdo->query('This Is Not SQL');

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $this->result[] = $row;
    }
  }
}
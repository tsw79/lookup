<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/15/2019
 * Time: 20:05
 */
namespace php7dev\src\error;

/**
 * Class ThrowsErrorTest
 * @package php7dev\src\error
 */
class ThrowsErrorTest {

  const NOT_PARSE = 'this will not parse';

  /**
   *
   */
  public function divideByZero() {
    $this->zero = 1 / 0;
  }

  /**
   *
   */
  public function willNotParse() {
    eval(self::NOT_PARSE);
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 20/1/2021
 * Time: 07:44
 */
namespace phpchassis\lib\traits;

/**
 * Class ArrayUtil
 * @package phpchassis\lib\traits
 */
trait ArrayUtil {

  /**
   * Converts an array to an object recursively.
   * @param string $urlEnd
   * @return string
   */
  public static function toObject(array $data): object {
    foreach ($data as $key => $value) {
      if(is_array($value)) {
        $data[$key] = self::toObject($value);
      }
    }
    return (object) $data;
  }
}
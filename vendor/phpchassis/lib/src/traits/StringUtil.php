<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/24/2019
 * Time: 12:16
 */
namespace phpchassis\lib\traits;

/**
 * Class StringUtil
 * @package phpchassis\src\lib\traits
 */
trait StringUtil {

  /**
   * Convert the string with hyphens to StudlyCaps,
   *      E.g.    post-authors => PostAuthors
   *
   * @param string $string
   * @return string
   */
  public static function toStudlyCaps($string) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /**
   * Convert the string with hyphens to camelCase,
   *      E.g.    add-new => addNew
   *
   * @param string $string The string to convert
   * @return string
   */
  public static function toCamelCase($string) {
    return lcfirst(self::toStudlyCaps($string));
  }

  /**
   * Trims the end part of a string to an ellipses (...)
   * @param string $str       // The string that needs to be trimmed
   * @param int $charLimit    // The number of characters the string will be trimmed to
   * @return string
   */
  public function trimToEllipses(string $str, int $charLimit = 100) {
    $dots = strlen($str) > $charLimit ? " ..." : "";
    return substr($str, 0, $charLimit) . $dots;
  }
}
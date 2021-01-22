<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 9/2/2019
 * Time: 09:19
 */
namespace phpchassis\lib\traits;

/**
 * Class Url
 * @package phpchassis\lib\traits
 */
trait Url {

  /**
   * Returns a URL based on the given parameters.
   * @param string $urlEnd
   * @return string
   */
  public static function to(string $urlEnd, array $querystring = null): string {
    $qryStr = (null !== $querystring) ? "?" . http_build_query($querystring) : '';
    return $urlEnd . ".php" . $qryStr;  //return ROOT_URL . $urlEnd . ".php";
  }

  /**
   * Remembers the specified URL so that it can be later fetched back by [[previous()]].
   * @param string $url
   * @param null $name
   */
  public static function remember($url = '', $name = null) {

  }

  /**
   * Creates a URL by using the current route and the GET parameters.
   * @param array $params
   * @param bool $scheme
   */
  public static function current(array $params = [], $scheme = false) {

  }

  /**
   * Returns the URL previously [[remember()|remembered]].
   * @param null $name
   */
  public static function previous($name = null) {

  }

  /**
   * Returns the canonical URL of the currently requested page.
   *  The canonical URL is constructed using the current controller's [[\yii\web\Controller::route]] and [[\yii\web\Controller::actionParams]].
   */
  public static function canonical() {

  }

  /**
   * Returns the home URL.
   * @param bool $scheme
   */
  public static function home($scheme = false) {

  }

  /**
   * Returns a value indicating whether a URL is relative.
   * A relative URL does not have host info part.
   * @param string $url the URL to be checked
   * @return boolean whether the URL is relative
   */
  public static function isRelative($url): bool {
    return strncmp($url, '//', 2) && strpos($url, '://') === false;
  }
}
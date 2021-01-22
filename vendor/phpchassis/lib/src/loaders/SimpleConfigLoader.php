<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/16/2019
 * Time: 14:19
 */
namespace phpchassis\lib\loaders;

/**
 * Class SimpleConfigLoader
 * @package phpchassis\config
 */
class SimpleConfigLoader {

  /**
   * Holds a single instance of ConfigLoader
   * @var ConfigLoader $instance
   */
  private static $instance = null;

  /**
   * List of Configuration settings
   * @var array
   */
  private $settings = array();

  /**
   * Returns a Singleton instance of this class
   * @return ConfigLoader|static
   */
  public static function instance() : self {
    if (null === self::$instance) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Returns the value of a given alias
   * @param string $aliasId
   * @return string
   */
  public function alias(string $aliasId): string {
    return $this->settings["aliases"][$aliasId];
  }

  /**
   * Returns the config settings for routes
   * @return array
   */
  public function routes(): array {
    return $this->settings["routes"];
  }

  /**
   * Returns a list of database settings
   * @return array
   */
  public function db(): array {
    return $this->settings["db"][ENV];
  }

  /**
   * @param string|null $key
   * @return mixed
   */
  public function autoload(string $key = null) {
    if (null !== $key) {
      return $this->settings["autoload"][$key];
    }
    return $this->settings["autoload"];
  }

  /**
   * Gets the search results config for a given (search) type
   * @param string|null $type
   * @return mixed
   */
  public function searchResults(string $type = null) {
    if (null !== $type) {
      return $this->settings["search.results"][$type];
    }
    return $this->settings["search.results"];
  }

  /**
   * @param array $settings
   */
  public function set(array $settings): void {
    $this->settings = $settings;
  }

  /**
   * @param string|null $key
   * @return array|mixed
   */
  public function get(string $key = null) {
    if (null !== $key) {
      return $this->settings[$key];
    }
    return $this->settings;
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
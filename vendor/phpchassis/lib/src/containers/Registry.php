<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/29/2019
 * Time: 15:29
 */
namespace phpchassis\lib\containers;

/**
 * Class Registry
 * @package phpchassis\lib
 */
class Registry {

  /**
   * @var Registry
   */
  protected static $instance = null;

  /**
   * @var array
   */
  protected $registry = array();

  /**
   * @return Registry
   */
  public static function instance(): self {
    if (!self::$instance) {
        self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Gets an object from the registry
   * @param string $key
   * @return mixed|null
   */
  public function get(string $key) {
    return $this->registry[$key] ?? null;
  }

  /**
   * Sets an object in the registry.
   *  This method allows graceful behavior based on the $graceful parameter; otherwise, it triggers the
   *  RuntimeException for the existing key.
   *
   * @param string $key
   * @param $value
   * @param bool $graceful
   */
  public function set(string $key, $value, bool $graceful = false) {
    if ($this->has($key)) {
      if ($graceful) {
          return;
      }
      throw new \RuntimeException("Registry key '{$key}' already exists");
    }
    $this->registry[$key] = $value;
  }

  /**
   * Returns true if a given key exists in the registry. Otherwise, it returns false.
   * @param string $key
   * @return bool
   */
  public function has(string $key): bool {
    return array_key_exists($this->registry[$key]);
  }

  /**
   * Returns true if the given key was removed successfully. Otherwise, it returns false.
   * @param string $key
   * @return bool
   */
  public function remove(string $key): bool {
    if ($this->has($key)) {
      unset($this->registry[$key]);
      return true;
    }
    return false;
  }

  /**
   * Returns a formatted output of objects currently in the register
   * @return array|null
   */
  public function classProperties(): ?array {
    return get_object_vars($this);
  }

  /**
   *  Prevent creating multiple instances due to "private" constructor
   */
  private function __construct() {}

  /**
   * Destruct method
   */
  private function __destruct() {
    $keys = array_keys($this->registry);
    array_walk($keys, [$this, 'remove']);
  }

  /**
   * Prevent the instance from being cloned
   */
  private function __clone() {}

  /**
   * Sleep method for serialization of the registry
   */
  private function __sleep() {
    $this->registry = serialize($this->registry);
  }

  /**
   * Wake method for unserialization of the registry
   */
  private function __wakeup () {
    $this->registry = unserialize($this->registry);
  }
}
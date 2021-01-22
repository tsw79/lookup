<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 6/18/2019
 * Time: 06:15
 */
namespace phpchassis\filter;

/**
 * Class BaseFilter
 * @package phpchassis\filter
 */
abstract class BaseFilter {

  const BAD_CALLBACK = "Must implement CallbackInterface";
  const DEFAULT_SEPARATOR = "<br>" . PHP_EOL;
  const MISSING_MESSAGE_KEY = "item.missing";
  const DEFAULT_MESSAGE_FORMAT = "%20s : %60s";
  const DEFAULT_MISSING_MESSAGE = "Item Missing";

  /**
   * Used for message display in conjunction with filtering and validation messages
   * @var string
   */
  protected $separator;

  /**
   * @var string
   */
  protected $missingMessage;

  /**
   * Represents the array of callbacks that perform filtering and validation
   * @var array
   */
  protected $callbacks;

  /**
   * Maps data fields to filters and/or validators
   * @var array
   */
  protected $assignments;

  /**
   * Populated by the filtering or validation operation
   * @var array (Result)
   */
  protected $results = array();

  /**
   * AbstractFilter constructor.
   * @param array $callbacks
   * @param array $assignments
   * @param null $separator
   * @param null $message
   */
  public function __construct(array $callbacks, array $assignments, $separator = null, $message = null) {
    $this->callbacks($callbacks);
    $this->assignments($assignments);
    $this->separator($separator ?? self::DEFAULT_SEPARATOR);
    $this->missingMessage($message ?? self::DEFAULT_MISSING_MESSAGE);
  }

  /**
   * @param $key
   * @return mixed|null
   */
  public function getOneCallback($key) {
    return $this->callbacks[$key] ?? null;
  }

  public function hasCallback($key): bool {
    return true === isset($this->callbacks[$key]);
  }

  /**
   * Checks to see if the callback implements CallbackInterface
   * @param $key
   * @param $item
   */
  public function setOneCallback($key, $item) {
    if ($item instanceof CallbackInterface) {
        $this->callbacks[$key] = $item;
    }
    else {
        throw new \UnexpectedValueException(self::BAD_CALLBACK);
    }
  }

  /**
   * @param $key
   */
  public function removeOneCallback($key) {
    if (isset($this->callbacks[$key])) {
        unset($this->callbacks[$key]);
    }
  }

  /**
   * @return array
   */
  public function getItemsAsArray(): array {

    $return = array();
    if ($this->results) {
      foreach ($this->results as $key => $item) {
          $return[$key] = $item->getItem();
      }
    }
    return $return;
  }

  /**
   * @return array|\Generator
   */
  public function getMessages() {
    if ($this->results) {
      foreach ($this->results as $key => $item) {
        if ($item->getMessages()) {
            yield from $item->getMessages();
        }
      }
    }
    else {
      return array();
    }
  }

  /**
   * @param int $width
   * @param null $format
   * @return string
   */
  public function getMessageString($width = 80, $format = null) {

    if (!$format) {
        $format = self::DEFAULT_MESSAGE_FORMAT . $this->separator;
    }
    $output = '';

    if ($this->results) {
      foreach ($this->results as $key => $value) {
        $messages = $value->getMessages();
        if ($messages) {
          foreach ($messages as $message) {
              $output .= sprintf( $format, $key, trim($message) );
          }
        }
      }
    }
    return $output;
  }

  /**
   * @return mixed
   */
  public function getSeparator(): string {
    return $this->separator;
  }

  /**
   * @param mixed $separator
   */
  public function setSeparator(string $separator): void {
    $this->separator = $separator;
  }

  /**
   * @return mixed
   */
  public function getMissingMessage(): string {
    return $this->missingMessage;
  }

  /**
   * @param string $missingMessage
   */
  public function setMissingMessage(string $missingMessage): void {
    $this->missingMessage = $missingMessage;
  }

  /**
   * @return array
   */
  public function getCallbacks(): array {
    return $this->callbacks;
  }

  /**
   * @param array $callbacks
   */
  public function setCallbacks(array $callbacks): void {
    $this->callbacks = $callbacks;
  }

  /**
   * @return array
   */
  public function getAssignments(): array {
    return $this->assignments;
  }

  /**
   * @param array $assignments
   */
  public function setAssignments(array $assignments): void {
    $this->assignments = $assignments;
  }

  /**
   * @return array
   */
  public function getResults(): array {
    return $this->results;
  }

  /**
   * @param array $results
   */
  public function setResults(array $results): void {
    $this->results = $results;
  }
}
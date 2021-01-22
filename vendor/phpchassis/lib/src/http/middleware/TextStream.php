<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 4/11/2019
 * Time: 01:15
 */
declare(strict_types=1);
namespace phpchassis\lib\http\middleware;

use Throwable;
use RuntimeException;
use SplFileInfo;
use Psr\Http\Message\StreamInterface;

/**
 * Class TextStream
 *  This class is designed for situations where the body is a string (that is, an array encoded as JSON) rather than a
 *  file. As we need to make absolutely certain that the incoming $input value is of the string data type, we invoke
 *  PHP 7 strict types just after the opening tag. We also identify a $pos property (that is, position) that will
 *  emulate a file pointer, but instead point to a position within the string.
 *
 * @package PhpChassis\middleware
 */
class TextStream implements StreamInterface {

  /**
   * @var $stream
   */
  protected $stream;

  /**
   * @var int $pos
   */
  protected $pos = 0;

  /**
   * TextStream constructor.
   * @param string $input
   */
  public function __construct(string $input) {
    $this->stream = $input;
  }

  /**
   * @return string
   */
  public function getStream() {
    return $this->stream;
  }

  /**
   * @return null
   */
  public function getInfo() {
    return null;
  }

  /**
   * @return string
   */
  public function getContents() {
    return $this->stream;
  }

  /**
   * @return string
   */
  public function __toString() {
    return $this->getContents();
  }

  /**
   * @return int|null
   */
  public function getSize() {
    return strlen($this->stream);
  }

  /**
   * Close
   */
  public function close() {
    // do nothing: how can you "close" string???
  }

  /**
   * @return null|resource|void
   */
  public function detach() {
    return $this->close();  // that is, do nothing!
  }

  /**
   * This method emulates streaming behavior
   * @return int
   */
  public function tell() {
    return $this->pos;
  }

  /**
   * This method emulates streaming behavior
   * @return bool
   */
  public function eof() {
    return ($this->pos == strlen($this->stream));
  }

  /**
   * @return bool
   */
  public function isSeekable() {
    return true;
  }

  /**
   * This method emulates streaming behavior
   * @param int $offset
   * @param null $whence
   */
  public function seek($offset, $whence = NULL) {
    if ($offset < $this->getSize()) {
      $this->pos = $offset;
    }
    else {
      throw new RuntimeException(Constants::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Rewind
   */
  public function rewind() {
    $this->pos = 0;
  }

  /**
   * @return bool
   */
  public function isWritable() {
    return true;
  }

  /**
   * @param string $string
   * @return int|void
   */
  public function write($string) {
    $temp = substr($this->stream, 0, $this->pos);
    $this->stream = $temp . $string;
    $this->pos = strlen($this->stream);
  }

  /**
   * @return bool
   */
  public function isReadable() {
    return true;
  }

  /**
   * @param int $length
   * @return bool|string
   */
  public function read($length) {
    return substr($this->stream, $this->pos, $length);
  }

  /**
   * @param null $key
   * @return array|mixed|null
   */
  public function getMetadata($key = null) {
    return null;
  }
}
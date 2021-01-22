<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 4/11/2019
 * Time: 00:58
 */
namespace phpchassis\lib\http\middleware;

use SplFileInfo;
use Throwable;
use RuntimeException;
use Psr\Http\Message\StreamInterface;

/**
 * Class Stream
 *  This class represents the body of the (http) message - incoming or outgoing requests and/or responses.
 *
 *  As it is not known how large the body might be, PSR-7 recommends that the body should be treated as a stream.
 *  A stream is a resource that allows access to input and output sources in a linear fashion. In PHP, all file commands
 *  operate on top of the Streams sub-system, so this is a natural fit. PSR-7 formalizes this by way of
 *  Psr\Http\Message\StreamInterface that defines such methods as read(), write(), seek(), and so on.
 *
 * @package phpchassis-ddd\middleware
 */
class Stream implements StreamInterface {

  /**
   * @var $stream
   */
  protected $stream;

  /**
   * @var $metadata
   */
  protected $metadata;

  /**
   * @var SplFileInfo $info
   */
  protected $info;

  /**
   * Stream constructor.
   *  We open the stream using a simple fopen() command. We then use stream_get_meta_data() to get information
   *  on the stream. For other details, we create an SplFileInfo instance.
   *      The reason why we chose fopen() over the more modern SplFileObject is that the latter does not allow direct
   *      access to the inner file resource object, and is therefore useless for this application.
   *
   * @param $input
   * @param $mode
   */
  public function __construct($input, $mode = self::MODE_READ) {
    $this->stream = fopen($input, $mode);
    $this->metadata = stream_get_meta_data($this->stream);
    $this->info = new SplFileInfo($input);
  }

  /**
   * @return bool|resource
   */
  public function getStream() {
    return $this->stream;
  }

  /**
   * @return SplFileInfo
   */
  public function getInfo() {
    return $this->info;
  }

  /**
   * Low-level core streaming method: Read
   * @param int $length
   * @return string|void
   */
  public function read($length) {
    if (!fread($this->stream, $length)) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Low-level core streaming method: Write
   * @param string $string
   * @return int|void
   */
  public function write($string) {
    if (!fwrite($this->stream, $string)) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Low-level core streaming method: Rewind
   */
  public function rewind() {
    if (!rewind($this->stream)) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Low-level core streaming method: End of file
   * @return mixed
   */
  public function eof() {
    return eof($this->stream);
  }

  /**
   * Low-level core streaming method: Tell
   * @return mixed
   */
  public function tell() {
    try {
      return ftell($this->stream);
    }
    catch (Throwable $e) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Low-level core streaming method: Seek
   * @param int $offset
   * @param int $whence
   */
  public function seek($offset, $whence = SEEK_SET) {
    try {
      fseek($this->stream, $offset, $whence);
    }
    catch (Throwable $e) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
  }

  /**
   * Low-level core streaming method: Close
   */
  public function close() {
    if ($this->stream) {
      fclose($this->stream);
    }
  }

  /**
   * Low-level core streaming method: Detach
   */
  public function detach() {
    return $this->close();
  }

  /**
   * Information method that tells us about the stream: getMetadata
   *
   * @param null $key
   * @return null
   */
  public function getMetadata($key = null) {
    if ($key) {
      return $this->metadata[$key] ?? null;
    }
    else {
      return $this->metadata;
    }
  }

  /**
   * Information method that tells us about the stream: getSize
   *
   * @return int
   */
  public function getSize() {
    return $this->info->getSize();
  }

  /**
   * Information method that tells us about the stream: isSeekable
   *
   * @return mixed
   */
  public function isSeekable() {
    return boolval($this->metadata['seekable']);
  }

  /**
   * Information method that tells us about the stream: isWritable
   *
   * @return mixed
   */
  public function isWritable() {
    return $this->stream->isWritable();
  }

  /**
   * Information method that tells us about the stream: isReadable
   *
   * @return bool
   */
  public function isReadable() {
    return $this->info->isReadable();
  }

  /**
   * Following PSR-7 guidelines, we then define getContents() and __toString() in order to dump the contents of the stream.
   * @return string
   */
  public function __toString() {
    $this->rewind();
    return $this->getContents();
  }

  /**
   * Returns the contents
   * @return mixed
   */
  public function getContents() {

    ob_start();
    if (!fpassthru($this->stream)) {
      throw new RuntimeException(self::ERROR_BAD . __METHOD__);
    }
    return ob_get_clean();
  }
}
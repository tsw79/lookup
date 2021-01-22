<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/15/2019
 * Time: 18:23
 */
namespace phpchassis\mvc\error;

/**
 * Class Handler
 * @package phpchassis\error
 */
class Handler {

  /**
   * @var mixed
   */
  protected $logFile;

  /**
   * Handler constructor.
   * @param string $logFileDir
   * @param string $logFile
   */
  public function __construct(string $logFileDir = null, string $logFile = null) {

    $logFile = $logFile ?? date('Ymd') . '.log';
    $logFileDir = $logFileDir ?? __DIR__;
    $this->logFile = $logFileDir . '/' . $logFile;
    $this->logFile = str_replace('//', '/', $this->logFile);

    set_exception_handler([$this,'exceptionHandler']);  // Sets the universal exception handler
    set_error_handler([$this, 'errorHandler']);         // Sets the universal error handler
  }

  /**
   * Sets up the error and exception handlers
   * @param string|null $logFileDir
   * @param string|null $logFile
   */
  public static function setup(string $logFileDir = null, string $logFile = null): void {
    new self($logFileDir, $logFile);
  }

  /**
   * Error handler
   * @param $errno
   * @param $errstr
   * @param $errfile
   * @param $errline
   */
  public function errorHandler($errno, $errstr, $errfile, $errline) {
    $message = sprintf(
        'ERR: %s : %d : %s : %s : %s' . PHP_EOL,
        date('Y-m-d H:i:s'), $errno, $errstr, $errfile, $errline
    );
    file_put_contents($this->logFile, $message, FILE_APPEND);
  }

  /**
   * Exception handler
   * @param $ex
   */
  public function exceptionHandler($exception) {
    $message = sprintf(
        'EXC: %19s : %20s : %s' . PHP_EOL,
        date('Y-m-d H:i:s'), get_class($exception), $exception->getMessage()
    );
    file_put_contents($this->logFile, $message, FILE_APPEND);

    echo "<h1>Fatal error</h1>";
    echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
    echo "<p>Message: '" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
  }
}
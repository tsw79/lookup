<?php
/**
 * User: tharwat
 */
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;

/**
 * Class AutoLoader automatically includes classes
 */
class AutoLoader {

  private const UNABLE_TO_LOAD = "Unable to load: ";

  /**
   * @var array
   */
  private $directories = array();

  /**
   * Register our autoload() method as a Standard PHP Library (SPL) autoloader
   *
   *      Note:
   *      -----
   *      spl_autoload_register(__CLASS__ . '::autoLoad');  ...can be used for a static call
   */
  public function register() {
    spl_autoload_register([$this, 'autoLoad']);
  }

  /**
   * Locates the file based on the namespaced classname.
   *  This method derives a filename by converting the PHP namespace separator \ into the directory separator
   *  appropriate for this server and appending .php
   *
   * @param $class
   * @return bool
   * @throws Exception
   */
  public function autoLoad($class) {

    $success = false;
    $filename = $class . '.php';

    /*
     * #1.  Try and load the file by searching in the autoloaded directories
     */

    foreach ($this->directories as $start) {
      $file = "{$start}/{$filename}";
      if ($this->loadFile($file)) {
        $success = true;
        break;
      }
    }

    if (!$success) {

      /*
       * #2.  Try and load the file by searching the aliases
       *  Note: Here, we only search the Vendor directory!
       */

      $namespaces = ConfigLoader::instance()->autoload("namespaces");
      $namespaceParts = explode("\\", $filename);         // Extract the file into different parts
      $size = count($namespaceParts);                     // Get the size of the parts array

      foreach ($namespaceParts as $key => $part) {
        unset($namespaceParts[--$size]);
        $namespaceKey = implode("\\", $namespaceParts);

        if (array_key_exists($namespaceKey, $namespaces)) {
          $namespacePath =  $namespaces[$namespaceKey];
          $actualFilePath = str_replace("\\", '/',
              str_replace($namespaceKey, $namespacePath, $filename)
          );
          $success = $this->loadFile(VENDOR_DIR . "/{$actualFilePath}");
          $success = $success ? : $this->loadFile(ROOT_DIR . "/{$actualFilePath}");
          break;
        }
      }

      /*
       * #3.  Default, try and search the current directory
       */
      if (!$success) {
        if (!$this->loadFile(__DIR__ . "/{$filename}")) {
          throw new \Exception(self::UNABLE_TO_LOAD . ' ' . $class);
        }
      }
    }
    return $success;
  }

  /**
   * Loads a file
   *  We use file_exists() to check before running require_once(). The reason for this is that if the file is not
   *  found, require_once() will generate a fatal error that cannot be caught using PHP 7's new error handling
   *  capabilities. In this way, we can then test the return value of loadFile() in the calling program and loop
   *  through a list of alternate directories before throwing an Exception if it's ultimately unable to load the file.
   *
   * @param $file
   * @return bool
   */
  protected function loadFile($file): bool {
    if (file_exists($file)) {
      require_once $file;
      return true;
    }
    return false;
  }

  /**
   * Adds a directory to the list of directories
   * @param string $dir
   * @return $this
   */
  public function addDirectory(string $dir) {
    $this->directories[] = $dir;
    return $this;
  }

  /**
   * Merges a list of directories with this class's list of directories
   * @param array $dirs
   * @return $this
   */
  public function addDirectories(array $dirs) {
    $this->directories = array_merge($this->directories, $dirs);
    return $this;
  }

  /**
   * Unregisters the autoload callback with the SPL autoload system.
   */
  public function unregister() {
    spl_autoload_unregister([$this, 'autoLoad']);
  }

  public function __destruct() {
    $this->unregister();
  }

  /**
   * Getter/Setter for directories
   * @param array $dirs
   * @return AutoLoader|array
   */
  public function directories(array $dirs = null) {
    if(null === $dirs) {
      return $this->directories;
    }
    else {
      $this->directories = $dirs;
      return $this;
    }
  }
}

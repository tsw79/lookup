<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/16/2019
 * Time: 11:52
 */
require (__DIR__ . '/../../../lib/src/loaders/SimpleConfigLoader.php');

use phpchassis\mvc\error\Handler;
use phpchassis\mvc\core\Router;
use phpchassis\lib\http\middleware\ServerRequest;
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;

/**
 * Class BootLoader
 */
class Application {

  /**
   * @var array
   */
  private $settings;

  /**
   * @var Router
   */
  private $router = null;

  /**
   * Application constructor.
   */
  public function __construct(array $settings) {
      $this->settings = $settings;
  }

  /**
   * Boots up the application
   */
  public function boot(): void {

    ConfigLoader::instance()->set($this->settings);

    $autoloadDirs = ConfigLoader::instance()->autoload("dirs");
    $routingConf = ConfigLoader::instance()->routes();

    // Register the autoloader
    (new AutoLoader())->addDirectories($autoloadDirs)->register();

    // Set up the error and exception handler
    Handler::setup(RUNTIME_DIR . "/logs/", "error.log"); // @TODO NEed to get this from the ConfigLoader!

    $this->router = new Router(
        (new ServerRequest())->initialize(),
        SRC_DIR,
        $routingConf
    );

    //$requestUri = $this->request->getServerParam('REQUEST_URI_FULL');
    //$this->request->withRequestTarget($requestUri);
  }

  /**
   * Starts the application
   */
  public function run(): void {
    $this->router->dispatch();
  }

  /**
   * Returns a string representing the current version of the PhpChassis-MVC framework.
   * @return string
   */
  public static function version(): string {
    return '0.1';
  }

  /**
   * Returns a string representing the name of the framework.
   * @return string
   */
  public static function poweredBy() {
    return '<a href="http://www.phpchassis.com/mvc" rel="external">PhpChassis MVC</a>';
  }
}
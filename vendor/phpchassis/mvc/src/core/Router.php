<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/5/2019
 * Time: 06:38
 */
namespace phpchassis\mvc\core;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Router
 *  Routing by dissecting the URL into its component parts, and then
 *  making a determination as to which class and method should be dispatched. The advantage of such an implementation is
 *  that not only can you make your URLs Search Engine Optimization (SEO)-friendly, but you can also create rules,
 *  incorporating regular expression patterns, which can extract values of parameters.
 *
 * @package phpchassis\routing
 */
class Router {

  // private const DEFAULT_MATCH = 'default';
  private const ERROR_NO_DEF = 'ERROR: must supply a default match';

  /**
   * @var ServerRequestInterface
   */
  protected $request;

  /**
   * @var
   */
  protected $requestUri;

  /**
   * @var array
   */
  protected $uriParts;

  /**
   * @var
   */
  protected $docRoot;

  /**
   * @var
   */
  protected $config;

  /**
   * @var
   */
  protected $routeMatch;

  /**
   * Router constructor.
   * @param ServerRequestInterface $request
   * @param $docRoot
   * @param $config
   */
  public function __construct(ServerRequestInterface $request, $docRoot, $config) {
    $this->config = $config;
    $this->docRoot = $docRoot;
    $this->request = $request;
    $this->requestUri = $request->getServerParams()['REQUEST_URI'];         
    $this->uriParts = explode('/', $this->requestUri);

    if (!isset($config['default'])) {
      throw new \InvalidArgumentException(self::ERROR_NO_DEF);
    }
  }

  /**
   * Determines whether we are trying to match against a CSS, JavaScript, or graphic request (among other possibilities)
   * @return mixed|string
   */
  public function isFileOrDir() {
    $fn = $this->docRoot . '/' . $this->requestUri;
    $fn = str_replace('//', '/', $fn);
    return file_exists($fn) ? $fn : '';
  }

  /**
   * Searches for a match.
   *  It iterates through the configuration array and runs the uri parameter through preg_match(). If positive, the
   *  configuration key and $matches array populated by preg_match() are stored in $routeMatch, and the callback is
   *  returned. If there is no match, the default callback is returned.
   *
   * @return mixed
   */
  public function match() {

    foreach ($this->config as $key => $route) {

      if (preg_match($route['pattern'], $this->requestUri, $matches)) {
        $this->routeMatch['key'] = $key;
        $this->routeMatch['match'] = $matches;
        return $route['exec'];
      }
    }
    return $this->config["default"]["exec"];
  }

  /**
   * Dispatches the route, creating the controller object and running the action method
   */
  public function dispatch() {

    $execute = $this->match();
    $params = $this->routeMatch['match'];

    // Check to see whether the request is a file or directory, and also whether the route match is /:
    // if ($fn = $this->router->isFileOrDir() && $this->router->getRequest()->getUri()->getPath() != '/') {
    //     return false;
    // }
    // else {
    //     include PAGE_DIR . '/main.php';
    // }

    $execute($params);
  }

  /**
   * Getter/Setter for request
   * @param null $request
   * @return string
   */
  public function request($request = null) {
    if($request === null) {
      return $this->request;
    }
    else {
      $this->request = $request;
    }
  }

  /**
   * Getter/Setter for docRoot
   * @param null $docRoot
   * @return string
   */
  public function docRoot($docRoot = null) {
    if($docRoot === null) {
      return $this->docRoot;
    }
    else {
      $this->docRoot = $docRoot;
    }
  }

  /**
   * Getter/Setter for routeMatch
   * @param null $routeMatch
   * @return string
   */
  public function routeMatch($routeMatch = null) {
    if($routeMatch === null) {
      return $this->routeMatch;
    }
    else {
      $this->routeMatch = $routeMatch;
    }
  }
}
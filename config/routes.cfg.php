<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/17/2019
 * Time: 13:15
 */
define("VIEWS_DIR", SRC_DIR . "/views");

return [

  /*
    * (any) page config
    *
    * Controller|Action|Querystring (optinal)   -> e.g.,
    *      user/index.php?user_id=4&pid=5  results in...
    *        array(
    *          0	=>	user/index.php?user_id=4&pid=5
    *          1	=>	user
    *          2	=>	index
    *          3	=>	user_id=4&pid=5     <-- Optional
    *        );
    */
  'page' => [
    /*
      *  ([\w]+)         - Name of Controller
      *  ([\w]+).php     - Name of action (must have extension name .php)
      *  ?\?(.*)?        - OPTIONAL: Querystring
      *                      Note:  \?
      *                          1) Must have a question mark after .php
      *                          2) Extracts querystring without the question mark.
      */
    'pattern' => '/^\/([\w]+)\/([\w]+).php\??(.*)?$/',
    /**
     * @param array $matches [
     *      0 => Uri
     *      1 => Controller
     *      2 => Action
     *      3 => Querystring    <-- OPTIONAL
     * ]
     */
    'exec'    => function ($matches) {
      $controller = "\\lookup\\controllers\\" . ucfirst($matches[1]) . "Controller";
      $model = "\\lookup\\models\\" . ucfirst($matches[1]) . "Model";
      $action = $matches[2];
      $params = null;

      if (null != $action) {
        parse_str($matches[3], $params);
      }

      (new $controller(new $model()))->$action($params);
    }
  ],

  /*
    * site page config (for static pages)
    *
    * 'site'|action
    */
  'site' => [
    /*
      *  \/(site)                - Must have the wording 'site' in it
      *  \/([\w]+|[\w]+.php)     - Matches action or action.php
      */
    'pattern' => '/^\/(site)\/([\w]+|[\w]+.php)$/',
    /**
     * @param array $matches [
     *      0 => Uri
     *      1 => Controller
     *      2 => Action
     * ]
     */
    'exec'    => function ($matches) {
      $action = $matches[2];
      if (method_exists(\lookup\controllers\SiteController::class, $action)) {
        (new \lookup\controllers\SiteController(null))->$action();
      }
    }
  ],

  /*
    * home page config
    */
  'home' => [
    'pattern' => '/^(\/$|\/index$|\/index.php$|\/site$)$/',
    /**
     *
     */
    'exec'    => function ($matches) {
      if (method_exists(\lookup\controllers\SiteController::class, "index")) {
        (new \lookup\controllers\SiteController(null))->index();
      }
    }
  ],

  /*
    * default page config
    */
  'default' => [
    'pattern' => '/^.\*$/',
    'exec'    => function ($matches) {
      include SRC_DIR . "/views/site/sorry.php";
    }
  ],
];

//        $cai =  '/^([\w]+)\/([\w]+)\/([\d]+).*$/';  //  controller/action/id
//        $ci =   '/^([\w]+)\/([\d]+).*$/';           //  controller/id
//        $ca =   '/^([\w]+)\/([\w]+).*$/';           //  controller/action
//        $c =    '/^([\w]+).*$/';                    //  action
//        $i =    '/^([\d]+).*$/';                    //  id
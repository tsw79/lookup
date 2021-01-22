<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/30/2019
 * Time: 00:51
 *
 * This file bootstraps the application by setting all relevant paths and directories, and include all main files and
 * classes.
 */

// This is a security check! Ensures that the end-user is not attempting to access this file directly from the browser.
if (!defined("ROOT_DIR")) {
  die("Direct Access is PROHIBITED!!");
}

ob_start();

/* -----
 * NOTE:
 * -----
 * Comment out the following two lines when deployed to production
 */
defined('DEBUG') or define('DEBUG', true);
defined('ENV') or define('ENV', 'dev');

define("ROOT_URL", $_SERVER["HTTP_HOST"]);
define("WEB_ROOT", ROOT_URL . "/web");
define("RUNTIME_DIR", ROOT_DIR . "/runtime");
define("SRC_DIR", ROOT_DIR . "/src");
define("VENDOR_DIR", ROOT_DIR . "/vendor");
define("PHPCHASSIS", ROOT_DIR . "/vendor/phpchassis/mvc/src");

require_once(PHPCHASSIS . "/bootstrap/AutoLoader.php");
require_once(PHPCHASSIS . "/bootstrap/Application.php");

$settings = require(ROOT_DIR . '/config/application.cfg.php');
$application = new Application($settings);
$application->boot();
$application->run();
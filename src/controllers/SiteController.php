<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 6/19/2019
 * Time: 07:40
 */
namespace lookup\controllers;

/**
 * SiteController
 *  This controller only holds static pages hence no model
 * @package controllers
 */
class SiteController extends Controller {

  /**
   * Default action
   * @action index
   */
  public function index() {
    $data["title"] = "PhpChassis - Simple MVC framework - Home";
    $this->render("site/index", $data);
  }

  /**
   * @action aboutUs
   */
  public function aboutUs() {
    $data["title"] = "PhpChassis - Simple MVC framework - About Us";
    $this->render("site/aboutUs", $data);
  }
}

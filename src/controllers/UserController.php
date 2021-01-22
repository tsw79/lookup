<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/21/2019
 * Time: 20:50
 */
namespace lookup\controllers;

/**
 * Class UserController
 * @package controllers
 */
class UserController extends Controller {

  /**
   * Default action
   * @action index
   */
  public function index(): void {
    $data["title"] = "User - index";
    $this->render("user/index", $data);
  }

  /**
   * Edits user details
   * @param array $params
   */
  public function edit(array $params): void {
    $data["title"] = "User - edit";
    $data["users"] = $this->model->loadAll();
    $this->render("user/edit", $data);
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 6/19/2019
 * Time: 07:40
 */
namespace phpchassis\mvc\core;

/**
 * Class BaseController handles the input from the user.
 */
abstract class BaseController implements ControllerInterface {

  /**
   * @var Model
   */
  protected $model;

  /**
   * @var View
   */
  private $view;

  /**
   * @var View
   */
  protected $layout = "default";

  /**
   * Controller constructor.
   * @param Model $model
   */
  public function __construct(?ModelInterface $model) {
      $this->view = new BaseView();
      $this->model = $model;
  }

  /**
   * Convenient method for the controller to access the View's render method
   * @param string $filename
   * @param array|null $data
   */
  protected function render(string $filename, array $data = null): void {
      $this->view->render($this->layout, $filename, $data);
  }

  /**
   * Before filter - called before an action method.
   * @return void
   */
  protected function before() {}

  /**
   * After filter - called after an action method.
   * @return void
   */
  protected function after() {}
}

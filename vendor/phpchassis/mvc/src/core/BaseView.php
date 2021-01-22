<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 6/19/2019
 * Time: 07:40
 */
namespace phpchassis\mvc\core;

/**
 * Class View sends the data to the page to view the information
 */
class BaseView {

    /**
     * @param string $layout
     * @param string $filename
     * @param array|null $data
     */
    public function render(string $layout, string $filename, array $data = null) {

        if (null !== $data) {
             extract($data);
        }
        $contentFile = SRC_DIR . "/views/{$filename}.php";
        require(SRC_DIR . "/views/layouts/{$layout}.inc.php");
    }
}

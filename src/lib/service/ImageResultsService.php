<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/24/2019
 * Time: 22:08
 */
namespace lookup\lib\service;

use lookup\models\ImageModel;

/**
 * Class ImageResultsService
 * @package lookup\lib
 */
class ImageResultsService implements ResultsInterface {

    /**
     * @var ImageModel
     */
    private $imageModel = null;

    /**
     * @var array
     */
    private $results = null;

    /**
     * WebsiteResultsProvider constructor.
     */
    public function __construct(ImageModel $imageModel) {
        $this->imageModel = $imageModel;
    }

    /**
     * Returns the total number of results found for a given search criteria
     * @param string $searchCriteria
     * @return int
     */
    public function getNumResults(string $searchCriteria): int {
        return $this->imageModel->findCount($searchCriteria);
    }

    /**
     * Returns the results for a given search criteria
     * @param $page         // Current page num
     * @param $pageSize     // Num of rows to be returned
     * @param $term         // Search term user entered
     * @return ImageResultsProvider
     */
    public function getResults(int $pageNum, int $pageSize, string $searchCriteria) {

        $this->results = $this->imageModel->findAllByCriteria($pageNum, $pageSize, $searchCriteria);
        return $this;
    }

    /**
     * Returns the results in an html format, ready to be displayed to the user
     * @return string
     */
    public function asHtml(): string {

        $resultsHtml = "<div class='img-grid'>";
        $count = 0;

        foreach ($this->results as $image) {
            $count++;
            $title = $image->getTitle();
            $alt = $image->getAlt();
            $displayText = ($title) ? $title : ($alt) ? $alt : $image->getImageUrl();

            $resultsHtml .= "
                <div class='item image{$count}'>
                  <a href='{$image->getImageUrl()}' data-fancybox data-caption='{$displayText}' data-siteurl='{$image->getSiteUrl()}'>
                    <script >
                      $(document).ready(function() {
                          loadImage(\"{$image->getImageUrl()}\", \"image{$count}\")
                      });
                    </script>
                    <span class='details'>$displayText</span>
                  </a>
                </div>";
        }

        $resultsHtml .= "</div>";
        return $resultsHtml;
    }
}
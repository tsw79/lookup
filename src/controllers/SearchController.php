<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/30/2019
 * Time: 19:40
 */
namespace lookup\controllers;

use lookup\lib\api\request\WebServiceRequest;
use lookup\models\ {WebsiteModel, ImageModel};
use lookup\lib\service\ {ImageResultsService, WebsiteResultsService};
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;
use phpchassis\mvc\db\Connection;
use phpchassis\lib\traits\ArrayUtil;

/**
 * Class SearchController
 * @package controllers
 */
class SearchController extends Controller {

  /**
   * Default action for the Search controller
   * @action index
   */
  public function index(): void {
    $data["title"] = "Search - index";
    $this->render("search/index", $data);
  }

  /**
   * Returns the search results for a given search criteria
   * @action results
   * @param array $params
   */
  public function results(array $params = array()): void {

    if (!array_key_exists('q', $params)) {
      throw new \InvalidArgumentException("You must enter a search term!");
    }

    $searchResultsConfig = ArrayUtil::toObject( ConfigLoader::instance()->searchResults() );
    $dbConfig = ConfigLoader::instance()->db();
    $dbConn = Connection::instance()->getConnection($dbConfig);
    $wikipediaRequest = (new WebServiceRequest())->createWikipedia();

    $this->layout = "results";
    $searchCriteria = $params['q'];
    $type = $params["type"] ?? "sites";
    $pageNum = $params["pg"] ?? 1;
    $aboutInfo = null;
    
    if ($type == "sites") {
      $resultsProvider = new WebsiteResultsService(new WebsiteModel($dbConn));
      $resultsProvider->setParam("siteInfo", $wikipediaRequest->get($searchCriteria));
      $pageLimit = $searchResultsConfig->sites->limit->page;
    }
    else {
      $resultsProvider = new ImageResultsService(new ImageModel($dbConn));
      $pageLimit = $searchResultsConfig->images->limit->page;
    }

    $this->render("search/results", [
      "results"    => $resultsProvider->getResults($pageNum, $pageLimit, $searchCriteria),
      "pageLimit"  => $pageLimit,
      "numResults" => $resultsProvider->getNumResults($searchCriteria),
      "q"          => $searchCriteria,
      "type"       => $type,
      "pageNum"    => $pageNum,
      "aboutInfo"  => $aboutInfo
    ]);
  }
}
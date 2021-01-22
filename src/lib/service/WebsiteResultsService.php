<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/24/2019
 * Time: 22:08
 */
namespace lookup\lib\service;

use lookup\models\WebsiteModel;
use phpchassis\lib\loaders\SimpleConfigLoader as ConfigLoader;
use phpchassis\lib\traits\StringUtil;

/**
 * Class WebsiteResultsService
 * @package lookup\lib\providers
 */
class WebsiteResultsService implements ResultsInterface {

  use StringUtil;

  /**
   * @var WebsiteModel
   */
  private $websiteModel = null;

  /**
   * @var array
   */
  private $results = null;

  /**
   * @var array
   */
  private $params = [];

  /**
   * WebsiteResultsProvider constructor.
   */
  public function __construct(WebsiteModel $websiteModel) {
    $this->websiteModel = $websiteModel;
  }

  /**
   * Returns the total number of results found for a given search criteria
   * @param string $searchCriteria
   * @return int
   */
  public function getNumResults(string $searchCriteria): int {
    return $this->websiteModel->findCount($searchCriteria);
  }

  /**
   * Returns the results for a given search criteria
   * @param $page         Current page num
   * @param $pageSize     Num of rows to be returned
   * @param $term         Search term user entered
   * @return WebsiteResultsProvider
   */
  public function getResults(int $pageNum, int $pageSize, string $searchCriteria) {
    $this->results = $this->websiteModel->findAllByCriteria($pageNum, $pageSize, $searchCriteria);
    return $this;
  }

  /**
   * Returns the results in an html format, ready to be displayed to the user
   * @return string
   */
  public function asHtml(): string {

    $websitesResultsConf = ConfigLoader::instance()->searchResults('sites');
    $titleLimit = $websitesResultsConf['limit']['title'];
    $descriptLimit = $websitesResultsConf['limit']['description'];
    $resultsHtml = "<div class='site-results-wrap f-row'><div class='site-results'>";
    
    $siteInfo = $this->params['siteInfo'];
    $siteTitle = StringUtil::trimToEllipses($siteInfo->extract, 1000);

    foreach ($this->results as $site) {
      $title = StringUtil::trimToEllipses($site->getTitle(), $titleLimit);
      $description = StringUtil::trimToEllipses($site->getDescription(), $descriptLimit);
      $resultsHtml .= <<<HTML
              <div class='result-container'>
                <span class='url'>
                  <a href='{$site->getUrl()}' data-siteId='{$site->getId()}'>{$site->getUrl()}</a>
                </span>
                <h3 class='title'>
                  <a class='result' href='{$site->getUrl()}' data-siteId='{$site->getId()}'>{$title}</a>
                </h3>
                <span class='description'>{$description}</span>
              </div>
            HTML;
    }
    $resultsHtml .= "</div>";
    $resultsHtml .= <<<HTML
            <div class='site-results-info'>
              <div class='container'>
                <section>
                  <div class='wrap'>
                    <img src='' />
                    <p>
                      <div class='search-title'>{$siteInfo->title}</div>
                      <div class='search-website'><a href='#'>website.com</a></div>
                      <div class='about-site'>
                        {$siteTitle} 
                        <!-- <span class='more'>--More here... </span> -->
                        <a href="{{$siteInfo->fullurl}}" _target="blank"><cite>Wikipedia</cite></a>
                      </div>
                    </p>
                    <div class='detail'>
                      <span>Type of site:</span> Xxx
                    </div>
                    <div class='detail'>
                      <span>Available in:</span> Xxx
                    </div>
                    <div class='detail'>
                      <span>Area served:</span> Xxx
                    </div>
                    <span class='more'>
                      <div class='detail'>
                        <span>Owner:</span> Xxx
                      </div>
                      <div class='detail'>
                        <span>Created by:</span> Xxx
                      </div>
                      <div class='detail'>
                        <span>Launched:</span> Xxx
                      </div>
                      <div class='detail'>
                        <span>Current status:</span> Xxx
                      </div>
                      <div class='detail'>
                        <span>Written in:</span> Xxx 
                      </div>
                    </span>
                    <ul class='profile-sites'>
                      <li>
                        <a href='#'>
                          <i class='material-icons'>language</i>
                          <div>Website</div>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <i class='material-icons'>language</i>
                          <div>Wikipedia</div>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <i class='material-icons'>language</i>
                          <div>Twitter</div>
                        </a>
                      </li>
                      <li>
                        <a href='#'>
                          <i class='material-icons'>language</i>
                          <div>Facebook</div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </section>
                <div id='toggleResultDetails' class='toggle'>
                  <i class='material-icons rotate'>keyboard_arrow_down</i>
                </div>
              </div>
            </div>
          </div>
        HTML;

    return $resultsHtml;
  }

  public function getParam($key) {
    $this->params[$key];
  }

  public function setParam($key, $value) {
    $this->params[$key] = $value;
  }
}
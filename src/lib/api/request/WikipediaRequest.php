<?php
namespace lookup\lib\api\request;

/**
 * WikipediaRequest
 */
class WikipediaRequest implements WikipediaRequestInterface {

  private $endpoint = 
    "http://en.wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles=%title%&format=json&explaintext&redirects&inprop=url&indexpageids";

    /**
     * get
     */
  public function get(string $title): object {
    $str = str_replace("%title%", $title, $this->endpoint);
    $json = file_get_contents($str);  
    $data = json_decode($json);       
    $pages = (array) $data->query->pages;     
    return (array_values($pages))[0];                     //var_dump((array_values($pages))[0]);exit;
  }
}
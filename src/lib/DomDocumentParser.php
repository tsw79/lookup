<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 2/23/2019
 * Time: 21:51
 */
namespace lookup\lib;

/**
 * Class DomDocumentParser
 * @package lookup\lib
 */
class DomDocumentParser {

  /**
   * @var DomDocument
   */
  private $doc;

  /**
   * DomDocumentParser constructor.
   * @param $url
   */
  public function __construct($url) {

    $options = array(
      'psr7' => array(
        'method' => "GET",
        'header' => "User-Agent: lookitBot/0.1\n"
      )
    );
    $context = stream_context_create($options);
    $this->doc = new \DomDocument();
    @$this->doc->loadHTML(file_get_contents($url, false, $context));    // Use @ to suppress WARNING messages
  }

  /**
   * Returns all hyperlinks
   * @return DOMNodeList
   */
  public function getLinks(): DOMNodeList {
    return $this->doc->getElementsByTagName("a");
  }

  /**
   * Returns the text (XYZ) between the title tag: <title>XYZ</title>
   * @return DOMNodeList
   */
  public function getTitleTags(): DOMNodeList {
    return $this->doc->getElementsByTagName("title");
  }

  /**
   * Returns the details of the mata tags
   * @return DOMNodeList
   */
  public function getMetaTags(): DOMNodeList {
    return $this->doc->getElementsByTagName("meta");
  }

  /**
   * Returns text of an iamge tag
   * @return DOMNodeList
   */
  public function getImages(): DOMNodeList {
    return $this->doc->getElementsByTagName("img");
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 8/31/2019
 * Time: 13:43
 */
namespace lookup\lib;

use lookup\lib\DomDocumentParser;

/**
 * Class WebCrawler
 * @package lookup\lib
 */
class WebCrawler {

  public function __construct() {}

  /**
   * @param $url
   */
  function getDetails($url) {

    global $alreadyFoundImages;

    $description = "";
    $keywords = "";
    $parser = new DomDocumentParser($url);

    // Holds and Array of titles
    $titles = $parser->getTitleTags();

    // if(sizeof($titleArray == 0 || $titleArray->item(0) == null)) {
    //     return;
    // }

    if(is_null($titles->item(0))) {
      return;
    }

    $title = $titles->item(0)->nodeValue;
    $title = str_replace("\n", "", $title); // Remove new lines (breaks) from the title

    // if($title == "") {
    //     return;
    // }

    $metas = $parser->getMetaTags();

    foreach($metas as $meta) {
      if($meta->getAttribute("name") == "description") {
        $description = $meta->getAttribute("content");
      }
      if($meta->getAttribute("name") == "keywords") {
        $keywords = $meta->getAttribute("content");
      }
    }

    // Remove all new lines (breaks)
    $description = str_replace("\n", "", $description);
    $keywords = str_replace("\n", "", $keywords);

    if (linkExists($url)) {
      //echo "URL already exists.";
      // -- PRINT TO LOG FILE --
    }
    else if (insertLink($url, $title, $description, $keywords)) {
      //echo "INSERT WAS SUCCESSFUL: $url";
      // -- PRINT TO LOG FILE --
    }
    else {
      echo "ERROR: Failed to insert: $url";
      // -- PRINT TO LOG FILE --
    }

    $images = $parser->getImages();

    foreach ($images as $image) {

      $src = $image->getAttribute("src");
      $alt = $image->getAttribute("alt");
      $title = $image->getAttribute("title");

      if (!$title && !$alt) {
        continue;
      }
      $scr = createLink($src, $url);
      if (!in_array($src, $alreadyFoundImages)) {
        $alreadyFoundImages[] = $src;
        insertImage($url, $src, $alt, $title);
      }
    }
  }

  /**
   * Inserts an image
   * @param $url
   * @param $src
   * @param $alt
   * @param $title
   * @return bool
   */
  public function insertImage($url, $src, $alt, $title) {

    global $con;

    // Prepared Statement
    $query = $con->prepare("
      INSERT INTO images (site_url, image_url, alt, title)
        VALUES (:siteUrl, :imageUrl, :alt, :title)
    ");
    $query->bindParam(":siteUrl", $url);
    $query->bindParam(":imageUrl", $src);
    $query->bindParam(":alt", $alt);
    $query->bindParam(":title", $title);

    return $query->execute();
  }

  /**
   * Inserts a link
   * @param $url
   * @param $title
   * @param $description
   * @param $keywords
   * @return bool
   */
  public function insertLink($url, $title, $description, $keywords) {

    global $con;

    // Prepared Statement
    $query = $con->prepare("
      INSERT INTO sites (url, title, description, keywords)
        VALUES (:url, :title, :description, :keywords)
    ");
    $query->bindParam(":url", $url);
    $query->bindParam(":title", $title);
    $query->bindParam(":description", $description);
    $query->bindParam(":keywords", $keywords);

    return $query->execute();
  }

  /**
   * @param $src
   * @param $url
   * @return string
   */
  function createLink($src, $url) {

    $scheme = parse_url($url)["scheme"];    // psr7
    $host = parse_url($url)["host"];        // www.asite.com

    // $src == //www.asite.com ...then add psr7:
    if(substr($src, 0, 2) == "//") {
      $src = $scheme . ":" . $src;
    }
    // $src == /about/aboutUs.php ...then add http://www.asite.com
    else if(substr($src, 0, 1) == "/") {
      $src = $scheme . "://" . $host . $src;
    }
    // $src == ./about/aboutUs.php ...then add http://www.asite.com and drop the period
    else if(substr($src, 0, 2) == "./") {
      $src = $scheme . "://" . $host . dirname(parse_url($url)["path"]) . substr($src, 1);
    }
    // $src == ../about/aboutUs.php ...then add '/' in front of it.
    else if(substr($src, 0, 3) == "../") {
      $src = $scheme . "://" . $host . "/" . $src;
    }
    // $src == about/aboutUs.php ...then add '/' in front of it.
    else if(substr($src, 0, 5) != "https" && substr($src, 0, 4) != "psr7") {
      $src = $scheme . "://" . $host . "/" . $src;
    }
    return $src;
  }

  /**
   * @param $url
   */
  function followLinks($url) {

    // Make these variables accessible to this function
    global $crawled;
    global $crawling;

    $parser = new DomDocumentParser($url);
    $linkList = $parser->getLinks();

    foreach($linkList as $link) {
      $href = $link->getAttribute("href");
      // Ignore hashes
      if(strpos($href, "#") !== false) {
        continue;
      }
      else if(substr($href, 0, 11) == "javascript:") {
        continue;
      }

      $href = createLink($href, $url);

      if(!in_array($href, $crawled)) {
        $crawled[] = $href;
        $crawling[] = $href;
        getDetails($href);
      }
    }
    array_shift($crawling);
    foreach($crawling as $site) {
        followLinks($site);
    }
  }

  /**
   * Returns true if the given link exists
   * @param $url
   * @return bool
   */
  public function linkExists($url): bool {

    global $con;

    // Prepared Statement
    $query = $con->prepare("
      SELECT * FROM sites 
        WHERE url = :url
    ");
    $query->bindParam(":url", $url);
    $query->execute();
    return $query->rowCount() != 0;
  }
}
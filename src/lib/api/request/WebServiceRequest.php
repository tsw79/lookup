<?php
/**
 * WebServiceRequest [Abstract Factory]
 */
namespace lookup\lib\api\request;

class WebServiceRequest implements WebServiceRequestInterface {

  /**
   * createWikipedia
   */
  public function createWikipedia(): WikipediaRequestInterface {
    return new WikipediaRequest();
  }
}
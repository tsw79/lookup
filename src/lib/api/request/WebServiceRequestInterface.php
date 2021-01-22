<?php
/**
 * WebServiceRequestInterface
 */
namespace lookup\lib\api\request;

interface WebServiceRequestInterface {

  public function createWikipedia(): WikipediaRequestInterface;
}
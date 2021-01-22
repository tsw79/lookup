<?php
/**
 * ApiRequest
 */
namespace lookup\lib\api\request;

interface WikipediaRequestInterface {
  public function get(string $title): object;
}
<?php
/**
 * Created by PhpStorm.
 * User: tharwat
 * Date: 9/2/2019
 * Time: 22:54
 */
namespace lookup\lib\service;

/**
 * Interface ResultsInterface
 * @package lookup\lib\providers
 */
interface ResultsInterface {

    /**
     * Returns the total number of results found for a given search criteria
     * @param string $searchCriteria
     * @return int
     */
    public function getNumResults(string $searchCriteria): int;

    /**
     * Returns the results for a given search criteria
     * @param $page
     * @param $pageSize
     * @param $term
     * @return mixed
     */
    public function getResults(int $pageNum, int $pageSize, string $searchCriteria);

    /**
     * Returns the results in an html format, ready to be displayed to the user
     * @return mixed
     */
    public function asHtml(): string;
}
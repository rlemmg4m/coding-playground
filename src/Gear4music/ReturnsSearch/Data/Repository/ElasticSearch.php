<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 08/10/2018
 * Time: 11:57
 */

namespace Gear4music\ReturnsSearch\Data\Repository;

/**
 * Class ElasticSearch
 * @package Gear4music\ReturnsSearch\Data\Repository
 */
abstract class ElasticSearch
{
    /**
     * @param $str_search_field
     * @param $str_search_identifier
     * @return mixed
     */
    abstract public function search($str_search_identifier);

    /**
     * @return mixed
     */
    abstract public function getData();

    /**
     * @return mixed
     */
    abstract public function getMetaData();

    /**
     * @return mixed
     */
    abstract public function getCount();
}

<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 08/10/2018
 * Time: 11:57
 */

namespace Gear4music\ReturnsSearch\Data\Repository;


abstract class ElasticSearch
{
    abstract public function search($str_search_field, $str_search_identifier);
    abstract public function getData();
    abstract public function getMetaData();
}

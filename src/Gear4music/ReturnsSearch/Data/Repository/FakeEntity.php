<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 05/10/2018
 * Time: 11:51
 */

namespace Gear4music\ReturnsSearch\Data\Repository;


abstract class FakeEntity
{
    /**
     * @param $str_identifier
     * @param $str_name
     * @param $int_age
     * @return mixed
     */
    abstract public function createFake($str_identifier,$str_name,$int_age);

    /**
     * @param $str_identifier
     * @return mixed
     */
    abstract public function fetchById($str_identifier);

    /**
     * @param $str_identifier
     * @return mixed
     */
    abstract public function removeById($str_identifier);
}

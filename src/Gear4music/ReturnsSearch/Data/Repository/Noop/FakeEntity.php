<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 05/10/2018
 * Time: 11:58
 */

namespace Gear4music\ReturnsSearch\Data\Repository\Noop;

class FakeEntity extends \Gear4music\ReturnsSearch\Data\Repository\FakeEntity
{

    /**
     * @param $str_identifier
     * @param $str_name
     * @param $int_age
     * @return mixed
     */
    public function createFake($str_identifier, $str_name, $int_age)
    {
        return [];
    }

    /**
     * @param $str_identifier
     * @return mixed
     */
    public function fetchById($str_identifier)
    {
        return ['NO-OPS' => 'Fetch by Id called'];
    }

    /**
     * @param $str_identifier
     * @return mixed
     */
    public function removeById($str_identifier)
    {
        return [];
    }
}
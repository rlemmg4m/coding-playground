<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 05/10/2018
 * Time: 11:46
 */

namespace Gear4music\ReturnsSearch\Data\Entity;


class FakeEntity // not much to implement
{
    /**
     * @var string
     */
    private $str_identifier;
    /**
     * @var string
     */
    private $str_name;
    /**
     * @var integer
     */
    private $int_age;

    /**
     * @return string
     */
    public function getStrIdentifier()
    {
        return $this->str_identifier;
    }

    /**
     * @param string $str_identifier
     */
    public function setStrIdentifier($str_identifier)
    {
        $this->str_identifier = $str_identifier;
    }

    /**
     * @return string
     */
    public function getStrName()
    {
        return $this->str_name;
    }

    /**
     * @param string $str_name
     */
    public function setStrName($str_name)
    {
        $this->str_name = $str_name;
    }

    /**
     * @return int
     */
    public function getIntAge()
    {
        return $this->int_age;
    }

    /**
     * @param int $int_age
     */
    public function setIntAge($int_age)
    {
        $this->int_age = $int_age;
    }

}

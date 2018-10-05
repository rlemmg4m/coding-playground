<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 05/10/2018
 * Time: 12:00
 */

namespace Gear4music\ReturnsSearch\Controller\Search;


use Gear4music\JAPI\AuthSpec\Insecure;
use Gear4music\JAPI\AuthSpecInterface;
use Gear4music\JAPI\RequestValidatorSpec\NoValidation;
use Gear4music\JAPI\RequestValidatorSpecInterface;
use Gear4music\ReturnsSearch\Controller;
use Gear4music\ReturnsSearch\Data\Repository\Noop\FakeEntity;

class FakeByID extends Controller
{
    private $arr_query_params;
    private $str_identifier;
    private $obj_fake_entity;

    /**
     * Main dispatch method
     *
     * @return mixed
     */
    public function dispatch()
    {
        $this->arr_query_params = $this->getRequest()->getQueryParams();
        $this->str_identifier = $this->arr_query_params['return_identifier'];

        try{
            $this->obj_fake_entity = (new FakeEntity())->fetchById($this->str_identifier);
        }catch (\Exception $obj_error)
        {
            $this->setResponseJson(['Error when looking for fake entity with ID ' . $this->str_identifier  => $obj_error->getMessage()]);
        }

        $this->setResponseJson([$this->obj_fake_entity]);
    }

    /**
     * Build and return a spec that defines how we authenticate the Request
     *
     * @return AuthSpecInterface
     */
    public function buildAuthSpec()
    {
        return new Insecure();
    }

    /**
     * Build and return a spec that defines how we validate the Request
     *
     * @return RequestValidatorSpecInterface
     */
    public function buildRequestValidatorSpec()
    {
        return new NoValidation();
    }
}

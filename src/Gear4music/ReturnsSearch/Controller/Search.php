<?php
/**
 * Created by PhpStorm.
 * User: robert.lemm
 * Date: 08/10/2018
 * Time: 12:20
 */

namespace Gear4music\ReturnsSearch\Controller;


use Gear4music\JAPI\AuthSpec\Insecure;
use Gear4music\JAPI\AuthSpecInterface;
use Gear4music\JAPI\RequestValidatorSpec\NoValidation;
use Gear4music\JAPI\RequestValidatorSpecInterface;
use Gear4music\ReturnsSearch\Controller;
use Gear4music\ReturnsSearch\Data\Repository\Noop\Returns;

class Search extends Controller
{

    /**
     * @var array
     */
    private $arr_query_params;

    /**
     * @var string
     */
    private $str_search_identifier;

    /**
     * @var
     */
    private $str_search_field;

    /**
     * @var array
     */
    private $arr_return_data;

    /**
     * Main dispatch method
     *
     * @return mixed
     */
    public function dispatch()
    {
        $this->arr_query_params = $this->getRequest()->getQueryParams();
        $this->str_search_identifier = $this->arr_query_params['search_id'];
        $this->str_search_field = $this->arr_query_params['search_field'];
        try {
            $this->arr_return_data = (new Returns())->search($this->str_search_field, $this->str_search_identifier);

            return $this->setResponseJson($this->arr_return_data);

        } catch (\Exception $exception) {
            throw new \Gear4music\JAPI\Exceptions\ErrorResponse('Unable to process request', 500);
        }
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

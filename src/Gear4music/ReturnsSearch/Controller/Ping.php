<?php

namespace Gear4music\ReturnsSearch\Controller;

use Gear4music\JAPI\AuthSpec\Insecure;
use Gear4music\JAPI\AuthSpecInterface;
use Gear4music\JAPI\RequestValidatorSpecInterface;
use Gear4music\JAPI\RequestValidatorSpec\NoValidation;
use Gear4music\ReturnsSearch\Controller;

class Ping extends Controller
{

    /**
     * Simple "ping" controller
     */
    public function dispatch()
    {
        $this->setResponseJson([
            'hello' => 'world'
        ]);
    }

    /**
     * @return AuthSpecInterface
     */
    public function buildAuthSpec()
    {
        return new Insecure();
    }

    /**
     * @return RequestValidatorSpecInterface
     */
    public function buildRequestValidatorSpec()
    {
        return new NoValidation();
    }

}
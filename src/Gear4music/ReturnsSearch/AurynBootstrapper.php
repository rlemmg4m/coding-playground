<?php

namespace Gear4music\ReturnsSearch;

use Auryn\Injector;
use Gear4music\Cache\Adapter as CacheAdapter;
use Gear4music\Cache\CacheAwareInterface;
use Gear4music\Environment;
use Gear4music\EnvironmentAwareInterface;
use Gear4music\JAPI\CacheAdapterFactory;
use Gear4music\JAPI\ExtendedApplication;
use Gear4music\JAPI\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * Uses Auryn to wire together the application using "Recursive Dependency Injection"
 */
class AurynBootstrapper
{

    /**
     * @var Injector
     */
    protected $obj_di;

    /**
     * @var Environment
     */
    protected $obj_env;

    /**
     * @var LoggerInterface
     */
    protected $obj_logger;

    /**
     * @var ServerRequestInterface
     */
    protected $obj_request;

    /**
     * @var RouterInterface
     */
    protected $obj_router;

    /**
     * Auryn-based application bootstrap
     *
     * @param Environment $obj_env
     * @param LoggerInterface $obj_logger
     * @param ServerRequestInterface $obj_request
     */
    public function __construct(Environment $obj_env, LoggerInterface $obj_logger, ServerRequestInterface $obj_request)
    {
        $this->obj_di = new Injector();
        $this->obj_env = $obj_env;
        $this->obj_logger = $obj_logger;
        $this->obj_request = $obj_request;
    }

    /**
     * Route, Configure DI
     *
     * Execute the router first, so we can early-out if there is a problem (e.g. 404)
     *
     * @return $this
     */
    public function prepare()
    {
        $this->prepareEnvironment();
        $this->prepareLogger();
        $this->prepareCache();
        // @todo Add your application-specific wiring here
        return $this;
    }

    /**
     * Add the middleware (the order is IMPORTANT), run the application
     *
     * @param ExtendedApplication $obj_application
     * @return ExtendedApplication
     */
    public function app(ExtendedApplication $obj_application)
    {
        $obj_application->setEnvironment($this->obj_env);
        $obj_controller = $this->obj_di->make($this->obj_request->getAttribute('routed_controller'));
        $obj_application->addMiddleware($obj_controller);
        return $obj_application;
    }

    /**
     * Environment Setter Injection (this prepare example passes in an instance with "use")
     */
    private function prepareEnvironment()
    {
        $this->obj_di
            ->share($this->obj_env)
            ->prepare(EnvironmentAwareInterface::class,
                function (EnvironmentAwareInterface $obj_needs_environment, Injector $obj_di) {
                    $obj_needs_environment->setEnvironment($obj_di->make(Environment::class));
                }
            );
    }

    /**
     * Tell Auryn how to build *one* application Logger
     *
     * LoggerAwareInterface - setter injection, implemented by Gear4music\JAPI\Contoller
     */
    private function prepareLogger()
    {
        $this->obj_di
            ->share($this->obj_logger)
            ->alias(LoggerInterface::class, get_class($this->obj_logger))
            ->prepare(LoggerAwareInterface::class,
                function (LoggerAwareInterface $obj_needs_logger, Injector $obj_di) {
                    $obj_needs_logger->setLogger($obj_di->make(LoggerInterface::class));
                }
            );
    }

    /**
     * Define what type of Cache Adapter to instantiate (**once**)
     *
     * CacheAwareInterface (for setter-based injections)
     *
     * Delegate to a Factory, which uses the environment to determine the correct Cache Adapter
     */
    private function prepareCache()
    {
        $this->obj_di
            ->share(CacheAdapter::class)
            ->delegate(CacheAdapter::class, CacheAdapterFactory::class)
            ->prepare(CacheAwareInterface::class,
                function (CacheAwareInterface $obj_needs_cache, Injector $obj_di) {
                    $obj_needs_cache->setCache($obj_di->make(CacheAdapter::class));
                }
            );
    }

}

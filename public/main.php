<?php
/**
 * Front-controller
 *
 * @copyright 2017 Gear4music
 */

// PHP native set-up, can be moved to php.ini as preferred
error_reporting(E_ALL);
ini_set('display_errors', 0);
date_default_timezone_set('Europe/London');

// Auto loader
require_once __DIR__ . '/../vendor/autoload.php';

// Create the application (starts output buffering, shutdown & Exception handlers)
$obj_application = new \Gear4music\JAPI\ExtendedApplication();

// Environment
$obj_env = new \Gear4music\Environment();


// Logger
switch ($obj_env->getVar('LOGGER_TYPE')) {
    case 'SYSLOG':
        $obj_log_handler = new Monolog\Handler\SyslogHandler('app');
        break;
    case 'ERROR_LOG':
    default:
        $obj_log_handler = new \Monolog\Handler\ErrorLogHandler();
        break;
}
$obj_log_handler->setLevel(Monolog\Logger::INFO);
$obj_logger = (new Monolog\Logger('app'))->pushHandler($obj_log_handler);
$obj_application->setLogger($obj_logger);

// Some additional behaviour for DEV mode
if ('DEV' === $obj_env->getVar('APP_MODE')) {
    (new Dotenv\Dotenv(__DIR__ . '/..'))->overload();
    $obj_log_handler->setLevel(Monolog\Logger::DEBUG);
}

// PSR-7 Request, Response
$obj_request = \Gear4music\JAPI\ServerRequest::fromGlobals();
$obj_response = new \GuzzleHttp\Psr7\Response();

// Routing
$obj_router = new \Gear4music\JAPI\SolidRouter('\\Gear4music\\ReturnsSearch\\Controller\\');
$obj_request = $obj_request->withAttribute('routed_controller', $obj_router->route($obj_request)->getControllerName());

// Bootstrap with our preferred RDI, Auryn
$obj_bootstrap = new \Gear4music\ReturnsSearch\AurynBootstrapper($obj_env, $obj_logger, $obj_request);
$obj_bootstrap->prepare()->app($obj_application)->run($obj_request, $obj_response);
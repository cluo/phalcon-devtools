<?php
/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;

/**
 * The FactoryDefault Dependency Injector automatically registers the right services to provide a full stack framework
 */
$di = new FactoryDefault();

/**
 * Registering a router
 */
$di->set('router', function () {
    $router = new Router();

    $router->setDefaultModule('frontend');
    $router->setDefaultNamespace('@@namespace@@\Frontend\Controllers');

    return $router;
});

/**
 * The URL component is used to generate all kinds of URLs in the application
 */
$di->set('url', function () {
    $url = new UrlResolver();
    $url->setBaseUri('/@@name@@/');

    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter($config->toArray());
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Starts the session the first time some component requests the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
* Set the default namespace for dispatcher
*/
$di->setShared('dispatcher', function() use ($di) {
	$dispatcher = new Phalcon\Mvc\Dispatcher();
	$dispatcher->setDefaultNamespace('@@namespace@@\Frontend\Controllers');
	return $dispatcher;
});

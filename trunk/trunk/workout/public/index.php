<?php
/**
 * My new Zend Framework project
 * 
 * @author  
 * @version 
 */

set_include_path('.' . PATH_SEPARATOR . '../library' . PATH_SEPARATOR . './application/default/models/' . PATH_SEPARATOR . get_include_path());
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Router/Rewrite.php';
require_once 'Zend/Controller/Router/Route.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Config.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

Zend_Loader::loadClass('Zend_Config_Ini');
Zend_Loader::loadClass('Zend_Db');
Zend_Loader::loadClass('Zend_Db_Table');
// load configuration
$config = new Zend_Config_Ini('../application/config.ini', 'general');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);
// setup database
$db = Zend_Db::factory($config->db->adapter,
$config->db->config->toArray());
Zend_Db_Table::setDefaultAdapter($db);


	$router = new Zend_Controller_Router_Rewrite();
	
	$route1 = new Zend_Controller_Router_Route(
    	'workout/:id',
    	array(
    	    'controller' => 'workout',
    	    'action'     => 'index'
    	)
	);
	$route2 = new Zend_Controller_Router_Route(
    	'workout/:id/:date',
    	array(
    	    'controller' => 'workout',
    	    'action'     => 'index'
    	)
	);
	$user = new Zend_Controller_Router_Route(
    	'users/:id',
    	array(
    	    'controller' => 'Users',
    	    'action'     => 'index'
    	)
	);
	$router->addRoute('workout', $route1);
	$router->addRoute('workout2', $route2);
	$router->addRoute('users', $user);

/**
 * Setup controller
 */
$controller = Zend_Controller_Front::getInstance();
$controller->setControllerDirectory('../application/default/controllers')
			->setRouter($router);
			/*->setBaseUrl('api/');*/
$controller->throwExceptions(false); // should be turned on in development time 
$controller->dispatch();

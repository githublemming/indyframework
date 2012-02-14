<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2011, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * This is the main file for the Indy Framework, it is the file that an application
 * should include (require) in order to load the framework.
 * 
 * It loads the core elements of the framework and configures them ready for use.
 *
 * @package indyframework
 */

/**
 * Simple constant that can be checked to ensure that providers are being called
 * from within the framework.
 *
 * @var bool
 */
define('INDY_EXEC', true);

/** Define INDY_PATH as the root directory of the framework */
define( 'INDY_PATH', dirname(__FILE__) . '/');

/** Define APPLCATION_PATH as the root directory of the Application */
define( 'APPLICATION_PATH', dirname(__FILE__) . '/../' );



// load the configuration file
require_once(INDY_PATH . 'config.php');


// now load the Indy Framework
try
{
    require_once(INDY_CORE . 'loader/ApplicationXMLLoader.php');
}
catch (ApplicationException $e)
{
    $logger = Logger::getLogger();

    $logger->log(Logger::LOG_LEVEL_FATAL,
                 'Indy Framework',
                 "An exception was thrown building the application, check the logging and fix the problem.",
                 $e);

    exit;

}

/**
 * This method is used to load and add the runnable provider onto the end of the
 * Application config so that it is able to request services from the Service
 * Repository.
 * 
 * @param RunnableInterface $runnableClass  The provider that sits at the
 * bottom of the Application configuration.
 */
function run(RunnableInterface $runnableClass)
{
    global $appLoader;

    $appLoader->loadRunnable($runnableClass);

    $runnableClass->run();
}

?>

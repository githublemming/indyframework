<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Configuration file
 *
 * This file defines the constants that could be used anywhere within the framework.
 * It also aloads all other PHP files that are needed for the frame work to function.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework
 */

/**
 * ============================================================================
 * =====================Start of user configurable options=====================
 * ============================================================================
 */

/**
 * If you want to use any of the Amazon Web Services related providers then you'll
 * need to add the AWS SDK into the external directory, update the below define
 * so that it references the correct version of the SDK and uncomment the line. 
 */
define('AWS_SDK','aws-sdk-1.5.0/');

/**
* ============================================================================
* ======================End of user configurable options======================
* ============================================================================
*/

/**
 * This file should not be modifed beyond this point, as doing so might affect
 * the operation of the framework.
 * 
 * Applications can define their own configuration file called application.cfg
 * in which it can define it's configuration. This file must sit in the
 * applications root.
 */

// It isn't compulsary for the implementing application to have it's own
// configuration file, so we'll check one exists before we try and load it.
if (file_exists(APPLICATION_PATH . 'application.cfg'))
{
    include APPLICATION_PATH . 'application.cfg';
}

//
// The default location of your Application Configuration file.
// 
// The constant APPLICATION_PATH has been defined as one directory level above
// the IndyFramework directory e.g. require_once(APPLICATION_PATH . '/IndyFramework/');
//

if (!defined( 'APPLICATION_DEFINITION' )) {
    
    define ('APPLICATION_DEFINITION', APPLICATION_PATH . 'application_definition.xml');
}


/** The path to the directory that contains Indy core modules */
define('INDY_CORE', INDY_PATH .'core/');

/** The path to the directory that contains the Framework services */
define('INDY_SERVICE', INDY_PATH .'services/');

/** The path to the directory that contains framework providers */
define('INDY_PROVIDER', INDY_PATH .'providers/');

/** The path to the directory that contains framework models */
define('INDY_MODEL', INDY_PATH .'model/');

/** The path to the directory that contains 3rd party code */
define('INDY_EXTERNAL', INDY_PATH .'external/');

/** The path to the directory that contains the provided tags */
define('INDY_TAGS', INDY_PATH . 'tags/');



/** The path to the directory that contains application specific services */
define('APPLICATION_SERVICE', APPLICATION_PATH .'services/');

/** The path to the directory that contains  application specific providers */
define('APPLICATION_PROVIDER', APPLICATION_PATH .'providers/');

/** The path to the directory that contains  application specific 3rd party code */
define('APPLICATION_EXTERNAL', APPLICATION_PATH .'external/');

/** The path to the directory that contains  application specific models */
define('APPLICATION_MODEL', APPLICATION_PATH .'models/');

/** The path to the directory that contains  application specific custom tags */
define('APPLICATION_TAGS', APPLICATION_PATH . 'tags/');

// load the core components
require_once(INDY_CORE . 'Exceptions.php');
require_once(INDY_CORE . 'ServiceInterface.php');
require_once(INDY_CORE . 'RunnableInterface.php');
require_once(INDY_CORE . 'ProviderInterface.php');
require_once(INDY_CORE . 'ServiceRepository.php');
require_once(INDY_CORE . 'Logger.php');

// Define some constants to be used when sending messages to the providers during
// application load so they can perform the appropriate actions at the correct
// time

/** 
 * Defines a constant that is used to inform a provider that it has been added
 * to the application and it should perform any initial actions, such as registering
 * itself with the Service Repository with any service it provides
 */
define('APPLICATION_LOAD','1');

/** 
 * Defines a constant that is used to inform a provider that it is time to perform
 * any initialisation tasks that it needs to do in preparation for the application
 * being used. Suchs tasks include requesting any services it might need.
 */
define('APPLICATION_INIT','2');

/**
 * Defines a constant that is used to inform a provider that it is time to perform
 * any display tasks that it needs to do.
 */
define('APPLICATION_VIEW','3');



//Define the RegularExpressions used in determining tags and Dollar Notations
define('REGEX_TAG_ATTRIBUTE_PATTERN', '(?:\s[a-z\d]+=\"[\$\{\w\d\s\.\'!<>=\+\-\*\/\}]+\"){0,5}');
define('REGEX_SIMPLE_TAG_PATTERN', '<[a-z]+:[a-z]+\s*' . REGEX_TAG_ATTRIBUTE_PATTERN . '\s*/>');
define('REGEX_BODY_OPEN_TAG_PATTERN'  , '<([a-z]+:[a-z]+)\s*' . REGEX_TAG_ATTRIBUTE_PATTERN . '\s*>');
define('REGEX_BODY_CLOSE_TAG_PATTERN'  , '</\1>');
define('REGEX_BODY_TAG_PATTERN'  , REGEX_BODY_OPEN_TAG_PATTERN . '.*?' . REGEX_BODY_CLOSE_TAG_PATTERN);
define('REGEX_DOLLAR_NOTATION', '\$\{.*?\}');

require_once INDY_CORE. 'loader/BaseApplicationLoader.php';

require_once INDY_CORE. 'engines/Engine.php';
require_once INDY_CORE. 'engines/EL.php';
require_once INDY_CORE. 'engines/TL.php';

require_once INDY_CORE. 'EvalMath.php';
require_once INDY_CORE. 'TagLibrary.php';
require_once INDY_CORE. 'TagDefinition.php';

require_once INDY_CORE. 'AbstractPage.php';

require_once INDY_CORE . 'scopes/Scope.php';
require_once INDY_CORE . 'scopes/PageScope.php';

require_once INDY_CORE . 'page/PageContext.php';
require_once INDY_CORE . 'page/PageProcessor.php';

// Setting the logging level that is required for the application. If this is
// commented out then the default level will be LOG_LEVEL_INFO
//$logger = Logger::createLogger(Logger::LOG_LEVEL_DEBUG);

?>
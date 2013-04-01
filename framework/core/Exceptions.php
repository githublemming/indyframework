<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Exceptions.php
 *
 * Contains all of the frameworks Exception classes 
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * Base Exception that all exceptions defined with the Framework should extend.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

class IndyFrameworkException extends Exception {
	
    protected $exceptionType = '';

    // we'll dump out the error to the log
    // and then continue throwing the exception
    public function  __construct($message, $code, $previous)
    {
        parent::__construct($message, $code);
    }

    public function  __toString()
    {
        return $this->getTraceAsString();
    }
    
    public function getExceptionType() {
    	return $this->exceptionType;
    }
}


/**
 * Thrown if there is a problem adding to or retrieving from the Service Repository
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

class ServiceRepositoryException extends IndyFrameworkException
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $this->exceptionType = 'Service Repository';

        parent::__construct($message, $code, $previous);
    }
}

/**
 * Thrown if there is a problem building/configuring/initialsing the application
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

class ApplicationException extends IndyFrameworkException
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $this->exceptionType = 'Application';

        parent::__construct($message, $code, $previous);
    }
}
?>

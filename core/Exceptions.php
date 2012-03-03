<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.marksdevserver.com
 */

/**
 * Base Exception that all exceptions defined with the Framework should extend.
 *
 * @package indyframework/core
 */

class IndyFrameworkException extends Exception {
	
    protected $exceptionType = '';

    // we'll dump out the error to the log
    // and then continue throwing the exception
    public function  __construct($message, $code, $previous)
    {
        parent::__construct($message, $code, $previous);
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
 * @package indyframework/core
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
 * @package indyframework/core
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

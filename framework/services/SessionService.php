<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

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
 * Service that provides Session functionality.
 *
 * @package indyframework/services
 */

interface SessionService extends ServiceInterface
{
    /**
     * Checks to see if session_start has already been called, and if it hasn't
     * calls it.
     */
    public function start();

    /**
     * Checks to see if the required parameter has is currently stored in $_SESSION.
     *
     * @param string $parameter Name of parameter to check
     * @return boolean TRUE or FALSE
     */
    public function exists($parameter);

    /**
     * Retrieves the value for a SESSION parameter and returns it.

     * @param string $parameter Name of parameter to return
     * @return mixed Returns either the value of the parameter or false if it
     * could not be found.
     */
    public function value($parameter);

    /**
     * Sets a value for a SESSION parameter.
     *
     * @param sting $parameter Name of parameter to set the value against
     * @param mixed $value value to be set
     */
    public function set($parameter, $value);

    /**
     * Removes an object from the session.
     *
     * @param string $parameter name of object to remove.
     */
    public function remove($parameter);
}

?>

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
 * Service that provides $_GET functionality.
 *
 * @package indyframework/services
 */

interface GetService extends ServiceInterface
{
    /**
     * Checks to see if the required parameter has is currently stored in $_GET.
     *
     * @param string $parameter Name of parameter to check
     * @return bool TRUE or FALSE
     */
    public function exists($parameter);

    /**
     * Retrieves the value for a GET parameter and returns it.
     *
     * @param string $parameter Name of parameter to return
     * @return mixed Returns either the value of the parameter or false if it
     * could not be found.
     */
    public function value($parameter);
}

?>

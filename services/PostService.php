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
 * Service that provides $_POST functionality
 *
 * @package indyframework/services
 */

interface PostService extends ServiceInterface
{
    /**
     * Checks to see if the required parameter has is currently stored in $_POST.
     *
     * @param string $parameter Name of parameter to check
     * @return bool TRUE or FALSE
     */
    public function exists($parameter);

    /**
     * Retrieves the value for a POST parameter and returns it.
     *
     * @param string $parameter Name of parameter to return
     * @return mixed  Returns either the value of the parameter or false if it
     * could not be found.
     */
    public function value($parameter);

    /**
     * Returns all the values on the POST as an array.
     *
     * @return array all the data that is held by the POST.
     */
    public function allValues();
}

?>

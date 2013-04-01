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
 * Service that provider $_COOKIE functionality.
 *
 * @package indyframework/services
 */

interface CookieService extends ServiceInterface
{
    /**
     * Checks to see if the required parameter has is currently stored in $_COOKIE.
     *
     * @param string $parameter Name of parameter to check
     * @return bool TRUE or FALSE
     */
    public function exists($parameter);

    /**
     * Returns the value of the cookie with the passed name.
     *
     * @param string $name name of cookie
     * @return string
     */
    public function value($name);

    /**
     * Requests that a cookie should be set. Not this does not guarantee that a
     * user excepts the cookie.
     *
     * @param string $name name of the cookie you want to set
     * @param string $value value to be set against the cookie
     * @return boolean TRUE OR FALSE
     */
    public function set($name, $value);

    /**
     * Request that a cookie should be set. Not this does not guarantee that a user
     * excepts the cookie.
     *
     * @param string $name name of the cookie you want to set
     * @param string $value value to be set against the cookie
     * @param <type> $expire when the cookie should expire
     * @return bool TRUE OR FALSE
     */
    public function setWithExpiry($name, $value, $expire);

    /**
     * Requests that a cookie should be deleted
     *
     * @param string $name name of cookie to be delete
     * @return bool TRUE OR FALSE
     */
    public function delete($name);
}

?>

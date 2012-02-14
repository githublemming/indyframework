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
 * Implementation of the CookieService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'CookieService.php';

class CookieServiceProvider implements ProviderInterface, CookieService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('CookieService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the CookieService interface
    ////////////////////////////////////////////////////////////////////////////
    public function exists($parameter)
    {
        $exists = false;

        global $HTTP_COOKIE_VARS;

        if (isset($_COOKIE) && isset($_COOKIE[$parameter]))
        {
            $exists = true;
        }
        elseif (isset($HTTP_COOKIE_VARS) && isset($HTTP_COOKIE_VARS[$parameter]))
        {
            $exists = true;
        }

        return $exists;
    }

    public function value($name)
    {
        global $HTTP_COOKIE_VARS;

        if (isset($_COOKIE) && isset($_COOKIE[$name]))
        {
            return ($_COOKIE[$name]);
        }
        elseif (isset($HTTP_COOKIE_VARS) && isset($HTTP_COOKIE_VARS[$name]))
        {
            return ($HTTP_COOKIE_VARS[$name]);
        }
        else
        {
            return false;
        }
    }

    public function set($name, $value)
    {
        return $this->setWithExpiry($name, $value, 0);
    }

    public function setWithExpiry($name, $value, $expire)
    {
        return setcookie($name, $value, $expire);
    }

    public function delete($name)
    {
        return $this->setWithExpiry($name, '', 1);
    }
}

?>

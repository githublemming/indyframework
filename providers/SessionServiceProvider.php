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
 * Implmentation of the SessionService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'SessionService.php';

/**
 * Implmentation of the SessionService.
 */
class SessionServiceProvider implements ProviderInterface, SessionService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('SessionService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the SessionService interface
    ////////////////////////////////////////////////////////////////////////////
    public function start()
    {
        global $HTTP_SESSION_VARS;

        if (!isset($_SESSION) && !isset($HTTP_SESSION_VARS))
        {
            session_start();
        }
    }

    public function exists($parameter)
    {
        $sessionContains = false;

        global $HTTP_SESSION_VARS;

        if (isset($_SESSION) && isset($_SESSION[$parameter]))
        {
            $sessionContains = true;
        }
        elseif (isset($HTTP_SESSION_VARS) && isset($HTTP_SESSION_VARS[$parameter]))
        {
            $sessionContains = true;
        }

        return $sessionContains;
    }

    public function value($parameter)
    {
        global $HTTP_SESSION_VARS;

        if (isset($_SESSION) && isset($_SESSION[$parameter]))
        {
            return ($_SESSION[$parameter]);
        }
        elseif (isset($HTTP_SESSION_VARS) && isset($HTTP_SESSION_VARS[$parameter]))
        {
            return ($HTTP_SESSION_VARS[$parameter]);
        }
        else
        {
            return false;
        }
    }

    public function set($parameter, $value)
    {
        global $HTTP_SESSION_VARS;

        if (isset($_SESSION))
        {
            $_SESSION[$parameter] = $value;
            $HTTP_SESSION_VARS[$parameter] = $value;
        }
        else
        {
            $HTTP_SESSION_VARS[$parameter] = $value;
        }
    }

    public function remove($parameter)
    {
        global $HTTP_SESSION_VARS;

        if (isset($_SESSION))
        {
            unset($_SESSION[$parameter]);
            unset($parameter);
        }
        else
        {
            session_unregister($parameter);
        }
    }
}

?>

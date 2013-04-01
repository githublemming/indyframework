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
 * Implementation of the GetService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'GetService.php';

class GetServiceProvider implements ProviderInterface, GetService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('GetService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the GetService interface
    ////////////////////////////////////////////////////////////////////////////
    public function exists($parameter)
    {
        $exists = false;

        global $HTTP_GET_VARS;

        if (isset($_GET) && isset($_GET[$parameter]))
        {
            $exists = true;
        }
        elseif (isset($HTTP_GET_VARS) && isset($HTTP_GET_VARS[$parameter]))
        {
            $exists = true;
        }

        return $exists;
    }

    public function value($parameter)
    {
        global $HTTP_GET_VARS;

        if (isset($_GET) && isset($_GET[$parameter]))
        {
            return ($_GET[$parameter]);
        }
        elseif (isset($HTTP_GET_VARS) && isset($HTTP_GET_VARS[$parameter]))
        {
            return ($HTTP_GET_VARS[$parameter]);
        }
        else
        {
            return false;
        }
    }
}

?>

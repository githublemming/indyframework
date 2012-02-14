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
 * Implementation of the HTTPService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'HTTPService.php';
require_once INDY_EXTERNAL . 'geoip.inc';

class HTTPServiceProvider implements ProviderInterface, HTTPService
{
    private $dataFile;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('HTTPService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                $this->dataFile = INDY_EXTERNAL . 'GeoIP.dat';
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the HTTPService interface
    ////////////////////////////////////////////////////////////////////////////
    public function ipCountry($ip)
    {
        $gi = geoip_open($this->dataFile, GEOIP_STANDARD);

        return geoip_country_code_by_addr($gi, $ip);
    }

    public function isAjaxRequest()
    {
        $ajaxRequest = false;

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']))
        {
            $ajaxRequest = true;
        }

        return $ajaxRequest;
    }

    public function referer()
    {
        $referer;

        if (isset($_SERVER) && isset($_SERVER['HTTP_REFERER']))
        {
            $referer =  $_SERVER['HTTP_REFERER'];
        }
        elseif (isset($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_REFERER']))
        {
            $referer =  $HTTP_SERVER_VARS['HTTP_REFERER'];
        }

        return $referer;
    }

    public function currentURL()
    {
         $pageURL = 'http';
         if ($_SERVER["HTTPS"] == "on")
         {
             $pageURL .= "s";
         }

         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80")
         {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         }
         else
         {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
         }

         return $pageURL;
    }

    public function remoteAddr()
    {
        $remoteAddr;

        if (isset($_SERVER) && isset($_SERVER['REMOTE_ADDR']))
        {
            $remoteAddr =  $_SERVER['REMOTE_ADDR'];
        }
        elseif (isset($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_ADDR']))
        {
            $remoteAddr =  $HTTP_SERVER_VARS['REMOTE_ADDR'];
        }

        return $remoteAddr;
    }

    public function remoteHost()
    {
        $remoteHost;

        $remoteAddr = $this->remoteAddr();

        if (isset($_SERVER) && isset($_SERVER['REMOTE_HOST']))
        {
            $remoteHost =  $_SERVER['REMOTE_HOST'];
        }
        elseif (isset($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_HOST']))
        {
            $remoteHost =  $HTTP_SERVER_VARS['REMOTE_HOST'];
        }

        if ($remoteHost == $remoteAddr)
        {
            $remoteHost = gethostbyaddr($remoteAddr);
        }

        return $remoteHost;
    }

    public function userAgent()
    {
        $browser;

        if (isset($_SERVER) && isset($_SERVER['HTTP_USER_AGENT']))
        {
            $browser =  $_SERVER['HTTP_USER_AGENT'];
        }
        elseif (isset($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']))
        {
            $browser =  $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
        }

        return $browser;
    }
}

?>

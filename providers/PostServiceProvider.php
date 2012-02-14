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
 * Implementation of the PostService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'PostService.php';

class PostServiceProvider implements ProviderInterface, PostService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('PostService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the PostService interface
    ////////////////////////////////////////////////////////////////////////////
    public function exists($parameter)
    {
        $exists = false;

        global $HTTP_POST_VARS;

        if (isset($_POST) && isset($_POST[$parameter]))
        {
            $exists = true;
        }
        elseif (isset($HTTP_POST_VARS) && isset($HTTP_POST_VARS[$parameter]))
        {
            $exists = true;
        }

        return $exists;
    }

    public function value($parameter)
    {
        global $HTTP_POST_VARS;

        if (isset($_POST) && isset($_POST[$parameter]))
        {
            return ($_POST[$parameter]);
        }
        elseif (isset($HTTP_POST_VARS) && isset($HTTP_POST_VARS[$parameter]))
        {
            return ($HTTP_POST_VARS[$parameter]);
        }
        else
        {
            return false;
        }
    }

    public function allValues()
    {
        $data = array();

        foreach ($_POST as $key => $value)
        {
            $data[$key] = $value;
        }

        return $data;
    }
}

?>

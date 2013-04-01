<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * ServiceProvider.php
 *
 * Contains the ServiceProvider class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * A wrapper class for a provider stored in the Service Respository.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

class ServiceProvider
{
    private $id;
    private $service;
    private $provider;

    public function  __construct($id, $serviceName, ProviderInterface &$provider)
    {
        $this->id = $id;
        $this->service = $serviceName;
        $this->provider = $provider;
    }

    public function getID() {
        return $this->id;
    }

    public function getServiceName()
    {
        return $this->service;
    }

    public function getProvider()
    {
        return $this->provider;
    }
}

?>

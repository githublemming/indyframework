<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 */

/**
 * A wrapper class for a provider stored in the Service Respository.
 *
 * @package indyframework/core
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

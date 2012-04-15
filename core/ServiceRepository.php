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
 * The Service Repository hold all providers that have been loaded into the
 * application.
 *
 * @package indyframework/core
 */

require_once 'ServiceProvider.php';


class ServiceRepository
{
    private $services = array();

    private $logger;

    /**
     * Default construct called when class is instantiated.
     */
    public function  __construct()
    {
        $this->logger = Logger::getLogger();
    }

    /**
     * Adds a provider to the repository.
     * 
     * @param String $serviceName Name of the service the class provides
     * @param ProviderInterface $provider the object that provides the
     * implementation of the service.
     */
    public function registerService($serviceName, ProviderInterface &$provider)
    {
        $id = $provider->indyframeworkprovideridentifier;
        
        $serviceProvider = new ServiceProvider($id, $serviceName, $provider);

        $this->services[] = $serviceProvider;
    }

    /**
     * Returns a provider for the named service. The provider that is requesting
     * the service is passed in so that we only return a provider that is higher
     * above it in the application config. This also helps to ensure that we
     * don't return itself if multiple providers are registered with the same
     * service. If we return an instance of the requesting provider then we'll
     * get an endless loop.
     * 
     * @param String $serviceName name of service that is required.
     * @param ProviderInterface $provider the provider requesting the service.
     * @return ProviderInterface an implemetation of the required Service.
     */
    public function requireService($serviceName, ProviderInterface &$provider)
    {           
        $id = "default";
        
        // need to check if the provider requesting the service needs a particular
        // version of the service using the ID
        if (isset($provider->indyframeworkproviderreferences)) {
            $preferredServices = $provider->indyframeworkproviderreferences;

            if (array_key_exists($serviceName, $preferredServices)) {

                $id = $preferredServices[$serviceName];
            } 
        }
        
        $reversedServices = array_reverse($this->services);

        $requestingProviderFound = false;

        foreach($reversedServices as $serviceProvider)
        {
            if ($requestingProviderFound == true)
            {
                if (strcmp ($serviceProvider->getServiceName(), $serviceName) == 0 &&
                    strcmp ($serviceProvider->getID(), $id) == 0) {
                    
                    return $serviceProvider->getProvider();
                }
            }

            if ($serviceProvider->getProvider() == $provider)
            {
                $requestingProviderFound = true;
            }
        }

        $this->logger->log(Logger::LOG_LEVEL_CRITICAL, 'ServiceRepository', "Unknown Service requested [$serviceName] with id [$id]", null);

        throw new ServiceRepositoryException("Unknown Service requested $serviceName with id $id");
    }

    /**
     * returns all the registered services.
     * 
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }
}

?>

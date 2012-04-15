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
 * Abstract Base class that all ApplicationLoader implementations should extend.
 *
 * @package indyframework/core
 */

abstract class BaseApplicationLoader
{
    protected $serviceRepository;

    protected $logger;

    // Abstract method declarations
    protected abstract function prepareApplication();


    /**
     * Default constructor.
     * Creates a ServiceRepository to store the providers in, and then parses
     * the application config file.
     */
    public function __construct()
    {
        $this->serviceRepository = new ServiceRepository();

        $this->logger = Logger::getLogger();
        
        $this->prepareApplication();
    }

    /**
     * Loads the Runnable class that will utilise the providers loaded from
     * the application config file.
     *
     * @param IndyRunnableInterface $providerObject
     */
    public function loadRunnable(RunnableInterface &$runnable)
    {
        $runnable->indyframeworkprovideridentifier = "default";
        
        $this->loadService($runnable);
        $runnable->applicationEvent($this->serviceRepository, APPLICATION_INIT);
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// PROTECTED METHODS
    ////////////////////////////////////////////////////////////////////////////
    protected function initialisedProviders()
    {
        $services = $this->serviceRepository->getServices();

        foreach($services as $serviceProvider)
        {
            $provider = $serviceProvider->getProvider();

            $provider->applicationEvent($this->serviceRepository, APPLICATION_INIT);
        }
    }

    protected function loadProvider($providerRef)
    {
        $providerFilePath = $this->getAbsoluteFilePathName($providerRef);

        if (file_exists($providerFilePath))
        {
            require_once $providerFilePath;

            $provider = $this->getProvider($providerRef);
            $providerObject = new $provider();
            $this->loadService($providerObject);
        }
        else
        {
            unset($providerFilePath);

            $this->logger->log(Logger::LOG_LEVEL_CRITICAL, 'Application Loader', "Unable to load $providerFilePath : Can't find it", null);

            throw new ApplicationException("Unable to load $providerFilePath : Can't find it");
        }
    }

    protected function getProvider($line)
    {
        // get the last period from the string and return the text after it
        // that should be the name of the provider
        $lastPeriod = strrpos($line, '.');

        $start = $lastPeriod + 1;
        $end = strlen($line) - $start;

        $provider = substr($line, $start, $end);

        return $provider;
    }

    protected function getAbsoluteFilePathName($line)
    {
        $line = str_replace('.', "/", $line);
        $providerFile = $line . '.php';

        if (strpos($providerFile, 'indyframework') === 0)
        {
            $len = strlen($providerFile) - 12;
            $providerFile = substr($providerFile, 14, $len);

            $providerFile = INDY_PATH . $providerFile;
        }
        else
        {
            $providerFile = APPLICATION_PATH . $providerFile;
        }
        
        return $providerFile;
    }

    protected function loadService(&$providerObject)
    {
        $reflectionObject = new ReflectionObject($providerObject);

        if ($this->isServiceCompatible($reflectionObject))
        {
            // tell the provider to register itself with the
            // reposistory
            $reflectionMethod = $reflectionObject->getMethod('applicationEvent');
            $reflectionMethod->invokeArgs($providerObject, array($this->serviceRepository, APPLICATION_LOAD));
        }
        else
        {
            $name = $reflectionObject->getName();

            unset($providerFilePath);
            unset($provider);
            unset($providerObject);
            unset($reflectionObject);

            $this->logger->log(Logger::LOG_LEVEL_CRITICAL, 'Application Loader', "$name does not conform to Provider rules", null);

            throw new ApplicationException("$name does not conform to Provider rules");
        }
    }

    protected function isServiceCompatible($reflectionObject)
    {
        $compatable = false;

        // all providers must implement the IndyProviderInterface so we'll check
        // if that has been implemented
        $compatable = $reflectionObject->implementsInterface('ProviderInterface');

        // need to check that it implments a Service, and seen as all services
        // have to implemnt IndyServiceInterface we'll check for that one
        $compatable = $reflectionObject->implementsInterface('ServiceInterface');

        // now all providers have to be able to register themselves, and they
        // use the registerService method to do that so we'll check of that
        // function exists.
        $compatable = ($compatable and $reflectionObject->hasMethod('applicationEvent'));

        return $compatable;
    }
}

?>

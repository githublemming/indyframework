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
 * Application loader that reading in an XML file and builds the application
 *
 * Parses the application.xml file and loads all the of the providers into the
 * service repository.
 *
 *
 * @package indyframework/core
 */

require_once 'BaseApplicationLoader.php';

/**
 * Application loader that reading in an XML file and builds the application
 */
class ApplicationXMLLoader extends BaseApplicationLoader
{
    protected function prepareApplication()
    {
        $this->loadProviders();
        
        $this->initialisedProviders();
    }

    private function loadProviders()
    {
        if(! $xml = simplexml_load_file(APPLICATION_CONFIG))
        {
            $this->logger->log(Logger::LOG_LEVEL_CRITICAL,
                               'Application Loader',
                               "Unable to load " . APPLICATION_CONFIG,
                               null);

            throw new ApplicationException("Unable to load " . APPLICATION_CONFIG);
            
        }
        else
        {
            foreach( $xml as $provider )
            {
                $providerFilePath = "DEFINE";

                $providerAttribs = $provider->attributes();
                $name = $providerAttribs['name'];
                $id = "default";
                
                if (isset($providerAttribs['id'])) {
                    $id = $providerAttribs['id'];
                }
                
                // First load the provider
                $providerFilePath = $this->getAbsoluteFilePathName($name);

                // check if provider file exists
                if (file_exists($providerFilePath))
                {
                    require_once $providerFilePath;

                    $providerClass = $this->getProvider($name);
                    $providerObject = new $providerClass();
                    
                    $providerObject->indyframeworkprovideridentifier = $id;
                    
                    $this->loadService($providerObject);

                    // now apply any properties to it as appropriate
                    foreach($provider->children() as $property)
                    {
                        $propertyAttribs = $property->attributes();

                        $name = $propertyAttribs['name'];
                                                
                        if (isset($propertyAttribs['ref'])) {
                            
                            $ref = $propertyAttribs['ref'];
                            
                            $providerObject->indyframeworkproviderreferences[(string)$name] = $ref;
                            
                        } else {
                            
                            $value = $propertyAttribs['value'];
                            
                            $reflectionObject = new ReflectionObject($providerObject);
                            $reflectionMethod = $reflectionObject->getMethod('set'. $name);
                            $reflectionMethod->invokeArgs($providerObject, array($value));
                        }
                    }
                }
                else
                {
                    unset ($providerFilePath);

                    $this->logger->log(Logger::LOG_LEVEL_CRITICAL,
                                       'Application Loader',
                                       "Unable to load [ $name ]",
                                       null);
                    
                    throw new ApplicationException("Unable to load  [ $name ]");
                }
            }
        }
    }
}

// creates an instance of the ApplicationLoader class. In doing so starts the
// process of loading providers into the Service Repository.
global $appLoader;
$appLoader = new ApplicationXMLLoader();

?>

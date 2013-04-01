<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * ApplicationFlatFileLoader.php
 *
 * File contains the ApplicationFlatFileLoader class
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/loader
 */

/**
 * Indy Framework application loader utility class that reads a flat file to
 * get the list of required providers.
 *
 * Parses the application.cfg file and loads all the of the providers into the
 * service repository.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/loader
 * 
 * @deprecated This file has now been deprecated, all application definitions
 * should now in XML format, and ApplicationXMLLoader should be used to read it.
 *
 */
class ApplicationFlatFileLoader extends BaseApplicationLoader
{
    protected function prepareApplication()
    {
        $this->loadProviders();
        
        $this->initialisedProviders();
    }

    private function loadProviders()
    {
        // need to perform a check that the file exists first.
        
        $lines = file(APPLICATION_DEFINITION);

        foreach ($lines as $line)
        {
            $line = trim($line);

            if ($this->isProviderLine($line))
            {
                $providerFilePath = $this->getAbsoluteFilePathName($line);

                // check if provider file exists
                if (file_exists($providerFilePath))
                {
                    require_once $providerFilePath;

                    $provider = $this->getProvider($line);
                    $providerObject = new $provider();
                    $this->loadService($providerObject);
                }
                else
                {
                    unset($providerFilePath);

                    throw new ApplicationException("Unable to load $line : Can't find it");
                }
            }
        }
    }

    private function isProviderLine($line)
    {
        $isProviderLine = false;

        $firstChar = substr($line, 0, 1);

        if ($firstChar >= chr(97) && $firstChar <= chr(122))
        {
            $isProviderLine = true;
        }

        return $isProviderLine;
    }
}

// creates an instance of the ApplicationLoader class. In doing so starts the
// process of loading providers into the Service Repository.
global $appLoader;
$appLoader = new ApplicationFlatFileLoader();

?>

<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'GoogleService.php';

/**
 * Implementation of the FileService.
 */
class GoogleServiceProvider implements ProviderInterface, GoogleService
{
    private $googleMapAPIKey;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('GoogleService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setGoogleMapAPIKey($apiKey)
    {
        $this->googleMapAPIKey = $apiKey;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the GoogleService interface
    ////////////////////////////////////////////////////////////////////////////
    public function getMap($longLat)
    {

    }

}

?>

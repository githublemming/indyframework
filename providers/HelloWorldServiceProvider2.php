<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'HelloWorldService.php';

/**
 * Test implementation of the HelloWorldService.
 * This does nothing more than return World !!.
 * It is used along with HelloWorldServiceProvider to demonstrate chaining
 * services together.
 */
class HelloWorldServiceProvider2 implements ProviderInterface, HelloWorldService
{
    private $world;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                // Registers itself with the Service Respository as a provider
                // of the HelloWorldService.
                $serviceRepository->registerService('HelloWorldService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setWorld($world)
    {
        $this->world = $world;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the HelloWorldService interface
    ////////////////////////////////////////////////////////////////////////////
    public function sayHello()
    {
        return $this->world;
    }
}

?>

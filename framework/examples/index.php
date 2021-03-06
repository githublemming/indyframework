<?php

/**
 * This is an example of a provider file that
 * 1. is added to the application
 * 2. requests a service that it needs to function correctly
 * 3. outputs (echos) a message.
 */

require_once 'indyframework/loadApplication.php';

class ExamplePageProvider implements ProviderInterface, RunnableInterface
{
    private $prefix;

    // local variable for holding a reference to the HelloWorldService
    private $helloWorldService;

    ////////////////////////////////////////////////////////////////////////////
    ///// ProviderInterface functions
    ////////////////////////////////////////////////////////////////////////////
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                // Only providers that are registerd with the service repository
                // are able to request services, so we add ourselves.
                $serviceRepository->registerService('RunnableInterface', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                // Requesting the HelloWorldService from the service repository
                $this->helloWorldService = $serviceRepository->requireService('HelloWorldService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setHelloPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// RunnableInterface functions
    ////////////////////////////////////////////////////////////////////////////
    public function run()
    {
        // just echo the message to the output
        echo $this->prefix . ' ' . $this->helloWorldService->sayHello();
    }
}

$pageProvider = new ExamplePageProvider();

run($pageProvider);

?>
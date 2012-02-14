<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'HelloWorldService.php';

/**
 * Test implementation of the HelloWorldService.
 * This does nothing more than return
 * Hello World!.
 * The world part of the message is requested from another implementation of the
 * HelloWorldSerice that is above it somewhere in the Application Configuration.
 * This is an example of defining multiple providers of the same Service.
 * Another example of this might be to place a cache infront of a database to
 * improve performance.
 */
class HelloWorldServiceProvider implements ProviderInterface, HelloWorldService
{
    private $hello;

    private $helloWorldService;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                // Registers itself as a provider of the HelloWorldService.
                $serviceRepository->registerService('HelloWorldService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                // Requests another HelloWorldService from the Service Repository
                // This one would sit higher up the Application Config file.
                $this->helloWorldService = $serviceRepository->requireService('HelloWorldService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////

    /**
     * Called after the Provider has been loaded by the application loader, and
     * before the application loader calls initialisation.
     * The value that is passed in is taken from the application.xml file and is
     * a property associated with the provider
     *
     * <property name="Hello" value="Hello"/>
     */
    public function setHello($hello)
    {
        $this->hello = $hello;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the HelloWorldService interface
    ////////////////////////////////////////////////////////////////////////////
    public function sayHello()
    {
        // Using another provider of the HelloWorldService to complete the message.
        $msg = $this->hello. ' '  . $this->helloWorldService->sayHello();

        return $msg;
    }
}

?>

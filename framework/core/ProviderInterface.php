<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * ProviderInterface.php
 *
 * Contains the ProviderInterface interface.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * This interface must be implemented by all Providers.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */
interface ProviderInterface {
    
    /**
     * Message about the state of the application will be recieved via this
     * function.
     * Possible events that can be received are
     * - APPLICATION_LOAD
     * - APPLICATION_INIT
     * - APPLICATION_VIEW
     * 
     * @param ServiceRepository $serviceRepository a reference to the service repository
     * @param <type> $event the current event
     */
    public function applicationEvent(ServiceRepository $serviceRepository, $event);
}

?>

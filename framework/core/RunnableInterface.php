<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * RunnableInterface.php
 *
 * Contains the RunnableInterface interface.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * Marker interface that identifies the Runnable provider.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

interface RunnableInterface extends ServiceInterface {
    
    /**
     * Called after the provider has been loaded and added to the Service Repository.
     */
    public function run();
}

?>

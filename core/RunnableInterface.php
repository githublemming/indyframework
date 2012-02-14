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
 * Marker interface that identifies the Runnable provider.
 *
 * @package indyframework/core
 */

interface RunnableInterface extends ServiceInterface
{
    /**
     * Called after the provider has been loaded and added to the Service Repository.
     */
    public function run();
}

?>

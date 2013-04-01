<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Engine.php
 *
 * Contains the abstract Engine.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 * 
 */

/**
 * Indy Framework Base Engine.
 *
 * An abstract class that all Engines should extend.
 * 
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 */
abstract class Engine
{
	protected $logger;
	
    /**
     * Default contructor. Gets and stores an instance of the logger. 
     */
	public function __construct() {
	
		$this->logger = Logger::getLogger();
	}
	
    /**
     * Removes any Quotation marks from the passed String if they are present.
     * 
     * "${value}" becomes ${value}
     * 
     * 
     * @param string $dollarNotation Dollar Notication to strip quotation marks from.
     * @return string Dollar Notation that has had any quotation marks removed
     */
    protected function stripQuotes($dollarNotation)
    {
        return str_replace('"', '', trim($dollarNotation));
    }
    
    /**
     * Removes the dollar notation from around the passed value.
     * 
     * ${value} becomes value
     * 
     * @param string $value value to remove Dollar Notation from
     * @return string stripped value.
     */
    protected function stripDollarNotation($value)
    {
        $value = str_replace('${', '', trim($value));
        $value = str_replace('}', '', $value);
        
        return $value;
    }
}

?>

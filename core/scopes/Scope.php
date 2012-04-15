<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 */

/**
 * Indy Framework Scope interface.
 * 
 * All Scopes should implement this interface.
 *
 * @package indyframework/core
 */

interface Scope
{
	/**
	 * Sets the value on the scope with the attribute as the key
	 * 
	 * @param String $attribute
	 * @param Mixed $value
	 */
    public function setAttribute($attribute, $value);
    
    /**
     * returns the value of the attribute.
     * 
     * @param String $attribute
     * @param Mixed $value
     */
    public function getAttribute($attribute);
    
    /**
     * Checks if the attribute exists in the Scope.
     * 
     * @param boolean $attribute
     */
    public function attributeExists($attribute);
    
    /**
     * Requests that the attribute be removed from the Scope.
     * 
     * @param unknown_type $attribute
     */
    public function removeAttribute($attribute);
}
?>

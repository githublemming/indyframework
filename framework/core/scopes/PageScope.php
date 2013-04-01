<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Scope.php
 *
 * File contains the PageScope class
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/scope
 */

/**
 * Indy Framework PageScope class.
 *
 * Single class that holds all variables that are required as part of the page
 * scope.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/scope
 */

require_once INDY_CORE . '/scopes/Scope.php';

class PageScope implements Scope {
	    
    public function setAttribute($attribute, $value)
    {
        $this->$attribute = $value;
    }
    
    public function getAttribute($attribute)
    {
        return $this->$attribute;
    }
    
    public function attributeExists($attribute)
    {
        $attributeExists = false;
        
        if (isset ($this->$attribute))
        {
            $attributeExists = true;
        }
        
        return $attributeExists;
    }
    
    public function removeAttribute($attribute)
    {
        $this->$attribute = null;
        
        unset($attribute);
    }
}

?>
<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.marksdevserver.com
 */

/**
 * Indy Framework PageScope class.
 *
 * Single class that holds all variables that are required as part of the page
 * scope.
 *
 * @package indyframework/core
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
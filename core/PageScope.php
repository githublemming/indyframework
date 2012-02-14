<?php

require_once INDY_CORE . '/scopes/Scope.php';

/**
 * Single class that holds all variables that are required as part of the page
 * scope.
 */
class PageScope implements Scope
{    
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
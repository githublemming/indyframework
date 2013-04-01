<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * PageContext.php
 *
 * File contains the PageContext class
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/page
 */

/**
 * Indy Framework PageContext class.
 *
 * Single class that holds all variables that are required as part of the page
 * scope. It contains the page itself.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/page
 */
class PageContext {
	    
    private $page;
    
    public function setPage($page) {
        
        $this->page = $page;
    }
    public function getPage() {
        
        return $this->page;
    }
    
    public function setAttribute($attribute, $value)  {
        
        $this->$attribute = $value;
    }
    public function getAttribute($attribute) {
        
        return $this->$attribute;
    }
    
    public function attributeExists($attribute) {
        
        $attributeExists = false;
        
        if (isset ($this->$attribute)) {
            
            $attributeExists = true;
        }
        
        return $attributeExists;
    }
    
    public function removeAttribute($attribute) {
        
        $this->$attribute = null;
        
        unset($attribute);
    }
}
?>

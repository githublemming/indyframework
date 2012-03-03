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
 * Indy Framework Set Tag.
 *
 * Tag that prints a value that is stored in the pagescope to the page.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/SimpleTag.php';

class OutTag extends SimpleTag
{
    protected $value;
    
    protected $default;
    
    public function doTag()
    {
        $out = $this->value;
        
        if (!$this->isValueSet())
        {
            $out = $this->getDefaultValue();
        }
        
        $this->out($out);
    }
    
    private function isValueSet()
    {
        $valueSet = true;
        
        if(!isset ($this->value) ||
           strlen($this->value) == 0)
        {
            $valueSet = false;
        }
        
        return $valueSet;
    }
    
    private function getDefaultValue()
    {
        $defaultValue = $this->default;
        
        if(!isset ($this->default) ||
           strlen($this->default) == 0)
        {
            $defaultValue = "";
        }
                
        return $defaultValue;
    }
}

?>

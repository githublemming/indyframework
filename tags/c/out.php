<?php

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

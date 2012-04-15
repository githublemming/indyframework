<?php

require_once INDY_TAGS . '/Tag.php';

abstract class SimpleTag implements Tag {
        
 protected $pageScope;
    
    public abstract function doTag();

 
    public function __construct($tag, &$pageScope) 
    {                
        $this->pageScope = $pageScope;
    }
    
    public function run()
    {
        return $this->doTag();
    }
    
    protected function out($value)
    {                
        echo $value;
    }
    
    protected function getELParser() {
    
    	return new EL_Engine($this->pageScope);
    }
        
    
    // Not happy that this is public !!!
    public function setAttribute($attribute, $value) {
            	
        $this->$attribute = $value;
    }
}
?>

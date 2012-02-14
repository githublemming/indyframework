<?php

require_once INDY_TAGS . '/Tag.php';

abstract class SimpleTag implements Tag
{    
    private $buffer = array();
        
    protected $pageScope;
    
    public abstract function doTag();

 
    public function __construct($tag, &$pageScope) 
    {                
        $this->pageScope = $pageScope;
    }
    
    public function run()
    {
        $this->doTag();
        
        $output = implode($this->buffer);
        
        $view = new View($this->pageScope);
        $out = $view->load($output);
                
        return $out;
    }
    
    protected function out($value)
    {        
        $this->buffer[] = $value;
    }
        
    
    // Not happy that this is public !!!
    public function setAttribute($attribute, $value) {
        
        $this->$attribute = $value;
    }
}
?>

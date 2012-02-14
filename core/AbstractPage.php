<?php

class AbstractPage
{
    private $pageScope;
    private $view;
    
    private $viewfile;
    
    function __construct() {
        
        $this->pageScope = new PageScope();
        $this->view = new View($this->pageScope);
    }
    
    public function setView($view) {
        
        $this->viewfile = $view;
    }
    
    public function setAttribute($attribute, $value) {
        
        $this->pageScope->setAttribute($attribute, $value);
        
    }
    
    public function display() {
        
        $this->view->display($this->viewfile);
    }
}

?>

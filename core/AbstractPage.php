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
 * Pages, that is top level PHP files that provide a web page e.g. index.php,
 * should extend this abstract class.
 *
 * @package indyframework/core
 */
 
class AbstractPage {
	
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

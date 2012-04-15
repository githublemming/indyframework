<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 */

/**
 * Pages, that is top level PHP files that provide a web page e.g. index.php,
 * should extend this abstract class.
 *
 * @package indyframework/core
 */
 
abstract class AbstractPage {
	
    private $pageContext;
        
    function __construct() {
        
        $this->pageContext = new PageContext();
    }
    
    public function setView($view) {
        
        $this->pageContext->setPage($view);
    }
    
    public function setAttribute($attribute, $value) {
        
        $this->pageContext->setAttribute($attribute, $value);
        
    }
    
    public function display() {
        
        $pageProcesor = PageProcessor::instance();
        $pageProcesor->processPage($this->pageContext);
    }
}

?>

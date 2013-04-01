<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * AbstractPage.php
 *
 * Contains the AbstractPage class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * All files that are designed to show a view, such as a web page like contact.php
 * should extend this abstract class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */
 
abstract class AbstractPage {
	
    /**
     * Reference to PageContext object.
     * @var PageContext 
     */
    private $pageContext;
    
    /**
     * Default contructor 
     */
    function __construct() {
        
        $this->pageContext = new PageContext();
    }
    
    /**
     * Sets the view that will be shown.
     * 
     * @param string $view 
     */
    public function setView($view) {
        
        $this->pageContext->setPage($view);
    }
    
    /**
     * Sets an attribute on the PageContext.
     * 
     * The name of the attribut should be unique. If you try and set two
     * attributes with the same name the first one will be overridden.
     * 
     * @param string $attribute name of attribute.
     * @param mixed $value value to key
     */
    public function setAttribute($attribute, $value) {
        
        $this->pageContext->setAttribute($attribute, $value);
        
    }
    
    /**
     * Processes and then displays the page. 
     */
    public function display() {
        
        $pageProcesor = new PageProcessor();
        $pageProcesor->processPage($this->pageContext);
    }
}

?>

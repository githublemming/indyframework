<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * View.php
 *
 * Contains the View class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */
/**
 * Indy Framework View class.
 *
 * Loads, parses and displays a view.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 * @deprecated This is no longer used and will be removed in the near future.
 */

class View
{
    private $REGEX_COMBINED;
        
    private $view;

    private $EL_Engine;
    private $TL_Engine;
    
    private $pageScope;
    
    private $logger;
    
    /**
     * Default Constructor.
     * 
     * @param Scope $pageScope reference to a Scope that holds values that might
     * be required by the view.
     */
    public function __construct(Scope &$pageScope = null)
    {
        $this->REGEX_COMBINED = "~" . 
                                REGEX_DOLLAR_NOTATION . "|" . 
                                REGEX_SIMPLE_TAG_PATTERN . "|" .
                                REGEX_BODY_TAG_PATTERN . "|" .
                                "~is";
                
        $this->pageScope = $pageScope;
        
        $this->logger = Logger::getLogger();
        
        $this->TL_Engine = new TL_Engine($this->pageScope);
        $this->EL_Engine = new EL_Engine($this->pageScope);
    }

	/**
	 * This function will load the view, process any tags, EL and PHP snippets and
	 * then display the page.
	 */
    public function display($fileName)
    {    	
    	if (file_exists($fileName)) {
    		
    		$view = file_get_contents($fileName);
    		$this->view = '?>' . $view;
    		
    		$this->processTags();
    		
    		eval ($this->view);
    		
    	} else {
    		
    		$this->displayError("Can't load view : " . $fileName);
    	}
    }
    
	/**
	 * This function will load the view, process any tags, EL and PHP snippets and
	 * then return the processed page as a string.
	 */
    public function load($snippet)
    {
        $this->view = $snippet; 
        
        $this->processTags(); 
        
        return $this->view;
    }
        
    ///////////////////////////////////////////////////////////////////////////
    ///// Private Functions
    ///////////////////////////////////////////////////////////////////////////
    private function processTags()
    {
        $dollarNotationPattern = "~" . REGEX_DOLLAR_NOTATION . "~i";
        $simpleTagPattern = "~" . REGEX_SIMPLE_TAG_PATTERN . "~i";
        $bodyTagPattern = "~" . REGEX_BODY_TAG_PATTERN . "~is";
     
        $tags = array();
        preg_match_all($this->REGEX_COMBINED, $this->view, $tags, PREG_SET_ORDER);
        
        foreach($tags as $tag)
        {  
            $result = "";
                 
            $tag = $tag[0];
                          
            if (strlen($tag) == 0) continue;
            
            if (preg_match($simpleTagPattern, $tag) || preg_match($bodyTagPattern, $tag))
            {
                $this->handleTag($tag);
            }
            else if (preg_match($dollarNotationPattern, $tag))
            {
                $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'View: processTags', "Found ExpLang [$tag]");
                $result = $this->EL_Engine->parse($tag);
            }
                        
            if (isset ($result))
            {
                $this->update($tag, $result);
            }
        }
    }
    
    private function handleTag($tag)
    {
        $tagInstance =  $this->TL_Engine->getTagInstance($tag);
        
        if ($tagInstance != null) {
        	
        	$tagInstance->run();
        }
    }
    
    private function update($tag, $value)
    {        
        $this->view = $this->str_replace_once($tag, $value, $this->view);
    }
    
    private function str_replace_once($str_pattern, $str_replacement, $string)
    {
        $updatedString = $string;
        
        if (strpos($string, $str_pattern) !== false)
        {
            $occurrence = strpos($string, $str_pattern);
            
            $updatedString = substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
        }
       
        return $updatedString;
    }
    
    private function displayError($message) {
    	
    	$scope = new PageScope();
    	$scope->setAttribute("Message", $message());
    	$scope->setAttribute("Exception", "");
    	
    	$errorView = new View($scope);
    	$errorView->display( INDY_PATH . "/view/error.view.php" );
    }
}
?>

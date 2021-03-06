<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * TL.php
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 */

/**
 * Indy Framework Tag Library Engine.
 *
 * Given a Tag as a string it attempts to find and load the tag into memory,
 * assigning any attributes before returning it.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 */

class TL_Engine extends Engine
{
    const TAG_SIMPLE = 1;
    const TAG_BODY   = 2;
    
    private $tagLibrary;
    private $dollarNotationEngine;
    
    private $pageContext;

    
    /**
     * Constructor takes a reference to a PageContext object.
     * @param PageContext $pageContext
     */
    public function __construct(PageContext &$pageContext)
    {        
    	parent::__construct();
    	
        $this->tagLibrary = TagLibrary::instance();
        $this->pageContext = $pageContext;
    }
    
    /**
     * Given a string that contains the HTML markup of the tag, this attempts
     * to find the tag, load it into memory and return the tag.
     * 
     * 
     * @param string $tag the HTML of the tag <c:If test="${10 > 5}">
     * @return \className Returns an instance of the tag
     */
    public function getTagInstance($tag)
    {        
        $tagInstance = null;
        
        $tagLibrary = $this->getTagLibraryName($tag);
        $tagName = $this->getTagName($tag);
        $tagDefinition = $this->getTagProperties($tag);
        $tagAttributes = $this->getTagAttributes($tagDefinition);
        
        $tagPath = $this->tagLibrary->getTag($tagLibrary, $tagName, $tagAttributes);
        
        if ($tagPath != null && file_exists($tagPath))
        {        	    
            require_once $tagPath;

            $className = ucfirst($tagName) . "Tag";
            $tagInstance = new $className($tag, $this->pageContext);
            
            $this->setAttributesOnTag($tagInstance, $tagDefinition);
            
        } else {
        	
        	$this->logger->log(Logger::LOG_LEVEL_WARNING, 'getTagInstance', "Unable to load Tag : $tag");
        }
        
        return $tagInstance;
    }
    
    private function getTagAttributes($simpleTag)
    {        
        $attributes = array();
        
        $parts = explode(":", $simpleTag);
        
        $tagName = $this->getTagName($simpleTag);
        $tagNameAndAttribs = $parts[1];
        $firstSpace = strpos($tagNameAndAttribs, " ");
        
        $attrString = trim(substr($tagNameAndAttribs, $firstSpace + 1, strlen($tagNameAndAttribs) - strlen($tagName)));
                
        if ($attrString !== "/")
        {       
            $dollarNotationPattern = "~" . REGEX_DOLLAR_NOTATION . "~i";
            $attribPattern = "~[a-z\d]+=\"[\w\d\s\.\'!<>=\+\-\*\/]+\"~i";
                        
            // if there is a slash at the end of the attributes remove it
            $pos = strpos($attrString, "/");
            if ($pos !== false)
            {
                $attrString = trim(substr($attrString, 0, strlen($attrString) - 1));
            }
            
            if (preg_match($dollarNotationPattern, $attrString))
            {
                if (!isset ($this->dollarNotationEngine))
                {
                    $this->dollarNotationEngine = new EL_Engine($this->pageContext);
                }
                
                $tags = array();
                preg_match_all($dollarNotationPattern, $attrString, $tags, PREG_SET_ORDER);
                foreach($tags as $attribute)
                {   
                    $attributes[] = $attribute[0];     
                }
            }
            
            // Now populate the array the attributes as Key / Value pairs
            $attribs = array();
            preg_match_all($attribPattern, $attrString, $attribs, PREG_SET_ORDER);
            foreach ($attribs as $a)
            {                            
                $attrib = $a[0];
                
                $posOfequals = strpos($attrib, "=");

                $key = substr($attrib, 0, $posOfequals);
                $attributes[] = $key;
            }
        }
                
        return $attributes;
    }
        
    
    private function setAttributesOnTag(&$tagInstance, $simpleTag) {
              
        $parts = explode(":", $simpleTag);
        
        $tagName = $this->getTagName($simpleTag);
        $tagNameAndAttribs = $parts[1];
        $firstSpace = strpos($tagNameAndAttribs, " ");
                
        $attrString = trim(substr($tagNameAndAttribs, $firstSpace + 1, strlen($tagNameAndAttribs) - strlen($tagName)));
                
        if ($attrString !== "/")
        {       
            $dollarNotationPattern = '~[a-z\d]+=\"' . REGEX_DOLLAR_NOTATION . '\"~i';
            $attribPattern = "~[a-z\d]+=\"[\w\d\s\.\'!<>=\+\-\*\/]+\"~i";
                        
            // if there is a slash at the end of the attributes remove it
            $pos = strpos($attrString, "/");
            if ($pos !== false)
            {
                $attrString = trim(substr($attrString, 0, strlen($attrString) - 1));
            }
                                    
            if (preg_match($dollarNotationPattern, $attrString))
            {
                
                if (!isset ($this->dollarNotationEngine))
                {
                    $this->dollarNotationEngine = new EL_Engine($this->pageContext);
                }
                
                $tags = array();
                preg_match_all($dollarNotationPattern, $attrString, $tags, PREG_SET_ORDER);
                foreach($tags as $attribute)
                {   
                    $attribute = $attribute[0];                    
                    $attribParts = explode("=", $attribute);
                    
                    $attribute = $attribParts[0];                    
                    $value = $this->dollarNotationEngine->parse($attribParts[1]);
                                        
                    $tagInstance->setAttribute($attribute, $value);
                }
            }
            
            // Now populate the array the attributes as Key / Value pairs
            $attribs = array();
            preg_match_all($attribPattern, $attrString, $attribs, PREG_SET_ORDER);
            foreach ($attribs as $a)
            {                 
                $attrib = $a[0];
                
                $posOfequals = strpos($attrib, "=");
                $key = substr($attrib, 0, $posOfequals);
                
                $attribute = strtolower($key);
                $value = $this->stripQuotes(substr($attrib, $posOfequals + 1));
                
                $tagInstance->setAttribute($attribute, $value);
            }
        } 
        
    }
    private function getTagLibraryName($simpleTag)
    {
        $parts = explode(":", $simpleTag);
        
        $libraryName = $parts[0];
        
        $len = strlen($libraryName);
        $libraryName = substr($libraryName, 1, $len - 1);
                
        return strtolower($libraryName);
    }
    
    private function getTagName($simpleTag)
    {
        $parts = explode(":", $simpleTag);
        
        $tagNameAndAttribs = $parts[1];
        
        $firstSpace = strpos($tagNameAndAttribs, " ");
        
        return substr($tagNameAndAttribs, 0, $firstSpace);
    }
    
    private function getTagProperties($simpleTag) {
        
        $tag = $simpleTag;
        
        $array = preg_split('/$\R?^/m', $simpleTag);
        if (count($array) > 1) {
            
            $tag = $array[0];
        }
        
        return $tag;
    }
}

?>
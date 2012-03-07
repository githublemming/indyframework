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
 * Indy Framework Tag Library Engine.
 *
 * Given a Tag as a string it attempts to find and load the tag into memory,
 * assigning any attributes before returning it.
 *
 * @package indyframework/core
 */

require_once 'Engine.php';

class TL_Engine extends Engine
{
    const TAG_SIMPLE = 1;
    const TAG_BODY   = 2;
    
    private $tagLibrary;
    private $dollarNotationEngine;
    
    private $pageScope;

    public function __construct(&$pageScope)
    {        
    	parent::__construct();
    	
        $this->tagLibrary = TagLibrary::instance();
        $this->pageScope = $pageScope;
    }
    
    public function getTagInstance($tag)
    {        
        $tagInstance = null;
        
        $tagLibrary = $this->getTagLibraryName($tag);
        $tagName = $this->getTagName($tag);
        $tagAttributes = $this->getTagAttributes($tag);
        
        $tagPath = $this->tagLibrary->getTag($tagLibrary, $tagName, $tagAttributes);

        if ($tagPath != null && file_exists($tagPath))
        {        	
            require_once $tagPath;

            $className = ucfirst($tagName) . "Tag";
            $tagInstance = new $className($tag, $this->pageScope);
            
            $this->setAttributesOnTag($tagInstance, $tag);
            
        } else {
        	
        	$this->logger->log(Logger::LOG_LEVEL_WARNING, 'getTagInstance', "Unable to load Tag : $tag");
        }
        
        return $tagInstance;
    }
    
    public function getTagAttributes($simpleTag)
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
            $attribPattern = "~[a-z\d]+=\"[\w\d\s!<>=\+\-\*\/]+\"~i";
                        
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
                    $this->dollarNotationEngine = new EL_Engine($this->pageScope);
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
                $keyValue = explode("=", $a[0]);

                $key = $keyValue[0];
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
            $attribPattern = "~[a-z\d]+=\"[\w\d\s\.!<>=\+\-\*\/]+\"~i";
                        
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
                    $this->dollarNotationEngine = new EL_Engine($this->pageScope);
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
                $keyValue = explode("=", $a[0]);

                $attribute = strtolower($keyValue[0]);
                $value = $this->stripQuotes($keyValue[1]);
                
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
}

?>
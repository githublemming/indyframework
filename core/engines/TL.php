<?php

class TL_Engine extends Engine
{
    const TAG_SIMPLE = 1;
    const TAG_BODY   = 2;
    
    private $tagLibrary;
    private $dollarNotationEngine;
    
    private $pageScope;

    public function __construct(&$pageScope)
    {        
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
        if ($tagPath != null)
        {
            require_once $tagPath;

            $className = ucfirst($tagName) . "Tag";
            $tagInstance = new $className($tag, $this->pageScope);
            
            $this->setAttributesOnTag($tagInstance, $tag);
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

                $key = strtolower($keyValue[0]);
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
        
        return strtolower(substr($tagNameAndAttribs, 0, $firstSpace));
    }
}

?>
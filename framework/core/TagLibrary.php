<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * TagLibrary.php
 *
 * Contains the TagLibrary class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * Indy Framework Tag Library class.
 *
 * The Tag Library holds all known tags.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

final class TagLibrary
{
    private static $instance;
    
    private $tagLibrary = array();
        
    private function __construct() {
    	$this->logger = Logger::getLogger();
    }
    
    public function instance()
    {
        if (!isset (self::$instance))
        {
            self::$instance = new TagLibrary();
        }
        
        return self::$instance;
    }

    public function getTag($tagLibrary, $tagName, $tagAttributes)
    {        
        $tagPath = null;
        
        if ($this->isValidTagLibrary($tagLibrary) && 
            $this->isTagPartOfLibrary($tagLibrary, $tagName) &&
            $this->doesTagMatchSignature($tagLibrary, $tagName, $tagAttributes))
        {      
            $tagsInLibrary = $this->tagLibrary[$tagLibrary];
            $tag = $tagsInLibrary[$tagName];
            
            $tagPath = $tag->getPath() . "/" . $tagName . ".php";            
        }
        
        return $tagPath;
    }
    
    private function isValidTagLibrary($libraryName)
    {    
        $isValidTagLibrary = true;
        
        if (!array_key_exists($libraryName, $this->tagLibrary))
        {
            $isValidTagLibrary = $this->loadLibraryDefinition($libraryName);
        }

        $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'isValidTagLibrary', "$libraryName : $isValidTagLibrary");
        
        return $isValidTagLibrary;  
    }
    
    private function isTagPartOfLibrary($libraryName, $tagName)
    {        
        $isTagPartOfLibrary = false;
        
        if (!array_key_exists($libraryName, $this->tagLibrary))
        {
            $this->loadLibraryDefinition($libraryName);
        }

        $tagsInLibrary = $this->tagLibrary[$libraryName];
        
        $isTagPartOfLibrary = array_key_exists($tagName, $tagsInLibrary);
                
        $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'isTagPartOfLibrary', "[$libraryName] $tagName : $isTagPartOfLibrary");
        
        return $isTagPartOfLibrary;
    }
    
    private function doesTagMatchSignature($libraryName, $tagName, array $attributes)
    {
        $doesTagMatchSignature = false;
        
        if (!array_key_exists($libraryName, $this->tagLibrary))
        {
            $this->loadLibraryDefinition($libraryName);
        }
                
        $tagsInLibrary = $this->tagLibrary[$libraryName];
        $tag = $tagsInLibrary[$tagName];
        
        $requiredAttribs = $tag->getRequiredAttributes();
        
        // check that all the required attributes exist in the passed array
        $numRequiredAttribs = count($requiredAttribs);
        
        if (count(array_intersect($requiredAttribs, $attributes)) == $numRequiredAttribs)
        {
            $doesTagMatchSignature = true;
        }
        
        $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'isTagPartOfLibrary', "[$libraryName] $tagName : $doesTagMatchSignature");
        
        return $doesTagMatchSignature;
    }
    
    private function loadLibraryDefinition($tagLibrary)
    {
        $definitionLoadedOK = false;
        
        $coreTagPath = INDY_TAGS . $tagLibrary;
        $coreTldPath = INDY_TAGS . $tagLibrary . "/" . $tagLibrary . ".tld";
        
        $appTagPath = APPLICATION_TAGS . $tagLibrary;
        $appTldPath = APPLICATION_TAGS . $tagLibrary . "/" . $tagLibrary . ".tld";        
        
        $xml = null;
        
        $tagPath = "";
        
        if (file_exists($appTagPath) && file_exists($appTldPath))
        {
            $tagPath = $appTagPath;
            $xml = simplexml_load_file($appTldPath);
        }
        else if (file_exists($coreTagPath) && file_exists($coreTldPath))
        {
            $tagPath = $coreTagPath;
            $xml = simplexml_load_file($coreTldPath);
        }
        
        
        if ($xml != null)
        {
            $tags = array();

            foreach($xml->tag as $tag)
            {                    	
                $tagDefinition = $this->loadTagDefinition($tag, $tagPath);
                
                $tagName = (string)$tagDefinition->getName();
                $tags[$tagName] = $tagDefinition;
            }

            $this->tagLibrary[$tagLibrary] = $tags;
            
            $definitionLoadedOK = true;
        }
        
        $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'loadLibraryDefinition', "$tagLibrary : $definitionLoadedOK");
        
        return $definitionLoadedOK;
    }
        
    private function loadTagDefinition($tag, $tagPath)
    {    	
        $tagDefinition = new TagDefinition;
        
        $tagDefinition->setName($tag->name);
        $tagDefinition->setPath($tagPath);
                
        foreach($tag->children() as $tagProperty)
        {        
            if ($this->isAttributeElement($tagProperty->getName()))
            {
            	$attrName = $tagProperty->name;
                $attrRequired = $tagProperty->required;
                
                $tagDefinition->addAttribute($attrName, $attrRequired);
            }
        }
        
        $this->logger->log(Logger::LOG_LEVEL_DEBUG, 'loadTagDefinition', "$tag [$tagPath] : " . $tagDefinition->getName());
        
        return $tagDefinition;
    }
    
    private function isAttributeElement($elementName)
    {
        $isAttributeElement = true;
        
        if (strcasecmp($elementName, "name") == 0 ||
            strcasecmp($elementName, "description") == 0)
        {
            $isAttributeElement = false;
        }
        
        return $isAttributeElement;
    }
}
?>

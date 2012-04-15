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
 * Indy Framework Set Tag.
 *
 * Tag that provides a loop functionality.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/BodyTag.php';

class ForEachTag extends BodyTag
{
    const REGEX_TAG_VARIABLE = "~%{1}[_a-z\d\.]+%{1}~";
        
    protected $items;
    protected $var;
    protected $varStatus = "status";

    public function doTag()
    {        	        
        if (is_array($this->items)) {

        	if ($this->is_assoc()) {
        		
        		$this->handleAssociateArray();
        		
        	} else {
        		
        		$this->handleObjectArray();
        	}

        } else {
            
            error_log($this->items + "is not an array");
        }
    }
    
    private function is_assoc () {
    	
    	$arr = $this->items;
    	
        return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
    }
    
    private function handleAssociateArray() {
    	
    	$body = $this->getBodyContent();
    	
        $forEachId = 0;
    	foreach ($this->items as $key => $value) {
    		 
    		$out = $body;
    		$params = $this->getRequiredParams($out);
    		 
    		foreach($params as $param) {
    	
                $out = str_replace("%__index__", $forEachId, $out);
    			$out = str_replace("%key%", $key, $out);
    			$out = str_replace("%value%", $value, $out);
    		}
    		 
    		$this->out($out);
    	}
    }
    
    private function handleObjectArray() {
  
        $pageProcesor = PageProcessor::instance();
        
        $body = $this->getBodyContent();
        
        $pageArray = preg_split ('/$\R?^/m', $body);               

        $index = 0;
        $count = 1;
        foreach ($this->items as $item) {
                        
            $pageContext = new PageContext();
            
            $iteratorStatus = new IteratorStatus($index, $count);
            
            $pageContext->setAttribute($this->var, $item);
            $pageContext->setAttribute($this->varStatus, $iteratorStatus);
            
            $pageProcesor->processPageSnippet($pageContext, $pageArray);
            
            $pageContext->removeAttribute($this->var);
            
            echo "\n";
            
            $index++;
            $count++;
        }
    }
    
    private function getRequiredParams($body) {

        $requiredParams = array();
        
        $params = array();
        preg_match_all(ForEachTag::REGEX_TAG_VARIABLE, $body, $params, PREG_SET_ORDER);
        foreach($params as $param)
        {                          
            $requiredParams[] = $param[0];
        }
        
        return $requiredParams;
    }
        
}

class IteratorStatus {
    
    private $index;
    private $count;
    
    public function __construct($index, $count)  {  
        
        $this->index = $index;
        $this->count = $count;
    }
    
    public function getIndex() {
        return $this->index;
    }
    
    public function getCount() {
        return $this->count;
    }
}
?>



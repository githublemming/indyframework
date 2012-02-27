<?php

require_once INDY_TAGS. '/BodyTag.php';

class ForEachTag extends BodyTag
{
    const REGEX_TAG_VARIABLE = "~%{1}[a-z\d\.]+%{1}~";
        
    protected $items;
    protected $var;

    public function doTag()
    {        	
        if (is_array($this->items)) {

        	if ($this->is_assoc()) {
        		
        		$this->handleAssociateArray();
        		
        	} else {
        		
        		$this->handleObjectArray();
        	}

        } else {
            
            error_log($this->items + "is not and array");
        }
    }
    
    private function is_assoc () {
    	
    	$arr = $this->items;
    	
        return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
    }
    
    private function handleAssociateArray() {
    	
    	$body = $this->getBodyContent();
    	
    	foreach ($this->items as $key => $value) {
    		 
    		$out = $body;
    		$params = $this->getRequiredParams($out);
    		 
    		foreach($params as $param) {
    	
    			$out = str_replace("%key%", $key, $out);
    			$out = str_replace("%value%", $value, $out);
    		}
    		 
    		$this->out($out);
    	}
    }
    
    private function handleObjectArray() {
    	
    	$body = $this->getBodyContent();
    	
    	foreach ($this->items as $item) {
    		 
    		$out = $body;
    	
    		$elEngine = $this->getELEngine($item);
    		$params = $this->getRequiredParams($out);
    		    	
    		foreach($params as $param) {
    			 
    			$stripped = $this->stripPercents($param);
    	
    			$dNotation = '${' . $stripped . '}';
    	
    			$value = $elEngine->parse($dNotation);
    			
    	
    			$out = str_replace($param, $value, $out);
    		}
    	
    		$this->out($out);
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
    
    private function stripPercents($reqVar) {
                
        $length = strlen($reqVar);

        $requireParam = substr($reqVar, 0, ($length -1));
        $requireParam = substr($requireParam, 1);  
        
        return $requireParam;
    }
    
    private function getELEngine($item) {
        
        $pageScope = new PageScope();
        $pageScope->setAttribute($this->var, $item);
        
        $elEngine = new EL_Engine($pageScope);
        
        return $elEngine;
    }
}
?>

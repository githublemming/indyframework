<?php

final class PageProcessor
{
    private static $instance;
        
    private $EL_Engine;
    private $TL_Engine;
    
    private $dollarNotationPattern;
    private $simpleTagPattern;
    private $bodyTagPattern;
    
    private function __construct() {
        
        $this->REGEX_COMBINED = "~" . 
                                REGEX_DOLLAR_NOTATION . "|" . 
                                REGEX_SIMPLE_TAG_PATTERN . "|" .
                                REGEX_BODY_TAG_PATTERN . "|" .
                                "~is";        
        
        
        $this->dollarNotationPattern = "~" . REGEX_DOLLAR_NOTATION . "~i";
        $this->simpleTagPattern = "~" . REGEX_SIMPLE_TAG_PATTERN . "~i";
        $this->bodyStartTagPattern = "~" . REGEX_BODY_OPEN_TAG_PATTERN . "~is";
        $this->bodyTagPattern = "~" . REGEX_BODY_TAG_PATTERN . "~is";

    	$this->logger = Logger::getLogger();

    }
    
    public static function instance() {
        
        if (!isset (self::$instance)) {
            
            self::$instance = new PageProcessor();
        }
        
        return self::$instance;
    }
    
    public function processPage(PageContext $page) {
        
        $this->TL_Engine = new TL_Engine($page);
        $this->EL_Engine = new EL_Engine($page);
        
        $fileName = $page->getPage();
        
    	if (file_exists($fileName)) {
    		
    		$this->doPage(file($fileName));
    		
    	} else {
    		
            error_log("Can't load view : " . $fileName);
    		//$this->displayError("Can't load view : " . $fileName);
    	}
    }
    
    public function processPageSnippet(PageContext $page, array $snippet) {
     
        $this->TL_Engine = new TL_Engine($page);
        $this->EL_Engine = new EL_Engine($page);
        
        $this->doPage($snippet);
    }
    
    private function doPage(array $pageArray) {
        
        $lookingForClosingTag = false;
        $closingTag = "";
        $body = "";
        foreach ($pageArray as $line_num => $line) {
                          
            if (!$lookingForClosingTag) {
                                
                if (preg_match($this->bodyStartTagPattern, $line)) {
                    
                    // ignoring for the time being
                    $lookingForClosingTag = true;
                    $closingTag = $this->getClosingTag($line);
                    $body = $line;

                } else if (preg_match($this->simpleTagPattern, $line)) {
                    
                    $this->doIndyTag($line);

                } else if (preg_match($this->dollarNotationPattern, $line)) {
                    
                    $this->doIndyTag($line);

                } else {
                    
                    echo $line;
                } 
            } else {
                
                $body .= $line;
                
                if (strpos($line, $closingTag)) {
                    $lookingForClosingTag = false;
                    $closingTag = "";
                    
                    $this->doIndyTag($body);
                }   
            }
        }
    }
    
    private function doIndyTag($line) {
        
        $tags = array();
        preg_match_all($this->REGEX_COMBINED, $line, $tags, PREG_SET_ORDER);
                        
        foreach($tags as $tag)
        { 
            $result;
                 
            $tag = $tag[0];
            
            if (strlen($tag) == 0) continue;
            
            if (preg_match($this->simpleTagPattern, $tag) || preg_match($this->bodyTagPattern, $tag))  {
                
                $this->handleTag($tag, $line);
                
            } else if (preg_match($this->dollarNotationPattern, $tag)) {
                
                $result = $this->EL_Engine->parse($tag);
            }
                        
            if (isset ($result)) {
                
                $updatedString = $this->update($tag, $result, $line);
                
                $line = $updatedString;
                
            } else {
                             
                $updatedString = $this->update($tag, " ", $line);
                
                $line = $updatedString;
            }
        }
        
        echo $line;
    }
    
    private function handleTag($tag)
    {   
        $tagInstance =  $this->TL_Engine->getTagInstance($tag);
        
        if ($tagInstance != null) {
        	
        	$result = $tagInstance->run();
            
            if ($result == Tag::EVAL_BODY_INCLUDE) {
                
                $body = $tagInstance->getBodyContent();
                                                
                $pageArray = preg_split('/$\R?^/m', $body);
                
                $this->doPage($pageArray);
            }
        }
    }
    
    private function update($tag, $value, $line)
    {        
        return $this->str_replace_once($tag, $value, $line);
    }
    
    private function str_replace_once($str_pattern, $str_replacement, $string)
    {        
        $updatedString = $string;
        
        if (strpos($string, $str_pattern) !== false)
        {     
            $updatedString = substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
        }
        
        return $updatedString;
    }
    
    private function getClosingTag($line) {
        
        $line = trim($line);
        
        $spacePos = strpos($line, " ");
        $tmp = substr($line, 0, $spacePos) . ">";
        
        $closingTag = str_replace("<", "</", $tmp);
        
        return $closingTag;
    }
    
}
?>

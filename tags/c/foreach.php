<?php

require_once INDY_TAGS. '/BodyTag.php';

class ForEachTag extends BodyTag
{
    const REGEX_TAG_VARIABLE = "[%.*?%]";
    
    protected $items;
    protected $var;

    public function doTag()
    {
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
            $this->out("<br/>");
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

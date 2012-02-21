<?php

class EL_Engine extends Engine
{
    const LITERALS    = '~\$?\{[-\s\w\.]+(?:\.[a-z0-9]*)*\}~i';
    const LITERALS_DQ = '~\$?\{\"+[\w\d\s]+\"+\}~i';
    const LITERALS_SQ = '~\$?\{\'+[\w\d\s]+\'+\}~i';
    const OPERATOR_EQ = '~\$?\{\s*[\"-\w\.]+\s*[!<>=]+\s*[\w\"\.-]+\s*\}~i';
    const OPERATOR_MA = '~\$?\{\s*[\"-\w\.]+\s*[\+\-\*\/]+\s*[\"-\w\.]+\s*\}~i';
    const STRCONCAT   = '~\$?\{\s*\".*?\"\s*\+\s*\".*?\"+\s*\}~i';
    
    private $pageScope;
    private $mathEval;
    
    public function __construct(&$pageScope)
    {
        $this->pageScope = $pageScope;
        $this->mathEval = new EvalMath();
    }
    
    public function parse($dNotation)
    {        
        $value = "";
        
        $el = trim($this->stripDollarNotation($dNotation));
        
        if (preg_match(self::OPERATOR_EQ, $dNotation))
        {            
            $value = $this->processEquation($el);
        }
        else if (preg_match(self::OPERATOR_MA, $dNotation))
        {            
            $value = $this->processMath($el);
        }
        else if (preg_match(self::LITERALS, $dNotation))
        {            
            $value = $this->processLiteral($el);
        }
        else if (preg_match(self::LITERALS_DQ, $dNotation) ||
                 preg_match(self::LITERALS_SQ, $dNotation))
        {            
            $value = $this->processLiteralWithQuotes($el);
        }
        
        return $value;
    }
    
    private function processLiteral($literal)
    {
        // need to strip of any quotes first
        $literal = $this->stripQuotes($literal);
        
        $value = "";
        
        if (is_numeric($literal))
        {
            $value = $literal;
        }
        else
        {
            if ($literal === 'true' ||
                $literal === 'false')
            {
                $value = $literal;
            }
            else if ($literal === 'null')
            {                
                $value = null;
            }
            else
            {
                $value = $this->processIdentifier($literal);
            }
        }

        return $value;
    }
    
    private function processLiteralWithQuotes($el)
    {
        $value =  substr($el, 1, strlen($el) - 2);
        
        return $value;
    }
    
    private function processIdentifier($identifier)
    {    	
        $value = "";
        
        $periodPos = strpos($identifier, ".");
        if ($periodPos > 0)
        {
            // we have a reference to a object and a method
            $attribute = substr($identifier, 0, $periodPos);
            $key = substr($identifier, $periodPos + 1, strlen($identifier) - ($periodPos + 1));

            if ($this->pageScope->attributeExists($attribute))
            {         
            	$object = $this->pageScope->getAttribute($attribute);
            	
				if (is_array($object)) {
					
					$value = $object[$key];
					
				} else {
					
					// will need to append get before the method name
					$fullMethodName = "get$key";
					
					// check if a method exists on the class with the name
					if (method_exists($object, $fullMethodName))
					{
						$value = $object->$fullMethodName();
					}
				}
            }
        }
        else if (defined($identifier))
        {
            // it's a constant
            $value = constant($identifier);
        }
        else if ($this->pageScope->attributeExists($identifier))
        {                
            // we have a reference to a simple variable
            $value = $this->pageScope->getAttribute($identifier); 
        }

        return $value;  
    }
    
    private function processEquation($el)
    {        
        $value = false;
                
        $exprArray = str_split($el);
        $exprCount = count($exprArray);

        $result = array();
        $currentIndex = 0;
        $currentChar = "";

        $ops = array('>', '>=', '<', '<=', '==', '!=' );
        $expecting_op = false;

        for($i=0; $i < $exprCount; $i++)
        {    
            $c = $exprArray[$i];

            if ($c == " " ||  $c == "'"  || $c == '"' ) continue;

            $j = $i + 1;
            if ($j < $exprCount)
            {
                $nextc = $exprArray[$i + 1];
                $op = $c . $nextc;
                $op = trim($op);  

                if (!in_array($op, $ops))
                {
                    unset($op);
                }
            }
                        
            if ($c == "-" && !$expecting_op)
            {
                $currentChar .= $c;
            }
            else if (isset($op) && in_array($op, $ops))
            {
                $result[$currentIndex] = $currentChar;
                $currentIndex ++;
                $currentChar = "";

                $result[$currentIndex] = $op;
                $currentIndex ++;

                $expecting_op = false;

                $i++;
            }
            else
            {
                $currentChar .= $c;
                $expecting_op = true;
            }
        }

        $result[$currentIndex] = $currentChar;

        $value1 = $this->processLiteral($result[0]);
        $value2 = $this->processLiteral($result[2]);

        switch($result[1])
        {
            case ">":
                $value = $value1 > $value2;
                break;
            case "<":
                $value = $value1 < $value2;
                break;
            case ">=":
                $value = $value1 >= $value2;
                break;
            case "<=":
                $value = $value1 <= $value2;
                break;
            case "==":
                $value = $value1 == $value2;
                break;
            case "!=":
                $value = $value1 != $value2;
                break;
        }  
      
        if (strlen($value) == 0)
        {
            $value = 0;
        }
                
        return $value;
    }
    
    private function processMath($el)
    {
        $value = false;
        
        $el = $this->stripQuotes($el);
                
        $exprArray = str_split($el);

        $result = array();
        $currentIndex = 0;
        $currentChar = "";

        $ops = array('+', '-', '*', '/' );
        $expecting_op = false;

        foreach($exprArray as $c)
        {    
            if ($c == " " ||  $c == "'"  || $c == '"' ) continue;

            if ($c == "-" && !$expecting_op)
            {
                $currentChar .= $c;
            }
            else if (in_array($c, $ops))
            {
                $result[$currentIndex] = $currentChar;
                $currentIndex ++;
                $currentChar = "";

                $result[$currentIndex] = $c;
                $currentIndex ++;

                $expecting_op = false;
            }
            else
            {
                $currentChar .= $c;
                $expecting_op = true;
            }
        }

        $result[$currentIndex] = $currentChar;

        $resCount = count($result);
        for($i=0; $i < $resCount; $i++)
        {
            $p = $result[$i];

            if (in_array($p, $ops)) continue;

            $result[$i] = $this->processLiteral($p);
        }
        
        $el = implode('', $result);
                
        $value = $this->mathEval->evaluate($el); 
        
        if (strlen($value) == 0)
        {
            $value = 0;
        }
        
        return $value;
    }
}

?>
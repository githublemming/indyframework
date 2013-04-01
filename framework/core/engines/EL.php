<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * EL.php
 *
 * Contains the EL_Engine.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 * 
 */

/**
 * Indy Framework Expression Language Engine.
 *
 * Given a Notation e.g. ${abc} it attempts to resolve the notation to a value
 * currently held in the PageContext and if it can find it returns the value.
 * 
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core/engines
 */

class EL_Engine extends Engine
{
    const LITERALS    = '~\$\{[-\s\w\.]+(?:\.[a-z0-9]*)*\}~i';
    const LITERALS_DQ = '~\$\{\"+[\w\d\s]+\"+\}~i';
    const LITERALS_SQ = '~\$\{\'+[\w\d\s]+\'+\}~i';
    const OPERATOR_EQ = '~\$\{\s*[\"-\w\.]+\s*[!<>=]+\s*[\w\"\.-]+\s*\}~i';
    const OPERATOR_RE = '~\$\{\s*[\"-\w\.]+\s+[eqnltgot]+\s+[\w\"\.-]+\s*\}~i';
    const OPERATOR_MA = '~\$\{\s*[\"-\w\.]+\s*[\+\-\*\/]+\s*[\"-\w\.]+\s*\}~i';
    const STRCONCAT   = '~\$\{\s*\".*?\"\s*\+\s*\".*?\"+\s*\}~i';
    
    /**
     * Reference to PageContext object.
     * @access private
     */
    private $pageContext;
    
    /**
     * Instance of EvalMath.
     * @access private
     */
    private $mathEval;
    
    /**
     * Constructor takes a reference to a PageContext object.
     * @param PageContext $pageContext
     */
    public function __construct(PageContext &$pageContext)
    {
        $this->pageContext = $pageContext;
        $this->mathEval = new EvalMath();
    }
    
    /**
     * Parses the passed Dollar Notation string and attempts to resolve the value.
     * 
     * @param string $dNotation
     * @return mixed  
     */
    public function parse($dNotation)
    {                
        $value = "";
        
        $el = trim($this->stripDollarNotation($dNotation));
        
        if (preg_match(self::OPERATOR_RE, $dNotation))
        {
        	$value = $this->processRelationship($el);
        }
        else if (preg_match(self::OPERATOR_EQ, $dNotation))
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
    
    /**
     * Attempts to find an attribute on the PageContext that has a key the same
     * as the passed value.
     * 
     * @param string $literal key of attribute in PageContext
     * @return mixed 
     * @access private
     */
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
            if (strcasecmp($literal, "true")  == 0 ||
                strcasecmp($literal, "false") == 0)
            {
                $value = $literal;
            }
            else if (strcasecmp($literal, "null") == 0)
            {                
                $value = null;
            }
            else if (strcasecmp($literal, "now") == 0)
            {
            	$value = time();
            }
            else
            {   
                $value = $this->processIdentifier($literal);
            }
        }

        return $value;
    }
    
    /**
     * 
     * @param type $el
     * @return type 
     * @access private
     */
    private function processLiteralWithQuotes($el)
    {
        $value =  substr($el, 1, strlen($el) - 2);
        
        return $value;
    }
    
    /**
     * @param type $identifier
     * @return type 
     * @access private
     */
    private function processIdentifier($identifier)
    {
        $value = "";
        
        $periodPos = strpos($identifier, ".");
        if ($periodPos > 0)
        {
            // we have a reference to a object and a method
            $attribute = substr($identifier, 0, $periodPos);
            $key = substr($identifier, $periodPos + 1, strlen($identifier) - ($periodPos + 1));

            if ($this->pageContext->attributeExists($attribute))
            {         
            	$object = $this->pageContext->getAttribute($attribute);
            	
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
        else if ($this->pageContext->attributeExists($identifier))
        {                
            // we have a reference to a simple variable
            $value = $this->pageContext->getAttribute($identifier); 
        }

        return $value;  
    }
    
    /**
     *
     * @param type $el
     * @return type 
     * @access private
     */
    private function processRelationship($el) 
    {
    	$ops = array('eq', 'ne', 'lt', 'gt', 'le', 'ge' );
    	$elements = $this->getExpressionElements($ops, $el);
    	
    	$comparator = $elements[1];
    	
    	switch($comparator) {
    		case "eq":
    			$comparator = "==";
    			break;
    		case "ne":
    			$comparator = "!=";
    			break;
    		case "lt":
    			$comparator = "<";
    			break;
    		case "gt":
    			$comparator = ">";
    			break;
    		case "le":
    			$comparator = "<=";
    			break;
    		case "ge":
    			$comparator = ">=";
    			break;
    	}
    	
    	$value1 = $this->processLiteral($elements[0]);
    	$value2 = $this->processLiteral($elements[2]);
    	    	    	
    	return $this->compare($value1, $comparator, $value2);
    }
    
    /**
     *
     * @param type $el
     * @return type 
     * @access private
     */
    private function processEquation($el)
    {
    	$ops = array('>', '>=', '<', '<=', '==', '!=' );
    	
    	$elements = $this->getExpressionElements($ops, $el);

        $value1 = $this->processLiteral($elements[0]);
        $value2 = $this->processLiteral($elements[2]);
        
        return $this->compare($value1, $elements[1], $value2);
    }
    
    /**
     *
     * @param type $ops
     * @param type $el
     * @return type 
     * @access private
     */
    private function getExpressionElements($ops, $el) {
    	
    	$exprArray = str_split($el);
    	$exprCount = count($exprArray);
    	
    	$result = array();
    	$currentIndex = 0;
    	$currentChar = "";
    	
    	$expecting_op = false;
    	
    	for($i=0; $i < $exprCount; $i++)
    	{
    		$c = $exprArray[$i];
    	
    		if ($c == " " ||  $c == "'"  || $c == '"' ) continue;
    	
    		$j = $i + 1;
    		if ($j < $exprCount) {
    			$nextc = $exprArray[$i + 1];
    			$op = $c . $nextc;
    			$op = trim($op);
    	
    			if (!in_array($op, $ops)) {
    				unset($op);
    			}
    		}
    	
    		if ($c == "-" && !$expecting_op) {
    			$currentChar .= $c;
    		} else if (isset($op) && in_array($op, $ops)) 	{
    				$result[$currentIndex] = $currentChar;
    				$currentIndex ++;
    				$currentChar = "";
    	
    				$result[$currentIndex] = $op;
    				$currentIndex ++;
    	
    				$expecting_op = false;
    	
    				$i++;
    		} else {
    			$currentChar .= $c;
    			$expecting_op = true;
    		}
    	}
    	
    	$result[$currentIndex] = $currentChar;	
    	
    	return $result;    	
    }
    
    /**
     *
     * @param type $left
     * @param type $comparator
     * @param type $right
     * @return int 
     * @access private
     */
    private function compare($left, $comparator, $right) {
    	
    	$value = false;
    	
    	switch($comparator) {
    		case ">":
    			$value = $left > $right;
    			break;
    		case "<":
    			$value = $left < $right;
    			break;
    		case ">=":
    			$value = $left >= $right;
    			break;
    		case "<=":
    			$value = $left <= $right;
    			break;
    		case "==":
    			$value = $left == $right;
    			break;
    		case "!=":
    			$value = $left != $right;
    			break;
    	}
    	
    	if (strlen($value) == 0) {
    		$value = 0;
    	}
    	
    	return $value;
    }
    
    /**
     *
     * @param type $el
     * @return int 
     * @access private
     */
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
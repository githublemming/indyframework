<?php

abstract class Engine
{
	protected $logger;
	
	public function __construct() {
	
		$this->logger = Logger::getLogger();
	}
	
    protected function stripQuotes($value)
    {
        return str_replace('"', '', trim($value));
    }
    
    protected function stripDollarNotation($value)
    {
        $value = str_replace('${', '', trim($value));
        $value = str_replace('}', '', $value);
        
        return $value;
    }
}

?>

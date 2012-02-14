<?php

abstract class Engine
{
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

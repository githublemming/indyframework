<?php

interface Scope
{
    public function setAttribute($attribute, $value);
    
    public function getAttribute($attribute);
    
    public function attributeExists($attribute);
}
?>

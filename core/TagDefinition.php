<?php

class TagDefinition
{
    private $name;
    private $path;
    
    private $required = array();
    private $optional = array();
    
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }
    public function getPath()
    {
        return $this->path;
    }
    
    public function addAttribute($attribute, $required)
    {
        if ($required === true)
        {
            $this->required[] = $attribute;
        }
        else
        {
            $this->optional[] = $attribute;
        }
    }
    
    public function getRequiredAttributes()
    {
        return $this->required;
    }    
}
?>

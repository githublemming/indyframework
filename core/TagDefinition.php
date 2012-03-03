<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.marksdevserver.com
 */

/**
 * Indy Framework Tag Definition class.
 *
 * Model class that holds all the informatin about a single Tag.
 *
 * @package indyframework/core
 */

class TagDefinition
{
    private $name = "";
    private $path = "";
    
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

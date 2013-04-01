<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * TagDefinition.php
 *
 * Contains the TagDefinition class.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
 */

/**
 * Indy Framework Tag Definition class.
 *
 * Model class that holds all the informatin about a single Tag.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/core
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

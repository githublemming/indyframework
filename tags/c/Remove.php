<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 */

/**
 * Indy Framework Set Tag.
 *
 * Tag that removes a value from the PageScope.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/SimpleTag.php';

class RemoveTag extends SimpleTag
{
    protected $var;
        
    public function doTag()
    {        
        $this->pageScope->removeAttribute($this->var);
    }
}

?>

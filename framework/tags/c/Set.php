<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

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
 * Tag that allows a value to be stored on the PageScope.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/SimpleTag.php';

class SetTag extends SimpleTag
{
    protected $var;
    protected $value;
        
    public function doTag()
    {        
        $this->pageScope->setAttribute($this->var, $this->value);
    }
}

?>

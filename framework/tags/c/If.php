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
 * Tag that provides basic logic functionality. If the test passes whatever exists
 * between the start and end tags will be shown.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/BodyTag.php';

class IfTag extends BodyTag
{
    protected $test;
        
    public function doTag()
    {    	
        $response = Tag::SKIP_BODY;
        
        if ($this->test == 1)
        {            
            $response = Tag::EVAL_BODY_INCLUDE;
        }
        
        return $response;
    }
}

?>

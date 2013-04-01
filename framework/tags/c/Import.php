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
 * Tag that includes another php/html file at the point in the page the tag resides.
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/SimpleTag.php';

class ImportTag extends SimpleTag
{
	protected $url;
	
	public function doTag()
	{		
        $pageProcesor = new PageProcessor();
        
        $file =  file_get_contents(APPLICATION_PATH . $this->url);
        
        $pageArray = preg_split ('/$\R?^/m', $file);          
        
        $pageProcesor->processPageSnippet($this->pageScope, $pageArray);
	}
}

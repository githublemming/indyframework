<?php

require_once INDY_TAGS. '/SimpleTag.php';

class ImportTag extends SimpleTag
{
	protected $url;
	
	private $view;

	public function doTag()
	{
		$this->view = new View($this->pageScope);
		
		$view = file_get_contents(APPLICATION_PATH . $this->url);
		
		$this->out($this->view->load($view));
	}
}

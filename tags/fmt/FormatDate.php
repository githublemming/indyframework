<?php

require_once INDY_TAGS. '/SimpleTag.php';

class FormatDateTag extends SimpleTag
{
	const DEFAULT_PATTERN = "Y-m-d H:i:s";
	const DEFAULT_DATE_PATTERN = "M d, Y";
	const DEFAULT_TIME_PATTERN = "h:i:s A";
	
	const DATE_SHORT = "d/m/y";
	const DATE_LONG = "F d, Y";
	const DATE_FULL = "l, F d, Y";

	const TIME_SORT = "h:i A";
	const TIME_LONG = "h:i:s A e";
	
	protected $value;
	
	protected $type = "date";
	protected $datestyle;
	protected $timestyle;
	protected $pattern;

	protected $var;

	public function doTag()
	{
		$formattedDate = date(FormatDateTag::DEFAULT_PATTERN, $this->value);
				
		if (isset($this->pattern)) {
			
			$formattedDate = date($this->pattern, $this->value);
			
		} else {
			
			$formattedDate = $this->format();
		}
		
		if (isset($this->var)) {
			
			$this->pageScope->setAttribute($this->var, $formattedDate);
			
		} else {
			
			$this->out($formattedDate);
			
		}
	}
	
	private function format() {
		
		$formattedDate = date(FormatDateTag::DEFAULT_PATTERN, $this->value);
		
		if (isset($this->datestyle)) {
		
			$formattedDate = $this->formatDate();
			
		} if (isset($this->timestyle)) {
			
			$formattedDate = $this->formatTime();
		
		}
		
		return $formattedDate;
	}
	
	private function formatDate () {
		
		$formattedDate = date(FormatDateTag::DEFAULT_DATE_PATTERN, $this->value);
		
		switch($this->datestyle) {
			case 'short':
				$formattedDate = date(FormatDateTag::DATE_SHORT, $this->value);
				break;
			case 'medium':
				$formattedDate = date(FormatDateTag::DEFAULT_DATE_PATTERN, $this->value);
				break;
			case 'long':
				$formattedDate = date(FormatDateTag::DATE_LONG, $this->value);
				break;
			case 'full':
				$formattedDate = date(FormatDateTag::DATE_FULL, $this->value);
				break;
		}
		
		return $formattedDate;
	}
	
	private function formatTime() {
		
		$formattedTime = date(FormatDateTag::DEFAULT_TIME_PATTERN, $this->value);
		
		switch($this->timestyle) {
			case 'short':
				$formattedTime = date(FormatDateTag::TIME_SHORT, $this->value);
				break;
			case 'medium':
				$formattedTime = date(FormatDateTag::DEFAULT_TIME_PATTERN, $this->value);
				break;
			case 'long':
				$formattedTime = date(FormatDateTag::TIME_LONG, $this->value);
				break;
		}
		
		return $formattedTime;
	}
}

?>
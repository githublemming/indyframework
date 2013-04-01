<?php

class Monitoring {
	
	const MONITORING_STATE = "state";
	
	private $state;
	
	public function setState($state) {
		$this->state = $state;
	}
	public function getState() {
		return $this->state;
	}
	
}
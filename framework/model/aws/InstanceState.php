<?php

class InstanceState {
	
	const INSTANCE_STATE_CODE = "code";
	const INSTANCE_STATE_NAME = "name";
	
	private $code;
	private $name;
	
	public function setCode($code) {
		$this->code = $code;
	}
	public function getCode() {
		return $this->code;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
	
}
<?php

class Tag {
	
	const TAG_NAME = "key";
	const TAG_VALUE = "value";
	
	private $name;
	private $value;
	
	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
	
	public function setValue($value) {
		$this->value = $value;
	}
	public function getValue() {
		return $this->value;
	}
}
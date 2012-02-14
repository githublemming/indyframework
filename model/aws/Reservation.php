<?php
class Reservation {
	
	const RESERVATION_ID            = "reservationId";
	const RESERVATION_OWNER_ID      = "ownerId";
	const RESERVATION_GROUP_SET     = "groupSet";
	const RESERVATION_INSTANCE_SET  = "instancesSet";
	
	private $id;
	private $ownerId;
	private $securityGroups = array();
	private $instances = array();
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	
	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
	}
	public function getOwnerId() {
		return $this->ownerId;
	}
	
	public function addSecurityGroup($securityGroup) {
		$this->securityGroups[] = $securityGroup;
	}
	public function setSecurityGroups(array $securityGroups) {
		$this->securityGroups = $securityGroups;
	}
	public function getSecurityGroups() {
		return $this->securityGroups;
	}
	
	public function addInstance($instance) {
		$this->instances[] = $instance;
	}
	public function setInstances(array $instances) {
		$this->instances = $instances;
	}
	public function getInstances() {
		return $this->instances;
	}
}
<?php

class Placement {
	
	const PLACEMENT_AVAILABILITY_ZONE = "availabilityZone";
	const PLACEMENT_GROUP_NAME = "groupName";
	const PLACEMENT_TENANCY = "tenancy";
	
	private $availabilityZone;
	private $groupName;
	private $tenancy;
	
	public function setAvailabilityZone($zone) {
		$this->availabilityZone = $zone;
	}
	public function getAvailabilityZone() {
		return $this->availabilityZone;
	}
	
	public function setGroupName($groupName) {
		$this->groupName = $groupName;
	}
	public function getGroupName() {
		return $this->groupName;
	}
	
	public function setTenancy($tenancy) {
		$this->tenancy = $tenancy;
	}
	public function getTenancy() {
		return $this->tenancy;
	}
}
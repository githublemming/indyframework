<?php

class Instance {
	
	const INSTANCE_ID = "instanceId";
	const INSTANCE_IMAGE_ID = "imageId";
	const INSTANCE_STATE = "instanceState";
	const INSTANCE_PRIVATE_DNS_NAME = "privateDnsName";
	const INSTANCE_DNS_NAME = "dnsName";
	const INSTANCE_AMI_LAUNCH_INDEX = "amiLaunchIndex";
	const INSTANCE_TYPE = "instanceType";
	const INSTANCE_LAUNCH_TIME = "launchTime";
	const INSTANCE_PLACEMENT = "placement";
	const INSTANCE_KERNEL_ID = "kernelId";
	const INSTANCE_MONITORING = "monitoring";
	const INSTANCE_PRIVATE_IP_ADDRESS = "privateIpAddress";
	const INSTANCE_IP_ADDRESS = "ipAddress";
	const INSTANCE_GROUP_SET = "groupSet";
	const INSTANCE_ARCHITECTURE = "architecture";
	const INSTANCE_ROOT_DEVICE_TYPE = "rootDeviceType";
	const INSTANCE_ROOT_DEVICE_NAME = "rootDeviceName";
	const INSTANCE_VIRTUALIZATION_TYPE = "virtualizationType";
	const INSTANCE_TAG_SET = "tagSet";
	const INSTANCE_HYPERVISOR = "hypervisor";
	
	private $id;
	private $imageId;
	private $state;
	private $privateDnsName;
	private $dnsName;
	//private $reason;
	private $amiLaunchIndex;
	//private $productCodes;
	private $instanceType;
	private $launchTime;
	private $placement;
	private $kernelId;
	private $monitoring;
	private $privateIpAddress;
	private $ipAddress;
	private $securityGroup = array();
	private $architecture;
	private $rootDeviceType;
	private $rootDeviceName;
	//private $blockDeviceMapping;
	private $virtualizationType;
	//private $clientToken;
	private $tags;
	private $hypervisor;
	
	
	public function setId($id) {
		$this->id = $id;
	}
	public function getId() {
		return $this->id;
	}
	
	public function setImageId($imageId) {
		$this->imageId = $imageId;
	}
	public function getImageId() {
		return $this->imageId;
	}
	
	public function setInstanceState(InstanceState $state) {
		$this->state = $state;
	}
	public function getInstanceState() {
		return $this->state;
	}
	
	public function setPrivateDnsName($dnsName) {
		$this->privateDnsName = $dnsName;
	}
	public function getPrivateDnsName() {
		return $this->privateDnsName;
	}
	
	public function setDnsName($dnsName) {
		$this->dnsName = $dnsName;
	}
	public function getDnsName() {
		return $this->dnsName;
	}
	
	public function setAmiLaunchIndex($index) {
		$this->amiLaunchIndex = $index;
	}
	public function getAmiLaunchIndex() {
		return $this->amiLaunchIndex;
	}
	
	public function setInstanceType($instanceType) {
		$this->instanceType = $instanceType;
	}
	public function getInstanceType() {
		return $this->instanceType;
	}
	
	public function setLaunchTime($launchTime) {
		$this->launchTime = $launchTime;
	}
	public function getLaunchTime() {
		return $this->launchTime;
	}
	
	public function setPlacement(Placement $placement) {
		$this->placement = $placement;
	}
	public function getPlacement() {
		return $this->placement;
	}
	
	public function setKernelId($kernelId) {
		$this->kernelId = $kernelId;
	}
	public function getKernelId() {
		return $this->kernelId;
	}
	
	public function setMonitoring(Monitoring $monitoring) {
		$this->monitoring = $monitoring;
	}
	public function getMonitoring() {
		return $this->monitoring;
	}
	
	public function setPrivateIpAddress($ip) {
		$this->privateIpAddress = $ip;
	}
	public function getPrivateIpAddress() {
		return $this->privateIpAddress;
	}
	
	public function setIpAddress($ip) {
		$this->ipAddress = $ip;
	}
	public function getIpAddress() {
		return $this->ipAddress;
	}
	
	public function addSecurityGroup(SecurityGroup $securityGroup) {
		$this->securityGroup[] = $securityGroup;
	}
	public function setSecurityGroups(array $securityGroups) {
		$this->securityGroup = $securityGroups;
	}
	public function getSecurotyGroups() {
		return $this->securityGroup;
	}

	public function setArchitecture($architecture) {
		$this->architecture = $architecture;
	}
	public function getArchitecture() {
		return $this->architecture;
	}
	
	public function setRootDeviceType($rootDeviceType) {
		$this->rootDeviceType;
	}
	public function getRootDeviceType() {
		return $this->rootDeviceType;
	}
	
	public function setRootDeviceName($rootDeviceName) {
		$this->rootDeviceName = $rootDeviceName;
	}
	public function getRootDeviceName() {
		return $this->rootDeviceName;
	}
	
	public function setVirtualizationType($virtualizationType) {
		$this->virtualizationType = $virtualizationType;
	}
	public function getVirtualizationType() {
		return $this->virtualizationType;
	}
	
	public function addTag(Tag $tag) {
		$this->tags[] = $tag;
	}
	public function setTags(array $tags) {
		$this->tags = $tags;
	}
	public function getTags() {
		return $this->tags;
	}
	
	public function setHypervisor($hypervisor) {
		$this->hypervisor = $hypervisor;
	}
	public function getHypervisor() {
		return $this->hypervisor;
	}
}
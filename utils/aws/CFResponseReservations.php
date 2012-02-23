<?php

require_once dirname(__FILE__) ."/../../model/aws/Instance.php";
require_once dirname(__FILE__) ."/../../model/aws/InstanceState.php";
require_once dirname(__FILE__) ."/../../model/aws/Monitoring.php";
require_once dirname(__FILE__) ."/../../model/aws/Placement.php";
require_once dirname(__FILE__) ."/../../model/aws/Reservation.php";
require_once dirname(__FILE__) ."/../../model/aws/SecurityGroup.php";
require_once dirname(__FILE__) ."/../../model/aws/Tag.php";

class CFResponseReservations {
	
	public function getReservations($cfResponse) {
	
		$reservations = array();
		
		$reservationsXML = $cfResponse->body->reservationSet->item;
	
		foreach($reservationsXML AS $reservationXML) {
	
			$reservations[] = $this->createReservation($reservationXML);
		}
		
		return $reservations;
	}
	
	private function createReservation($reservationXML) {
		
		$reservation = new Reservation();
		
		foreach($reservationXML AS $reservationAttribXML) {
		
			if (strcmp ($reservationAttribXML->getName(), Reservation::RESERVATION_ID) == 0) {

				$reservation->setId($this->stringValue($reservationAttribXML));
				
			} else if (strcmp ($reservationAttribXML->getName(), Reservation::RESERVATION_OWNER_ID) == 0) {
				
				$reservation->setOwnerId($this->stringValue($reservationAttribXML));
				
			} else if (strcmp ($reservationAttribXML->getName(), Reservation::RESERVATION_GROUP_SET) == 0) {
				
				$reservation->setSecurityGroups($this->createSecurityGroups($reservationAttribXML));
				
			} else if (strcmp ($reservationAttribXML->getName(), Reservation::RESERVATION_INSTANCE_SET) == 0) {
				
				$reservation->setInstances($this->createInstances($reservationAttribXML));
			}
		}
		
		return $reservation;
	}
	
	private function createInstances($reservationAttribXML) {

		$instances = array();
		
		$instancesXML = $reservationAttribXML->item;
		
		foreach($instancesXML AS $instanceXML) {
		
			$instances[] = $this->createInstance($instanceXML);
		}
		
		return $instances;
	}
	
	private function createInstance($instanceXML) {
		
		$instance = new Instance();
		
		foreach($instanceXML AS $instanceAttribXML) {
			
			if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_ID) == 0) {
				
				$instance->setId($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_IMAGE_ID) == 0) {
				
				$instance->setImageId($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_STATE) == 0) {
				
				$instance->setInstanceState($this->createInstanceState($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_PRIVATE_DNS_NAME) == 0) {
				
				$instance->setPrivateDnsName($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_DNS_NAME) == 0) {
				
				$instance->setDnsName($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_AMI_LAUNCH_INDEX) == 0) {
				
				$instance->setAmiLaunchIndex($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_TYPE) == 0) {
				
				$instance->setInstanceType($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_LAUNCH_TIME) == 0) {
				
				$instance->setLaunchTime($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_PLACEMENT) == 0) {
				
				$instance->setPlacement($this->createPlacement($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_KERNEL_ID) == 0) {
				
				$instance->setKernelId($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_MONITORING) == 0) {
				
				$instance->setMonitoring($this->createMonitoring($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_PRIVATE_IP_ADDRESS) == 0) {
				
				$instance->setPrivateIpAddress($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_IP_ADDRESS) == 0) {
				
				$instance->setIpAddress($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_GROUP_SET) == 0) {
				
				$instance->setSecurityGroups($this->createSecurityGroups($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_ARCHITECTURE) == 0) {
				
				$instance->setArchitecture($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_ROOT_DEVICE_TYPE) == 0) {
				
				$instance->setRootDeviceType($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_ROOT_DEVICE_NAME) == 0) {
				
				$instance->setRootDeviceName($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_VIRTUALIZATION_TYPE) == 0) {
				
				$instance->setVirtualizationType($this->stringValue($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_TAG_SET) == 0) {
				
				$instance->setTags($this->createTags($instanceAttribXML));
				
			} else if (strcmp ($instanceAttribXML->getName(), Instance::INSTANCE_HYPERVISOR) == 0) {
				
				$instance->setHypervisor($this->stringValue($instanceAttribXML));
				
			}
		}
		
		return $instance;
	}
	
	private function createTags($reservationAttribXML) {
		
		$tags = array();
		
		$tagsXML = $reservationAttribXML->item;
		
		foreach($tagsXML AS $tagXML) {
		
			$tags[] = $this->createTag($tagXML);
		}
		
		return $tags;
	}
	
	private function createTag($tagXML) {
		
		$tag = new Tag();
		
		foreach($tagXML AS $tagAttribXML) {
		
			if (strcmp ($tagAttribXML->getName(), Tag::TAG_NAME) == 0) {
		
				$tag->setName($this->stringValue($tagAttribXML));
		
			} else if (strcmp ($tagAttribXML->getName(), Tag::TAG_VALUE) == 0) {
		
				$tag->setValue($this->stringValue($tagAttribXML));
			}
		}
		
		return $tag;
		
	}
	
	private function createMonitoring($monitoringXML) {
		
		$monitoring = new Monitoring();
		
		$monitoring->setState((string)$monitoringXML->state);
		
		return $monitoring;
	}
	
	private function createPlacement($placementXML) {
		
		$placement = new Placement();
		
		$placement->setAvailabilityZone((string)$placementXML->availabilityZone);
		$placement->setTenancy((string)$placementXML->tenancy);
		
		return $placement;
	}
	
	private function createInstanceState($instanceStateXML) {
		
		$instanceState = new InstanceState();
		
		$instanceState->setCode((string)$instanceStateXML->code);
		$instanceState->setName((string)$instanceStateXML->name);
	
		return $instanceState;
	}
	
	private function createSecurityGroups($reservationAttribXML) {
		
		$securityGroups = array();
		
		$securityGroupsXML = $reservationAttribXML->item;
		
		foreach($securityGroupsXML AS $securityGroupXML) {
		
			$securityGroups[] = $this->createSecurityGroup($securityGroupXML);
		}
		
		return $securityGroups;
	}
	
	private function createSecurityGroup($securityGroupXML) {
	
		$securityGroup = new SecurityGroup();
		
		foreach($securityGroupXML AS $securityGroupAttribXML) {
		
			if (strcmp ($securityGroupAttribXML->getName(), SecurityGroup::SECURITY_GROUP_ID) == 0) {
		
				$securityGroup->setId($this->stringValue($securityGroupAttribXML));
		
			} else if (strcmp ($securityGroupAttribXML->getName(), SecurityGroup::SECURITY_GROUP_NAME) == 0) {
		
				$securityGroup->setName($this->stringValue($securityGroupAttribXML));
			}
		}
	
		return $securityGroup;
	}
	
	private function stringValue($XML) {
		
		return (string)$XML;
	}
}


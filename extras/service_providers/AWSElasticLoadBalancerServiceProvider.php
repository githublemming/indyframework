<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2011, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * Implementation of the AWSAutoScalingService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'AWSElasticLoadBalancingService.php';

if (file_exists(INDY_EXTERNAL . AWS_SDK. 'sdk.class.php')) {
    
    require_once INDY_EXTERNAL . AWS_SDK. 'sdk.class.php';
    
} else {
    
    throw new ApplicationException ("AWS PHP SDK not found");
}

class AWSElasticLoadBalancerServiceProvider implements ProviderInterface, AWSElasticLoadBalancingService
{
	private $aws_elb;
	private $aws_elb_region;
	
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('AWSElasticLoadBalancingService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                $this->aws_elb = new AmazonELB();
                $this->aws_elb->set_region($this->aws_elb_region);
           		break;
           	}
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setRegion($region)
    {
    	$this->aws_elb_region = $region;
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the CookieService interface
    ////////////////////////////////////////////////////////////////////////////
    public function registerInstance($elbName, array $instanceIds) {
    	
    	return $this->aws_elb->register_instances_with_load_balancer($elbName, $this->formatArray($instanceIds));
    }
    
    public function deregisterInstance($elbName, array $instanceIds) {
    	
    	return $this->aws_elb->deregister_instances_from_load_balancer($elbName, $this->formatArray($instanceIds));
    }
    
    private function formatArray(array $instanceIds) {
    	
    	$formattedArray = array();
    	
    	foreach($instanceIds as $instanceId) {
    		
    		$formattedArray[] = array('InstanceId' => $instanceId);
    		
    	}
    	
    	return $formattedArray;
    }
}
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

require_once INDY_EXTERNAL . AWS_SDK. 'sdk.class.php';

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
    public function registerInstance($elbName, array $instances) {
    	
    	$this->aws_elb->register_instances_with_load_balancer($elbName, $instances);
    }
    
    public function deregisterInstance($elbName, array $instances) {
    	
    	$this->aws_elb->deregister_instances_from_load_balancer($elbName, $instances);
    }
}
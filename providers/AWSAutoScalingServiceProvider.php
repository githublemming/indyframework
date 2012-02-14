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

require_once INDY_SERVICE . 'AWSAutoScalingService.php';

require_once INDY_EXTERNAL . AWS_SDK. 'sdk.class.php';

class AWSAutoScalingServiceProvider implements ProviderInterface, AWSAutoScalingService
{
	private $aws_as;
	private $aws_as_region;
	
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('AWSAutoScalingService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
            	$this->aws_as = new AmazonAS();
            	$this->aws_as->set_region($this->aws_as_region);
            	break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Application Load Direct Inject functions
    ////////////////////////////////////////////////////////////////////////////
    public function setRegion($region)
    {
    	$this->aws_as_region = $region;
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the CookieService interface
    ////////////////////////////////////////////////////////////////////////////
    public function updateASGroup($groupName, $min, $max) {
    	
    	$options = array();
    	$options['MinSize'] = $min;
    	$options['MaxSize'] = $max;
    	
    	return $this->aws_as->update_auto_scaling_group($groupName, $options);
    }
}

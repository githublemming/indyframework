<?php

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * Implementation of the AWSCloudFrontService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'AWSCloudFrontService.php';

require_once INDY_EXTERNAL . AWS_SDK. 'sdk.class.php';

class AWSCloudFrontServiceProvider implements ProviderInterface, AWSCloudFrontService
{
	private $aws_cf;
	
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('AWSCloudFrontService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
            	$this->aws_cf = new AmazonCloudFront();
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
    public function invalidate($distribution_id, $filename) {
    	
    	$epoch = date('U');
    	
		return $this->aws_cf->create_invalidation($distribution_id, $epoch, $filename);
    }
    
    public function listCurrentInvalidationRequests($distribution_id){
    	
    	return $this->aws_cf->list_invalidations($distribution_id);
    }
    
    public function getInvalidationRequestDetails($distribution_id, $invalidation_id) {
    	
    	return $this->aws_cf->get_invalidation($distribution_id, $invalidation_id);
    }
}
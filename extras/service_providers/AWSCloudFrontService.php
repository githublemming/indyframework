<?php

/**
 * AWSCloudFrontService.php
 *
 * Contains the AWSCloudFrontService definition.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/services
 * 
 */

/**
 * AWSCloudFrontService
 *
 * Defines functionality that relatates to Amazon Web Services Cloud Front Service.
 * 
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/services
 */
interface AWSCloudFrontService extends ServiceInterface {

	public function invalidate($distribution_id, $filename);
	
	public function listCurrentInvalidationRequests($distribution_id);
	
	public function getInvalidationRequestDetails($distribution_id, $invalidation_id);
}
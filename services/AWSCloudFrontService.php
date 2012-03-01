<?php

/**
 * Service that provides AWS CloudFront functionality.
 */
interface AWSCloudFrontService extends ServiceInterface {

	public function invalidate($distribution_id, $filename);
	
	public function listCurrentInvalidationRequests($distribution_id);
	
	public function getInvalidationRequestDetails($distribution_id, $invalidation_id);
}
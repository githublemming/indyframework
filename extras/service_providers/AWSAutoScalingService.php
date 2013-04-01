<?php
/**
 * AWSAutoScalingService.php
 *
 * Contains the AWSAutoScalingService definition.
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/services
 * 
 */

/**
 * AWSAutoScalingService
 *
 * Defines functionality that relatates to Amazon Web Services Auto Scaling Service.
 * 
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 * @package     indyframework/services
 */
interface AWSAutoScalingService extends ServiceInterface
{
    /**
     * Change an existing AutoScaling groups min and max values
     * @param string $groupName AutoScaling group to modify
     * @param int $min new min number of instances
     * @param int $max new max number of instances
     */
	public function updateASGroup($groupName, $min, $max);
}
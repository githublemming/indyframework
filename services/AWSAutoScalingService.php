<?php

interface AWSAutoScalingService extends ServiceInterface
{
	public function updateASGroup($groupName, $min, $max);
}
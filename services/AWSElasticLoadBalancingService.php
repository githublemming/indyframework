<?php

interface AWSElasticLoadBalancingService extends ServiceInterface
{
	public function registerInstance($elbName, array $instanceIds);
	
	public function deregisterInstance($elbName, array $instanceIds);
}
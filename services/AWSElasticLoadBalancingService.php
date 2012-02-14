<?php

interface AWSElasticLoadBalancingService extends ServiceInterface
{
	public function registerInstance($elbName, array $instances);
	
	public function deregisterInstance($elbName, array $instances);
}
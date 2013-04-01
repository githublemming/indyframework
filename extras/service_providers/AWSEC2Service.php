<?php

/**
* Service that provides AWS EC2 functionality.
*/
interface AWSEC2Service extends ServiceInterface
{

	public function instanceStatus($id);
	
	public function environmentStatus($env = null);
	
	public function allInstanceStatuses();
}
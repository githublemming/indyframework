<?php

/**
 * Service that provides AWS S3 functionality.
 */
interface AWSS3Service extends ServiceInterface
{
	/**
	 * Copys a file from one location to another.
	 * 
	 * @param array $source       array('bucket'  => 'nameofsourcebucket', 'filename' => 'nameoffile');
	 * @param array $destination  array('bucket'  => 'nameofdestinationbucket', 'filename' => 'nameoffile');
	 * @param array $options      array('headers' => array('Cache-Control' => 'no-cache'));
	 */
	public function copyFile(array $source, array $destination, array $options = null);
	
	public function sendBatchCopy(array $requests);
}
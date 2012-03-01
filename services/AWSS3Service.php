<?php

/**
 * Service that provides AWS S3 functionality.
 */
interface AWSS3Service extends ServiceInterface
{
	public function copyFile(array $source, array $destination, array $options = null);
}
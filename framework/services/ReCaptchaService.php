<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2011, IndyFramework.org
 * @link		http://www.indyframework.org
 */

/**
 * Service that provides Google reCAPTCHA functionality.
 *
 * @package indyframework/services
 */
interface ReCaptchaService extends ServiceInterface {
   
    public function isValid();
}

?>

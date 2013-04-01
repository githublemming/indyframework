<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Indy Framework
 *
 * An open source application development framework for PHP
 *
 * @author		Mark P Haskins
 * @copyright	Copyright (c) 2010 - 2012, Mark P Haskins
 * @link		http://www.indyframework.org
 */

/**
 * Indy Framework reCAPTCHA Tag.
 *
 * Tag that outputs a reCAPTCHA control to the page. 
 * 
 * For this to work yoy need to have:
 * 
 * a) ensure that you have the latest version of the reCAPTCHA library in the
 *    external folder.
 * 
 * b) defined your public key as a constant called reCAPTCHA in your 
 *    application.cfg file 
 *    e.g define('reCAPTCHA', 'xxxxx_your_public_key_xxxxx');
 *
 * @package indyframework/core
 */

require_once INDY_TAGS. '/SimpleTag.php';

require_once INDY_EXTERNAL . "/recaptchalib.php";

class ReCaptchaTag extends SimpleTag
{
    
    public function doTag()
    {
        $control = recaptcha_get_html(reCAPTCHA);
        
        $this->out($control);
    }
}

?>

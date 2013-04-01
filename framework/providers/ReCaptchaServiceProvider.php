<?php

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
 * Implmentation of the ReCaptchaService.
 * 
 * In order for this provider to your you have to ensure that
 * 
 * a) you have registered your site on the reCAPTCHA website 
 *    (http://www.google.com/recaptcha), and have made a note of your public and
 *    private keys.
 * 
 * b) the latest version of the recaptchalib.php file in the 
 *    [indyframework]/external
 * 
 * c) For the associated tag to work you need to have define your public key as
 *    a constance (see [indyframework]/tags/ext/ReCaptcha
 * 
 * d) You need to add your private key as a property to the provider element in 
 *    the definition file.
 *    ** As always when your definition file contains sensitive information it
 *       should be placed outside of your web root **
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'ReCaptchaService.php';

require_once INDY_EXTERNAL . "/recaptchalib.php";

/**
 * Implmentation of the SessionService.
 */
class ReCaptchaServiceProvider implements ProviderInterface, ReCaptchaService
{
    private $privateKey;
    
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('ReCaptchaService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// property functions
    ////////////////////////////////////////////////////////////////////////////
    public function setPrivateKey($privateKey) {
        $this->privateKey = $privateKey;
    }
    
    
    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the ReCaptchaService interface
    ////////////////////////////////////////////////////////////////////////////
    public function isValid() {
                
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        
        
        return $resp->is_valid;
    }
}
?>

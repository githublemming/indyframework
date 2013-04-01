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
 * Implementation of the EmailService.
 *
 * @package indyframework/providers
 */

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'EmailService.php';

require_once INDY_EXTERNAL . 'is_email.php';

class EmailServiceProvider implements ProviderInterface, EmailService
{
    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('EmailService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the EmailService interface
    ////////////////////////////////////////////////////////////////////////////
    public function send($to, $from, $fullfrom, $subject, $content)
    {
      ini_set("sendmail_from", $from);

      $headers = 'From: '.$fullfrom;

      return @mail($to, $subject, $content, $headers);
    }

    public function sendHTML($to, $from, $fullfrom, $subject, $plainContent, $HTMLcontent)
    {
        ini_set("sendmail_from", $from);

        $boundary = "----Blind_Monkey----" . md5(time());

        $headers  = "From: $fullfrom" ."\n";
        $headers .= "Reply-To: $fullfrom" . "\n";
        $headers .= "Return-Path: $fullfrom" . "\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\n";
        $headers .= "X-Mailer: PHP" . phpversion() . "\n";


        # -=-=-=- TEXT EMAIL PART
        $message  = "--$boundary\n";
        $message .= "Content-type: text/plain; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $plainContent;


        # -=-=-=- HTML EMAIL PART
        $message .= "--$boundary\n";
        $message .= "Content-type: text/html; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $HTMLcontent;


        # -=-=-=- FINAL BOUNDARY
        $message .= "--$boundary" . "--";

        $addittional_parameters = "-f" . $from;

        return @mail($to, $subject, $message, $headers, $addittional_parameters);
    }

    public function validEmailAddress($email)
    {
        return is_email($email);
        
//        $valid = true;
//
//        if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.
//                  '@'.
//                  '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
//                  '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email))
//        {
//            $valid = false;
//        }
//
//        return $valid;
    }
}

?>

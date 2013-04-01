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
 * Service that provider Email functionality.
 *
 * @package indyframework/services
 */

interface EmailService extends ServiceInterface
{
    /**
     * Sends a Plain Text email.
     *
     * @param string $to       who the email is being sent to
     * @param string $from     who the email address is coming from e.g. Mark
     * @param string $fullfrom the full email address of who sent the mail e.g. mark@domain.com
     * @param string $subject  the subject line of the email
     * @param string $content  the email body
     * @return <type> Returns the code from the PHP mail command
     */
    public function send($to, $from, $fullfrom, $subject, $content);

    /**
     * Send a multipart email that consists of a plain text part and a HTML part.
     *
     * @param string $to           who the email is being sent to
     * @param string $from who     the email address is coming from e.g. Mark
     * @param string $fullfrom     the full email address of who sent the mail e.g. mark@domain.com
     * @param string $subject      the subject line of the email
     * @param string $plainContent the plain text part of the email
     * @param string $HTMLcontent  the HTML part of the email
     * @return <type> Returns the code of the PHP mail command.
     */
    public function sendHTML($to, $from, $fullfrom, $subject, $plainContent, $HTMLcontent);

    /**
     * Checks to see if the passed string is valid as an email address
     *
     * @param string $email String to be checked
     * @return boolean TRUE OR FALSE
     */
    public function validEmailAddress($email);
}

?>

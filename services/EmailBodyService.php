<?php

/**
 * Implementors of this service will be responsible for the generatoring of both
 * HTML and Plain text emails.
 *
 * This Service is not responsible for the sending of the email this task must
 * be handled by another service.
 */
interface EmailBodyService extends ServiceInterface
{
    public function createHTMLBody();

    public function createPlainTextBody();
}
?>

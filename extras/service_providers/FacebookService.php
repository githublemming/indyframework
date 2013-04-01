<?php

/**
 * Service that provides Facebook functionality.
 */
interface FacebookService extends ServiceInterface
{
    /**
     * Attempts to past a message on a user facebook wall.
     * 
     * @param string $statusMessage
     */
    function post($statusMessage);
}

?>

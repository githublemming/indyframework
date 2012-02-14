<?php

/**
 * Implementors of this Service must provide functionalty that provides in some
 * shape or form Hello World
 */
interface HelloWorldService extends ServiceInterface
{
    /**
     * Returns a message.
     */
    public function sayHello();
}
?>

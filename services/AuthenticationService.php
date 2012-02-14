<?php

interface AuthenticationService extends ServiceInterface
{
    /**
     * Validate function.
     * No variables are passed into this function it is expected that any data
     * required to perform this validation will be retrieved by other means, such
     * as from POST
     */
    public function validate();

    /**
     * Validates the passed username and password.
     *
     * @param string $username
     * @param string $password
     */
    public function validateUsernameAndPassword($usename, $password);

    /**
     * 
     */
    public function logOut();
    
    public function isLoggedIn();
    
    public function isAdmin();
}

?>

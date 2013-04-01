<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

/**
 * Service that provides functionality loading a web page.
 */
interface PageService extends ServiceInterface
{
    /**
     * Shows a page that has the appropriate module and action associated with it.
     *
     * For example, you might provide implementation of this function when the
     * URL format being used by your application resembles this:
     *
     * /index.php?module=Authenticate&action=Login
     *
     * @param <type> $module The module to display
     * @param <type> $action Action that affects how the module will be displayed.
     */
    public function displayModule($module, $action);

    public function display();
}

?>

<?php

/*
 * Provides a mechanism for displaying the basket contents in differing formats
 * and layouts.
 */
interface BasketViewService extends ServiceInterface
{
    public function getHTMLView();

    public function getTextView();

}

?>

<?php

interface SellableItem
{
    /**
     * Returns the unique ID of the item
     *
     * @return mixed unique id
     */
    public function getID();

    /**
     * Returns the description of the item
     *
     * @return string
     */
    public function getDescription();

    /**
     * Returns the unit price of the item
     *
     * @return mixed unit price.
     */
    public function getPrice();
}

?>

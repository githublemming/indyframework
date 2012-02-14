<?php

interface BasketService extends ServiceInterface
{
    /**
     * If a current basket does not exist then on will be created.
     */
    public function createBasket();

    /**
     * Returns the number of basket items in the basket.
     */
    public function count();

    /**
     * Returns the basketItem for the passed ID. If no items are found
     * that match the ID then false will be returned.
     * @param int $id
     * @return BasketItem 
     */
    public function getBasketItem($id);

    /**
     * Returns all the items in the basket.
     *
     * @return array an array of all BasketItems in the basket.
     */
    public function getBasketItems();

    /**
     * Adds the passed item to the Basket. If the product already exists within
     * the basket then the quantity will be modified on the existing item.
     *
     * @param BasketItem $item
     */
    public function addToBasket(BasketItem $item);

    /**
     * Removes the basket item from the basket. If the quantity to remove is less
     * than the quantiy already allocated then the quantity is decreased and the
     * item will stay in the basket.
     * 
     * @param BasketItem $item
     */
    public function removeFromBasket(BasketItem $item);

    /**
     * Empties the basket of all items.
     */
    public function clear();
}
?>

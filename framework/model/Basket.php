<?php

require_once INDY_MODEL . 'BasketItem.php';

/**
 * Description of Basket
 *
 * @author mark
 */
class Basket
{
    private $basketItems = array();

    /**
     * Returns the number of basket items in the basket.
     */
    public function count()
    {
        return count($this->basketItems);
    }

    /**
     * Returns the basketItem for the passed product ID. If no items are found
     * that match the product ID them false will be returned.
     * @param <type> $productID
     * @return <type>
     */
    public function getBasketItem($id)
    {
        $basketItem = false;

        if (array_key_exists($id, $this->basketItems))
        {
            $basketItem = $this->basketItems[$id];
        }

        return $basketItem;
    }

    /**
     * Returns all the items in the basket.
     * @return <type>
     */
    public function getBasketItems()
    {
        return $this->basketItems;
    }


    /**
     * Adds the passed item to the Basket. If the product already exists within
     * the basket then the quantity will be modified on the existing item.
     * @param BasketItem $item
     */
    public function addToBasket(BasketItem $item)
    {
        $id = $item->getSellableItem()->getID();

        if (array_key_exists($id, $this->basketItems))
        {
            $quantity = $item->getQuantity();

            $basketItem = $this->basketItems[$id];
            $basketItem->increaseQuantity($quantity);

            $this->basketItems[$id] = $basketItem;
        }
        else
        {
            $this->basketItems[$id] = $item;
        }
    }

    /**
     * Removes the basket item from the basket. If the quantity to remove is less
     * than the quantiy already allocated then the quantity is decreased and the
     * item will stay in the basket.
     * @param BasketItem $item
     */
    public function removeFromBasket(BasketItem $item)
    {
        $id = $item->getSellableItem()->getID();

        if (array_key_exists($id, $this->basketItems))
        {
            $quantity = $item->getQuantity();

            $basketItem = $this->basketItems[$id];
            $basketItem->decreaseQuantity($quantity);

            if ($basketItem->getQuantity() == 0)
            {
                unset($this->basketItems[$id]);
            }
            else
            {
                $this->basketItems[$id] = $basketItem;
            }
        }
    }

    public function clear()
    {
        unset($this->basketItems);

        $this->basketItems = array();
    }
}
?>

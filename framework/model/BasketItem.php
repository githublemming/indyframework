<?php

class BasketItem
{
    private $sellableItem;
    private $quantity;
    private $unitPrice;
    private $totalCost;

    /**
     * Default constructor
     *
     * @param SellableItem $sellableItem
     * @param int $qty
     */
    public function  __construct(SellableItem $sellableItem, $qty)
    {
        $this->sellableItem = $sellableItem;
        $this->quantity = (int)$qty;
        $this->unitPrice = $this->sellableItem->getPrice();

        $this->updateTotalCost();
    }

    /**
     * Returns the sellable Item object
     *
     * @return SellableItem an object that implements sellableItem
     */
    public function getSellableItem()
    {
        return $this->sellableItem;
    }

    /**
     * Returns the number/quantity required of the SellableItem
     *
     * @return int
     */
    public function getQuantity()
    {
        return (int)$this->quantity;
    }

    /**
     * Returns the total cost of the SellableItem. This is calculated based on
     * the unit price defined within the SellableItem multiplied by the
     * Quantity.
     *
     * @return mixed
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * increased the number of items that are to be purchased.
     * 
     * @param int $quantity
     */
    public function increaseQuantity($quantity)
    {
        if (is_integer($quantity))
        {
            $this->quantity = (int)$this->quantity + (int)$quantity;

            $this->updateTotalCost();
        }
    }

    /**
     * Decreases the number of items that are to be purchased.
     * 
     * @param int $quantity
     */
    public function decreaseQuantity($quantity)
    {
        if (is_integer($quantity))
        {
            $this->quantity = (int)$this->quantity - (int)$quantity;

            if ($this->quantity < 0 || $this->quantity == 0)
            {
                $this->quantity = 0;
            }
            else
            {
                $this->updateTotalCost();
            }
        }
    }

    private function updateTotalCost()
    {
        $this->totalCost = $this->unitPrice * (int)$this->quantity;
    }
}

?>

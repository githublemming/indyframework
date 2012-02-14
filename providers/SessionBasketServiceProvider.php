<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'BasketService.php';
require_once INDY_MODEL . 'Basket.php';

class SessionBasketServiceProvider implements ProviderInterface, BasketService
{
    private $basketSession = "Basket";

    private $sessionService;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                $serviceRepository->registerService('BasketService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                $this->sessionService = $serviceRepository->requireService('SessionService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Property functions
    ////////////////////////////////////////////////////////////////////////////
    public function setBasketSession($basketSessionName)
    {
        $this->basketSession = $basketSessionName;
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the BasketService interface
    ////////////////////////////////////////////////////////////////////////////
    public function createBasket()
    {
        $basket = null;
        
        $this->sessionService->start();

        if (!$this->sessionService->exists($this->basketSession))
        {
            $basket = new Basket();
            $this->sessionService->set($this->basketSession, $basket);
        }
        
        return $basket;
    }

    public function count()
    {
        $count = 0;

        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
            $count = $basket->count();
        }

        return $count;
    }


    public function getBasketItem($id)
    {
        $basketItem = false;

        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
            $basketItem = $basket->getBasketItem($id);
        }

        return $basketItem;
    }


    public function getBasketItems()
    {
        $basketItems = false;

        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
            $basketItems = $basket->getBasketItems();
        }

        return $basketItems;
    }


    public function addToBasket(BasketItem $item)
    {
        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
        }
        else
        {
            $basket = $this->createBasket();
        }

        $basket->addToBasket($item);
        $this->sessionService->set($this->basketSession, $basket);
    }


    public function removeFromBasket(BasketItem $item)
    {
        $removedOK = false;

        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
            $basket->removeFromBasket($item);
            $this->sessionService->set($this->basketSession, $basket);
            $removedOK = true;
        }
        
        return $removedOK;
    }

    public function clear()
    {
        $clearedOK = false;

        $this->sessionService->start();

        if ($this->sessionService->exists($this->basketSession))
        {
            $basket = $this->sessionService->value($this->basketSession);
            $basket->clear();
            $this->sessionService->set($this->basketSession, $basket);

            $clearedOK = true;
        }

        return $clearedOK;
    }
}

?>

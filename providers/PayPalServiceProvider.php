<?php

defined( 'INDY_EXEC' ) or die( 'Restricted access' );

require_once INDY_SERVICE . 'PayPalService.php';

class PayPalServiceProvider implements ProviderInterface, PayPalService
{
    private $basketService;

    public function applicationEvent(ServiceRepository $serviceRepository, $event)
    {
        switch($event)
        {
            case APPLICATION_LOAD:
            {
                // Registers itself as a provider of the HelloWorldService.
                $serviceRepository->registerService('PayPalService', $this);
                break;
            }
            case APPLICATION_INIT:
            {
                // Requests another HelloWorldService from the Service Repository
                // This one would sit higher up the Application Config file.
                $this->basketService = $serviceRepository->requireService('BasketService', $this);
                break;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ///// Implementation of the PayPalService interface
    ////////////////////////////////////////////////////////////////////////////
    public function createShoppingCartHTML()
    {
        $html = "";

        $basketItems = $this->basketService->getBasketItems();

        $html .= "<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>";
        $html .= "<input type='hidden' name='cmd' value='_cart'>";
        $html .= "<input type='hidden' name='upload' value='1'>";
        $html .= "<input type='hidden' name='business' value='seller@designerfotos.com'>";

        $counter = 1;
        foreach ($basketItems as $id => $basketItem)
        {
            $qty = $basketItem->getQuantity();
            $totalCost = $basketItem->getTotalCost();
            $product = $basketItem->getSellableItem();
            $desc = $product->getDescription();

            $item = $qty .'  x ' . $desc;

            $html .= "<input type='hidden' name='item_name_$counter' value='$item'>";
            $html .= "<input type='hidden' name='amount_$counter' value='$totalCost'>";

            $counter++;
        }

        $html .= "<input type='submit' value='PayPal'>";
        
        return $html;
    }
}

?>

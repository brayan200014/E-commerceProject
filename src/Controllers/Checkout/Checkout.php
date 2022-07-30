<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Checkout extends PublicController{
    public function run():void
    {
        $viewData = array();
        $products= array();
        if ($this->isPostBack()) {
            $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                "test".(time() - 10000000),
                "http://localhost/E-commerceProject/index.php?page=checkout_error",
                "http://localhost/E-commerceProject/index.php?page=checkout_accept"
            );

            if(isset($_POST["btnEnviarVenta"])) {
                if(isset($_SESSION["productsVentas"])) {
                    $isv= floatval($_POST["sale_isv"]);
                    $products= $_SESSION["productsVentas"];
                    
                   foreach($products as $key => $value) {
                    $description= $products[$key]["inventory_size"] . " " . $products[$key]["inventory_gender"];
                        $PayPalOrder->addItem(
                            $products[$key]["product_name"], 
                            $description, 
                            "PRD",
                            $products[$key]["product_price"],
                            $isv,
                            $products[$key]["quantity"],
                            "DIGITAL_GOODS"
                        );
                   }

                   $response = $PayPalOrder->createOrder();
                   $_SESSION["orderid"] = $response[1]->result->id;
                   \Utilities\Site::redirectTo($response[0]->href);
                   die();
                }
            
            }
            
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
?>

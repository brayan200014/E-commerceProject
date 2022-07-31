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

            if(isset($_POST["btnEnviarVenta"]) && isset($_POST["product_id"])) {
                if(isset($_SESSION["productsVentas"])) {
                   
                    $products= $_SESSION["productsVentas"];
                    $customer= intval($_POST["cus_id"]);
                    $_SESSION["cus_id"]= $customer;
                    
                   foreach($products as $key => $value) {
                    $isv= (($value["product_price"] * $value ["quantity"]) * 0.15);
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
            
            } else {
                    
                if(isset($_POST["cus_id"])) {
                    $customer= intval($_POST["cus_id"]);
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=admin_venta&mode=INS&cus_id=".$customer,
                        "No ha agregado productos a la venta"
                    );
                }
            }
            
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
?>

<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
use Dao\Admin\Ventas as DaoVentas; 
class Accept extends PublicController{
    public function run():void
    {
        $subtotal= 0;
        $status= "";
        $lastSale= "";
        $order_id="";
        $indice=0;
        $dataview = array();
        $products= array();
        $productsDetails= array();
        $token = $_GET["token"] ?: "";
        $session_token = $_SESSION["orderid"] ?: "";
        if ($token !== "" && $token == $session_token) {
            $result = \Utilities\Paypal\PayPalCapture::captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
            $json= json_decode($dataview["orderjson"], true);
            $dataview["status"]= $json["result"]["status"];
            $order_id= $json["result"]["id"];

            if($dataview["status"]=== "COMPLETED") {
                $status= "CONF";
                if(isset($_SESSION["productsVentas"]) && isset($_SESSION["cus_id"])) {
                        $customer= $_SESSION["cus_id"];
                        $products= $_SESSION["productsVentas"];
                        $copyProducts= array();
                        $productsDetails= array();
                 

                        foreach($products as $key => $value) {
                            $price= $products[$key]["product_price"];
                            $quantity= $products[$key]["quantity"];
                            $subtotal+= ($price * $quantity);
                            error_log(json_decode($value["product_id"]));
                           
                            if(!in_array($value["product_id"], $copyProducts)) {
                                array_push($copyProducts, $value["product_id"]);
                                $productsDetails[]= $value;
                            } else {
                                for($i=0; $i<sizeof($productsDetails); $i++) {
                                    if($productsDetails[$i]["product_id"]=== $value["product_id"]) {
                                        $productsDetails[$i]["quantity"]+= $value["quantity"];
                                    }
                                }

                            }
                            

                        }
                        error_log(json_encode($productsDetails));

                         $result= DaoVentas::insertVenta($customer, 0.15, $subtotal, $status,$order_id);
                         if($result) {
                            $lastSale= DaoVentas::getLastSaleId();
                            foreach($productsDetails as $key => $value) {
                                $resultDetail= DaoVentas::insertarDetalle(
                                    $lastSale["sale_id"], 
                                    $value["product_id"],
                                    $value["quantity"],
                                    $value["product_price"]);
                            }

                            $_SESSION["productsVentas"]= array();
                            $_SESSION["cus_id"]= array();
                         }
                         else {
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_ventas",
                                "Error al insertar la venta intente de uevo"
                            );
                         }
                }
            } else {
                $dataview["orderjson"] = "Orden no se realizo con exito";
            }

        } else {
            $dataview["orderjson"] = "No Order Available!!!";
        }
        \Views\Renderer::render("paypal/accept", $dataview);
    }
}

?>

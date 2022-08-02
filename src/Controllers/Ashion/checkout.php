<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class Checkout extends PublicController
{   

    private $viewData= array();

    public function run() :void
    {
        $subtotal= 0;
    
        if(!$this->isPostBack()) {
            $user= \Utilities\Security::isLogged();
            error_log(json_encode($_SESSION["shopping_cart"]));
                if(!empty($_SESSION["shopping_cart"])) {
                    $this->viewData["ProductosShoppingCart"]= $_SESSION["shopping_cart"];

                    foreach($this->viewData["ProductosShoppingCart"] as $key => $value) {
                        $subtotal+= $value["total_price"];
                    }

                    $this->viewData["subtotal"]= $subtotal;
                }
                else {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=ashion_shop",
                        "No tiene productos agregados al carrito"
                    );
                }
            }

        Renderer::render('ashion/checkout', $this->viewData);
    }
}
?>
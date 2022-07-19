<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class ShopCart extends PublicController
{
    public function run() :void
    {
       
        Renderer::render('ashion/shopcart', array());
    }
}
?>

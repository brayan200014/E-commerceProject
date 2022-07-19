<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class ProductDetails extends PublicController
{
    public function run() :void
    {
       
        Renderer::render('ashion/productdetails', array());
    }
}
?>

<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class Shop extends PublicController
{
    public function run() :void
    {
       
        Renderer::render('ashion/shop', array());
    }
}
?>

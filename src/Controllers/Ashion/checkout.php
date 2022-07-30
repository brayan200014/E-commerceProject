<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class Checkout extends PublicController
{
    public function run() :void
    {
        Renderer::render('ashion/checkout', array());
    }
}
?>
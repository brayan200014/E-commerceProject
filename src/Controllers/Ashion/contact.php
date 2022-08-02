<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;

class Contact extends PublicController
{   
    public function run() :void
    {
        Renderer::render('ashion/contact', array());
    }
}
?>

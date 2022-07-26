<?php
namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Ventas as DaoVentas; 
use Views\Renderer;

class Ventas extends PrivateController
{
    public function run() :void
    {
        $viewData= array();
        $viewData["Sales"]= DaoVentas::getAll();
       
        Renderer::render('admin/ventas', $viewData);
    }
}
?>

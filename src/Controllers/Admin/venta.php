<?php
namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Ventas as DaoVentas; 
use Views\Renderer;

class Venta extends PrivateController
{
    private $viewData= array();
    public function run() :void
    {
        
      
        if(!$this->isPostBack()) {
           $this->viewData["Productos"]= DaoVentas::getAllProductsI();
        }
       
        Renderer::render('admin/venta', $this->viewData);
    }
}
?>

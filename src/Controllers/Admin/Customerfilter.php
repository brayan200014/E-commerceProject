<?php
namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Ventas as DaoVentas; 
use Views\Renderer;

class CustomerFilter extends PrivateController
{
    private $viewData= array();
    public function run() :void
    {
        
        if($this->isPostBack()) {
            $nombreCombo= $_POST["campo"];
            $this->viewData["Clientes"]= DaoVentas::getClientesCombo($nombreCombo);
        }
       
        Renderer::render('admin/customerFilter', $this->viewData);
    }
}
?>

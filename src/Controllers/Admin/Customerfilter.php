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
        
 
        $this->viewData["Clientes"]= DaoVentas::getClientesCombo();

       
        Renderer::render('admin/customerFilter', $this->viewData);
    }
}
?>

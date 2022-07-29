<?php
namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Ventas as DaoVentas; 
use Views\Renderer;

class Ventas extends PrivateController
{

    private $viewData= array();
    public function run() :void
    {

        $this->viewData["Sales"]= DaoVentas::getAll();
       
        Renderer::render('admin/ventas', $this->viewData);
    }
}
?>

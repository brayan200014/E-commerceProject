<?php

namespace Controllers\Admin;

use Controllers\PrivateController;
use Controllers\PublicController;
use Dao\Mnt\Clientes as DaoClientes;
use Views\Renderer;

class Clientes extends PublicController{

    /**
     * Runs the controller
     * 
     * @return void
     */
    public function run():void{
        //code
        $viewData = array();
        $viewData["clientes"] = DaoClientes::getAllCustomer();

        Renderer::render('admin/clientes', $viewData);
    }
}

?>
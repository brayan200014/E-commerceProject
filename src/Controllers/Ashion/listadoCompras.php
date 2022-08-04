<?php

namespace Controllers\Ashion;

use Controllers\Admin\Cliente;
use Controllers\PublicController;
use Views\Renderer;
use Dao\Mnt\Clientes;

class listadoCompras extends PublicController{

    /**
     * Runs the controller
     * 
     * @return void
     */
    private $viewData = array();

    public function run():void{
        //code
        if(\Utilities\Security::isLogged()){
            if($_SESSION["login"]["usertipo"] == "PBL"){
                $this->viewData["isLogged"]=$_SESSION["login"]["usertipo"];
                $this->viewData["usernameappear"]=$_SESSION["login"]["userName"];
                $this->viewData["customer_id"] = Clientes::getCustomerId(intval($_SESSION["login"]["userId"]));
                $this->viewData["logeado"]=false;
            }
        }
        else 
        {
            $this->viewData["logeado"]=true;
        }

        $this->viewData["compras"] = Clientes::getSaleByCustomer($this->viewData["customer_id"]);
        
        Renderer::render('ashion/listadoCompras', $this->viewData);
    }
}

?>
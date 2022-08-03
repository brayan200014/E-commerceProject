<?php

namespace Controllers;
use Views\Renderer;
use Dao\AShion\Shop;

class Index extends PublicController
{

    private $viewData = array();
    public function run() :void
    {
        $this->viewData['Category'] = Shop::getAllCategory();
        $this->viewData['Categories'] = Shop::getAllCategories();
        $this->viewData['Trend'] = Shop::getHotTrends();
        $this->viewData['New'] = Shop::getThreeNewProduct();
        $this->viewData['Discounts'] = Shop::getProductWithDiscounts();
        error_log(json_encode($this->viewData));
        Renderer::render('index', $this->viewData);
        $viewData = array();
        if(\Utilities\Security::isLogged()){
            $viewData["logeado"]=true;
            if($_SESSION["login"]["usertipo"] == "PBL"){
                $viewData["isLogged"]=$_SESSION["login"]["usertipo"];
                $viewData["usernameappear"]=$_SESSION["login"]["userName"];
                $viewData["logeado"]=false;
            }
        }
        \Views\Renderer::render("index", $viewData);

    }
}
?>

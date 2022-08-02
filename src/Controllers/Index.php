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
        $this->viewData['QuantityProducts'] = $this->getQuantityProducts();
        error_log(json_encode($this->viewData));
        Renderer::render('index', $this->viewData);
    }

    private function getQuantityProducts()
    {
        $quantity = 0;
        if(isset($_SESSION['shopping_cart'])){
            foreach($_SESSION['shopping_cart'] as $product){
                $quantity++;
            }
        }
        return $quantity;
    }
}
?>

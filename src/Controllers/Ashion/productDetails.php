<?php
namespace Controllers\Ashion;

use Controllers\PublicController;
use Views\Renderer;
use Dao\AShion\Shop;

class ProductDetails extends PublicController
{
    private $viewData = array();
    public function run() :void
    {
        if(isset($_GET['product_id']) && isset($_GET['category_id'])){
            $this->viewData['Product'] = Shop::getProductById($_GET['product_id']);
            $this->viewData['Sizes'] = Shop::getSizesByProductId($_GET['product_id']);
            $this->viewData['Products'] = Shop::getProductsByCategoryId($_GET['category_id'],$_GET['product_id']);
            $this->viewData['Categories'] = Shop::getAllCategories();
            error_log(json_encode($this->viewData));
            Renderer::render('ashion/productdetails', $this->viewData);
        }
    }
}
?>

<?php
namespace Controllers\Admin;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Admin\Productos as DaoProductos;

class Productos extends PublicController
{
    private $viewData = array();
    public function run() :void
    {
        if($this->isPostBack()){
            $this->insertarProducto();
        }
        $this->viewData['Productos'] = DaoProductos::getAllProducts();
        Renderer::render('admin/productos', $this->viewData);
    }

    private function insertarProducto(){
        if(isset($_POST['btnEnviar'])){

            $product_image_url = $_POST['image'];
            $product_name = $_POST['name'];
            $product_description = $_POST['description'];
            $product_price = $_POST['price'];
            $product_stock = $_POST['stock'];
            $product_discount = $_POST['discount'];
            $inventory_size = $_POST['size'];
            $inventory_gender = $_POST['gender'];
            $category_id = $_POST['category'];
            $product_status = $_POST['status'];

            DaoProductos::insertProduct(
                $product_image_url,
                $product_name,
                $product_description,
                $product_price,
                $product_stock,
                $product_discount,
                $inventory_size,
                $inventory_gender,
                $category_id,
                $product_status,
            );
        }
    }
}
?>

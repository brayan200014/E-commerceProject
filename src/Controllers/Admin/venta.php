<?php
namespace Controllers\Admin;

use Controllers\PrivateController;
use Dao\Admin\Ventas as DaoVentas; 
use Views\Renderer;

class Venta extends PrivateController
{
    private $viewData= array();
    private $_productVentaStructure = array(
        "product_id" => "",
        "product_name" => "",
        "product_price" => 0,
        "quantity" => 0,
        "inventory_size" => "",
        "inventory_gender" => ""
    );
   private $result= "";
   private $stock= array();
    
    public function run() :void
    {


        if(isset($_POST["btnAgregarDetalle"])) {
            $customer_id= intval($_POST["cus_id"]);
            $id= intval($_POST["product_idModal"]);
            $name= $_POST["product_nameModal"];
            $price= $_POST["product_priceModal"];
            $quantity= intval($_POST["quantityModal"]);
            $size= $_POST["inventory_sizeModal"];
            $gender= $_POST["inventory_genderModal"];
            $this->stock["result"]=DaoVentas::lessInventory($quantity, $id, $gender, $size);
            
            foreach($this->stock["result"] as $value) {
                if($value == "true") {
                   $this->result= "true";
                  // error_log(json_decode($this->result));
                }
            }

            if($this->result==="true") {
                $this->agregarProductoSession($id,$price,$name,$quantity,$size,$gender );
                $this->viewData["ProductosSessionVentas"]= $this->getProducts();
               // error_log(json_encode($this->viewData["ProductosSessionVentas"]));
                $this->result= "";
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=admin_venta&cus_id=".$customer_id,
                    "Producto Agregado"
                );
            }
                else {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=admin_venta&cus_id=".$customer_id,
                        "Stock Insuficiente"
                    );
                }
            }
         

        if(isset($_POST["btnEliminarProduct"])) {
            $customer_id= intval($_POST["cus_id"]);
            $id= intval($_POST["product_idModalDelete"]);
            $size= $_POST["inventory_sizeModalDelete"];
            $gender= $_POST["inventory_genderModalDelete"];
            $quantity= $_POST["quantity_modalDelete"];
            $this->stock["delete"]=DaoVentas::plusInventory($quantity, $id, $gender, $size);
               
            foreach($this->stock["delete"] as $value) {
                if($value == "true") {
                   $this->result= "true";
                   error_log(json_decode($this->result));
                }
               // error_log(json_decode($this->result));
            }

            if($this->result==="true") {
                $this->deleteProduct($id, $size, $gender);
                $this->viewData["ProductosSessionVentas"]= $this->getProducts();
              //  error_log(json_encode($this->viewData["ProductosSessionVentas"]));
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=admin_venta&cus_id=".$customer_id,
                    "Producto eliminado"
                );
             } else {
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=admin_venta&cus_id=".$customer_id,
                    "Error en el inventario, revisar"
                );
             }
        }
      
        if(!$this->isPostBack()) {
           $this->viewData["Productos"]= DaoVentas::getAllProductsI();
           $this->viewData["ProductosSessionVentas"]= $this->getProducts();

        }
       
        Renderer::render('admin/venta', $this->viewData);
    }


    public function agregarProductoSession($product_id,$product_price,$product_name, $quantity, $inventory_size, $inventory_gender)
    {
        $error= false;
        $product = $this->_productVentaStructure;
        $product["product_id"] = $product_id;
        $product["product_name"] = $product_name;
        $product["product_price"] = $product_price;
        $product["quantity"] = $quantity;
        $product["inventory_size"] = $inventory_size;
        $product["inventory_gender"] = $inventory_gender;

        $products = array();
        if (isset($_SESSION["productsVentas"])) {
            $products = $_SESSION["productsVentas"];
        }

        foreach($products as $key=>$value) {
            if($products[$key]["product_id"]===$product_id && $products[$key]["inventory_gender"]===$inventory_gender && $products[$key]["inventory_size"]===$inventory_size ) {
                $products[$key]["quantity"]+= $quantity;
                $_SESSION["productsVentas"] = $products;
                $error= true;
            }
        }

        if(!$error) {
            $products[] = $product;
            $_SESSION["productsVentas"] = $products;
        }
    }

    function getProducts()
{
    $products = array();
    if (isset($_SESSION["productsVentas"])) {
        $products= $_SESSION["productsVentas"];
    }
    return  $products;
}

function deleteProduct($id, $size, $gender) {
    $products = array();
    if (isset($_SESSION["productsVentas"])) {
        $products = $_SESSION["productsVentas"];
    }
    
    foreach($products as $key=>$value) {
        if($products[$key]["product_id"]===$id && $products[$key]["inventory_gender"]===$gender && $products[$key]["inventory_size"]===$size ) {
            unset($products[$key]);
        }
    }
    $_SESSION["productsVentas"]= $products;
    return $products;
}
}
?>

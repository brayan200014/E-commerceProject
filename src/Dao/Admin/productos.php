<?php

namespace Dao\Admin;
use Dao\Table;

class Productos extends Table
{
    public static function getAllProducts()
    {
        $sqlstr = "SELECT * FROM products AS p 
        RIGHT JOIN inventory AS i ON p.product_id =  i.product_id";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function getProductById($product_id)
    {
        $sqlstr = "SELECT * FROM products as p
        RIGHT JOIN inventory AS i ON p.product_id =  i.product_id
        where p.product_id = :product_id";
        $sqlParams = array("product_id" => $product_id);
        return self::obtenerUnRegistro($sqlstr, $sqlParams);
    }

    public static function insertProduct(
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
        ) {
            $sqlstr = "INSERT INTO `products`
                (`product_name`, `product_description`, 
                 product_price, `product_status`,
                 product_discount, 
                `product_image_url`, category_id)
                VALUES
                (:product_name, :product_description,
                :product_price, :product_status, 
                :product_discount,
                :product_image_url, :category_id);

                INSERT INTO inventory (
                    product_id, `inventory_size`, 
                    `inventory_gender`, product_stock) 
                VALUES (
                    (select product_id from products order by product_id desc limit 0,1),:inventory_size,:inventory_gender,:product_stock
                );
                ";
                
            $sqlParams = [
                "product_image_url" => $product_image_url ,
                "product_name" => $product_name ,
                "product_description" => $product_description ,
                "product_price" => $product_price ,
                "product_stock" => $product_stock ,
                "product_discount" =>  $product_discount ,
                "inventory_size" => $inventory_size,
                "inventory_gender" => $inventory_gender,
                "category_id" => $category_id,
                "product_status" => $product_status,
            ];
            return self::executeNonQuery($sqlstr, $sqlParams);
        }
    
    public static function updateProduct(
            $product_id,
            $product_image_url,
            $product_name,
            $product_description,
            $product_price,
            $product_stock,
            $product_discount,
            $inventory_id,
            $inventory_size,
            $inventory_gender,
            $category_id,
            $product_status,
        ) {
            $sqlstr = "UPDATE `products` set
                `product_name`=:product_name, `product_description`=:product_description,
                product_price=:product_price,`product_status`=:product_status, 
                product_discount=:product_discount, 
                `product_image_url`=:product_image_url, category_id=:category_id
                where product_id = :product_id;
                UPDATE `inventory` set `inventory_size`=:inventory_size, 
                `inventory_gender` = :inventory_gender, product_stock = :product_stock
                where inventory_id = :inventory_id
                ";
            $sqlParams = array(
                "product_id" => $product_id,
                "product_name" => $product_name,
                "product_description" => $product_description,
                "product_price" => $product_price,
                "product_status" => $product_status,
                "product_discount" => $product_discount,
                "product_image_url" => $product_image_url,
                "category_id" => $category_id,
                "inventory_id" => $inventory_id,
                "inventory_size" => $inventory_size,
                "inventory_gender" => $inventory_gender,
                "product_stock" => $product_stock,
            );
            return self::executeNonQuery($sqlstr, $sqlParams);
        }
    
    public static function deleteProduct($inventory_id,$product_id)
        {
            $sqlstr = "DELETE from `inventory` where inventory_id = :inventory_id; 
            DELETE from `products` where product_id = :product_id;";
            $sqlParams = array(
                "product_id" => $product_id,
                "inventory_id" => $inventory_id,
            );
            return self::executeNonQuery($sqlstr, $sqlParams);
        }
}

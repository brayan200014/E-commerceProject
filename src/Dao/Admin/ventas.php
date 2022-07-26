<?php


namespace Dao\Admin;

use Dao\Table;

class Ventas extends Table
{
    public static function getAll() {
        $sqlstr= "SELECT s.sale_id, s.sale_date , concat(c.customer_name, ' ', c.customer_lastname) 'customer',
        s.sale_isv, s.sale_subtotal, round(sum((sd.sale_quantity * sd.sale_price) + (sale_isv * (sd.sale_quantity * sd.sale_price))),2) 'sale_total' , s.sale_status
        FROM sales_details sd inner join sales s on sd.sale_id= s.sale_id
        inner join customers c on c.customer_id= s.customer_id
         group by s.sale_id;
        ";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function insertVenta($customer_id, $sale_isv, $sale_subtotal, $sale_status) {
        $sqlstr= "INSERT INTO `sales`
        (
        `sale_date`,
        `customer_id`,
        `sale_isv`,
        `sale_subtotal`,
        `sale_status`)
        VALUES
        (
         now(),
        :customer_id,
        :sale_isv,
        :sale_subtotal,
        :sale_status;
        ";


        $sqlParams= [
            "customer_id" => $customer_id, 
            "sale_isv" => $sale_isv, 
            "sale_subtotal" => $sale_subtotal,
            "sale_status" => $sale_status
        ]; 

        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    public static function insertarDetalle($sale_id, $product_id, $sale_quantity, $sale_price) {
        $sqlstr= "INSERT INTO `sales_details`
        (`sale_id`,
        `product_id`,
        `sale_quantity`,
        `sale_price`)
        VALUES
        (:sale_id,
        :product_id,
        :sale_quantity,
        :sale_price);
        ";

        $sqlParams= [
            "sale_id" => $sale_id, 
            "product_id" => $product_id,
            "sale_quantity" => $sale_quantity,
            "sale_price" => $sale_price
        ];

        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    public static function getLastSaleId () {
        $sqlstr= "select MAX(sale_id) sale_id from sales;";

        return self::obtenerUnRegistro($sqlstr, array());
    }

    

}

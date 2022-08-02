<?php


namespace Dao\Admin;

use Dao\Table;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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

    public static function insertVenta($customer_id, $sale_isv, $sale_subtotal, $sale_status, $sale_order_id) {
        $sqlstr= "INSERT INTO sales
        (
        `sale_date`,
        `customer_id`,
        `sale_isv`,
        `sale_subtotal`,
        `sale_status`,
        `sale_order_id`)
        VALUES
        (
         now(),
        :customer_id,
        :sale_isv,
        :sale_subtotal,
        :sale_status,
        :sale_order_id
        )";


        $sqlParams= [
            "customer_id" => $customer_id, 
            "sale_isv" => $sale_isv, 
            "sale_subtotal" => $sale_subtotal,
            "sale_status" => $sale_status,
            "sale_order_id" => $sale_order_id
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

    public static function getClientesCombo() {
        $sqlstr= "SELECT customer_id,CONCAT(customer_name, ' ', customer_lastname) as 'Nombre', s.useremail from customers c 
        inner join usuario s on c.usercod= s.usercod;";

        return self::obtenerRegistros($sqlstr, array());
    }

    public static function getAllProductsI() {
        $sqlstr= "SELECT i.product_id, p.product_name, p.product_price, i.inventory_size, i.inventory_gender 
        FROM inventory i inner join products p on i.product_id=p.product_id;";

        return self::obtenerRegistros($sqlstr, array());
    }

    public static function lessInventory($quantity, $id, $gender, $size) {
        $sqlstr= "SELECT lessInventory(:id, :quantity, :gender, :size);";

        $sqlParams= [
            "id" => $id, 
            "quantity" => $quantity, 
            "gender" => $gender, 
            "size" => $size
        ];

        return self::obtenerUnRegistro($sqlstr, $sqlParams);

    }

    public static function plusInventory($quantity, $id, $gender, $size) {
        $sqlstr= "SELECT plusInventory(:id, :quantity, :gender, :size);";

        $sqlParams= [
            "id" => $id, 
            "quantity" => $quantity, 
            "gender" => $gender, 
            "size" => $size
        ];

        return self::obtenerUnRegistro($sqlstr, $sqlParams);

    }

    public static function getDetalleVentaBySale($sale_id) {
        $sqlstr= "SELECT P.product_id, P.product_name, SD.sale_price, SD.sale_quantity FROM sales_details SD inner join products P on SD.product_id= P.product_id
        WHERE SD.sale_id= :sale_id;";

        $sqlParams= [
            "sale_id" => $sale_id
        ];

        return self::obtenerRegistros($sqlstr, $sqlParams);
    }

    public static function getVentaById($sale_id) {
        $sqlstr= "SELECT sale_id,  customer_id as cus_id, sale_status FROM sales WHERE sale_id = :sale_id;";
        $sqlParams= [
            "sale_id" => $sale_id
        ];

        return self::obtenerUnRegistro($sqlstr, $sqlParams);
    }

    public static function updateStatusVenta($sale_id, $sale_status) {
        $sqlstr= "UPDATE sales SET sale_status= :sale_status where sale_id= :sale_id; ";
        $sqlParams= [
            "sale_status" => $sale_status,
            "sale_id" => $sale_id
        ];

        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    public static function sendEmail($email, $pin) {
        $mail = new PHPMailer();
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "josue14saravia@gmail.com";
        $mail->Password = "bkebajjzwbzlqplm";
        $mail->SetFrom("josue14saravia@gmail.com");
        $mail->Subject = "Asunto del mensaje";
        $mail->Body = "El pin para cambio de su contraseña es: ". $pin;
        $mail->AddAddress($email);
        if(!$mail->Send()) {
           return $errorMail= false;
        } else {
          return $errorMail= true;
        }
    }

    

}

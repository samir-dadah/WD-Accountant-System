<?php
defined('MR') or exit('No direct script access allowed');



// website link 
define('SYSTEM_ROOT', $_SERVER['DOCUMENT_ROOT'].'/invoice/');
define('SYSTEM_BASE_URL_WEB', 'https://walidonline.wd-de.de/invoice/');
define('PUBLIC_SYSTEM_ROOT', $_SERVER['DOCUMENT_ROOT'].'/contract/');
define('PUBLIC_BASE_URL', "https://walidonline.wd-de.de/contract/");



// offline update 
//define('SYSTEM_ROOT', $_SERVER['DOCUMENT_ROOT'].'/mr_invoice/v-21-09-2023/invoice/');
//define('SYSTEM_BASE_URL_WEB', 'http://localhost/mr_invoice/v-21-09-2023/invoice/');
//define('PUBLIC_SYSTEM_ROOT', $_SERVER['DOCUMENT_ROOT'].'/mr_invoice/v-21-09-2023/contract/');
//define('PUBLIC_BASE_URL', "http://localhost/mr_invoice/v-21-09-2023/contract/");


$localhosthost ='localhost';
$database_name='u323244828_walidon';
$database_user='u323244828_walidaccount';
$database_pass='Gw@460445';

//$database_name = 'mr_invoice';
//$database_user = 'root';
//$database_pass = '';

$ver = '1.0';
$connect = new PDO("mysql:host=localhost;dbname=$database_name", "$database_user", "$database_pass");


function get_s($key)
{
    global $connect;

    $statement_setting = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
    $statement_setting->execute();
    $result_setting = $statement_setting->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_setting as $row) {
        return $row[$key];
    }
}

function get_l($key)
{
    global $connect;
    $statement = $connect->prepare("SELECT * FROM mr_language  WHERE phrase_key = :phrase_key");
    $statement->execute(array(':phrase_key' => $key ));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row_language) {
       return $row_language['phrase'];
    }
}

function get_customer_data($customer_id){
    global $connect;
	$query = "SELECT * FROM mr_customer WHERE customer_id = '".$customer_id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row){
		return $row;
	}
}	
function get_order_data($code){
    global $connect;
    $query = "SELECT * FROM mr_order WHERE code =:code";
    $statement = $connect->prepare($query);
    $statement->execute(array( ':code'=> $code));
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row;
    }
}
function get_order_data_by_id($order_id){
    global $connect;
    $query = "SELECT * FROM mr_order WHERE order_id =:order_id";
    $statement = $connect->prepare($query);
    $statement->execute(array( ':order_id'=> $order_id));
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row;
    }
}
function get_contract_data($code){
    global $connect;
    $query = " SELECT * FROM mr_contract WHERE code = :code LIMIT 1";
    $statement = $connect->prepare($query);
    $statement->execute(array(':code' => $code ));
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row;
    }

}

function get_quotation_data($code){
    global $connect;
    $query = " SELECT * FROM mr_quotation WHERE code = :code LIMIT 1";
    $statement = $connect->prepare($query);
    $statement->execute(array(':code' => $code ));
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row;
    }

}
function get_delivery_data($code){
    global $connect;
    $query = " SELECT * FROM mr_delivery WHERE code = :code LIMIT 1";
    $statement = $connect->prepare($query);
    $statement->execute(array(':code' => $code ));
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        return $row;
    }

}
function fetch_product_details($product_id){
    global $connect;
	$query = "SELECT * FROM mr_product WHERE product_id = '".$product_id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['product_name'] = $row["product_name"];
		$output['quantity'] = $row["product_qty"];
		$output['price'] = $row['product_base_price'];
		$output['tax'] = $row['product_tax'];
		$output['unit'] = $row['product_unit'];
		
	}
	return $output;
}	
function get_products_by_type($table_name,$col,$content_id){
    global $connect;
    $product_data = array();
    $query = " SELECT * FROM ".$table_name." WHERE ".$col." = :".$col." ";
    $statement = $connect->prepare($query);
    $statement->execute(array(':'.$col.'' => $content_id ));
    $result = $statement->fetchAll();
    if($result){
        foreach($result as $row){
            $product = fetch_product_details($row['product_id']);
            $product_data[] = array(
                ''.$col.'' => $row[''.$col.''],
                'product_id' => $row['product_id'],
                'product_name' => $product['product_name'],
                'quantity' => $row['quantity'],
                'price'   => $row['price'],
                'tax'     => $row['tax']
            );
        }
    }
    return $product_data;
}

function get_payment_method_name($id){
    global $connect;
	$query = "SELECT name FROM mr_payment_method WHERE id = '".$id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row){
		return $row['name'];
	}
}	
function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function load_email_view($file,$data){
    ob_start();
    require(PUBLIC_SYSTEM_ROOT.$file.".php");
    return ob_get_clean();
}

function price_format($price_number){
	$output =	number_format($price_number,2,',','.');
    return $output;
}

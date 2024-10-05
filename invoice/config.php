<?php 
// +------------------------------------------------------------------------+
// | PHP MR WEBSITE LIST  ( www.mrdev.xyz/weblist/)
// +------------------------------------------------------------------------+
// | PHP MR WEBSITE LIST IS NOT FREE SOFTWARE
// | If you have downloaded this software from a website other
// | than www.mrdev.xyz or if you have received
// | this software from someone who is not a representative of
// | MRDEV, you are involved in an illegal activity.
// | ---
// | In such case, please contact: support@mrdev.xyz
// +------------------------------------------------------------------------+
// | Developed by: MR DEV (www.mrdev.xyz) / support@mrdev.xyz
// | Copyright: (c) 2020-2021 MRDEV. All rights reserved.
// +------------------------------------------------------------------------+




$database_name='u323244828_walidon';
$database_user='u323244828_walidaccount';
$database_pass='Gw@460445';

//$database_name='mr_invoice';
//$database_user='root';
//$database_pass='';

$ver='1.0';

$connect = new PDO("mysql:host=localhost;dbname=$database_name", "$database_user", "$database_pass");



$statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$qr_background = $row['qr_background'];
	$qr_size = $row['qr_size'];
	$address = $row['address'];
	$qr_color = $row['qr_color'];
	$qr_logo = $row['qr_logo'];
	$qr_logo_size = $row['qr_logo_size'];
	$invoice_bottom_content = $row['invoice_bottom_content'];
    $tax_system = $row['tax_system'];
	$invoice_prfex = $row['invoice_prfex'];
	$invoice_no = $row['invoice_no'];
	$title = $row['title'];
	$tax_rate = $row['tax_rate'];
	$invoice_background =$row['invoice_background'];
	$logo_link =$row['logo_link'];
	//$ccsympol =$row['ccsympol'];
	$ccsympol ='<span style="font-family: DejaVu Sans; sans-serif;">€</span>';
	$outgoing_admin_mail =$row['outgoing_admin_mail'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$company_city =$row['company_city'];
	$company_postcode=$row['company_postcode'];
	$company_email=$row['company_email'];
	$company_number=$row['company_number'];
	$conditions_page_link =$row['conditions_page_link'];
	$conditions_page_title=$row['conditions_page_title'];
}


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

$statement4 = $connect->prepare("SELECT * FROM mr_language  ");
$statement4->execute();
$result4 = $statement4->fetchAll(PDO::FETCH_ASSOC);
foreach ($result4 as $row_language)
{
	define($row_language['phrase_key'], $row_language['phrase']);
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




// website link 
$base_url = "https://walidonline.wd-de.de/invoice/";
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/invoice/');
define('BASE_URL_WEB', $base_url);
define('BASE_URL_PUBLIC', "https://walidonline.wd-de.de/contract/");


//$base_url = "http://localhost/mr_invoice/v-21-09-2023/invoice/";
//define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/mr_invoice/v-21-09-2023/invoice/');
//define('BASE_URL_WEB', $base_url);
//define('BASE_URL_PUBLIC', "http://localhost/mr_invoice/v-21-09-2023/contract/");


function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}
function fill_product_list($connect)
{
	$query = "
	SELECT * FROM mr_product 
	WHERE product_status = 'active' 
	ORDER BY product_name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["product_id"].'">'.$row["product_name"].'</option>';
	}
	return $output;
}
function fill_customer_list($connect)
{
	$query = "
	SELECT * FROM mr_customer 
	
	ORDER BY company ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["customer_id"].'">'.$row["company"].'</option>';
	}
	return $output;
}
function fill_order_list($connect)
{
	$query = "
	SELECT * FROM mr_order 
	
	ORDER BY invoice_no ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["order_id"].'">'.$row["invoice_no"].'</option>';
	}
	return $output;
}

function fill_quotation_list($connect)
{
	$query = "
	SELECT * FROM mr_quotation 
	
	ORDER BY quotation_id  ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["quotation_id"].'">'.$row["quotation_id"].'</option>';
	}
	return $output;
}


	function get_user_name($connect, $user_id)
{
	$query = "
	SELECT user_name FROM mr_admin WHERE admin_id = '".$user_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['user_name'];
	}
}	
	function get_customer_data($connect, $customer_id)
{
	$query = "
	SELECT * FROM mr_customer WHERE customer_id = '".$customer_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row;
	}
}	

function fill_payment_method_list($connect)
{
	$query = "
	SELECT * FROM mr_payment_method 
	
	ORDER BY name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
	}
	return $output;
}
function fill_product_unit_list($connect)
{
	$query = "
	SELECT * FROM mr_product_unit 
	
	ORDER BY name ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
	}
	return $output;
}
	function get_payment_method_name($connect, $id)
{
	$query = "
	SELECT name FROM mr_payment_method WHERE id = '".$id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['name'];
	}
}	

function fetch_product_details($product_id, $connect)
{

	$query = "
	SELECT * FROM mr_product 
	WHERE product_id = '".$product_id."'";
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

function available_product_quantity($connect, $product_id)
{
	$product_data = fetch_product_details($product_id, $connect);
	$query = "
	SELECT 	mr_order_product.quantity FROM mr_order_product 
	INNER JOIN mr_order ON mr_order.order_id = mr_order_product.order_id
	WHERE mr_order_product.product_id = '".$product_id."' AND
	mr_order.order_status = 'active'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total = 0;
	foreach($result as $row)
	{
		$total = $total + $row['quantity'];
	}
	$available_quantity = intval($product_data['quantity']) - intval($total);
	if($available_quantity == 0)
	{
		$update_query = "
		UPDATE mr_product SET 
		product_status = 'inactive' 
		WHERE product_id = '".$product_id."'
		";
		$statement = $connect->prepare($update_query);
		$statement->execute();
	}
	return $available_quantity;
}


function count_total_order_value($connect)
{
	$query = "
	SELECT sum(order_total) as total_order_value FROM mr_order 
	WHERE order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["mr_admin"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}
function count_total_cash_order_value($connect)
{
	$query = "
	SELECT sum(order_total) as total_order_value FROM mr_order 
	WHERE payment_status = 'cash' 
	AND order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["mr_admin"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function count_total_credit_order_value($connect)
{
	$query = "
	SELECT sum(order_total) as total_order_value FROM mr_order WHERE payment_status = 'credit' AND order_status='active'
	";
	if($_SESSION['type'] == 'user')
	{
		$query .= ' AND user_id = "'.$_SESSION["mr_admin"].'"';
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return number_format($row['total_order_value'], 2);
	}
}

function load_social_links($connect)
{
	$query = "
	SELECT * FROM mr_social
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '<ul class="social_items">';
	foreach($result as $row)
	{
		if ($row["social_type"]=='tel'){
		    
			$logo_image = file_get_contents(BASE_URL_WEB.'images/tel.png');
            $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);

			
	$output .= '<li><a href="tel:'.$row["social_link"].'" target="_blank" ><img src="'.$logo_base64.'
		" style="width:15px;height:15px;margin-right:5px;">'.$row["social_link"].'</a></li>';
			
		}
		if ($row["social_type"]=='fax'){
		    
			$logo_image = file_get_contents(BASE_URL_WEB.'images/fax.png');
            $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);

			
	$output .= '<li><a href="tel:'.$row["social_link"].'" target="_blank" ><img src="'.$logo_base64.'
		" style="width:15px;height:15px;margin-right:5px;">'.$row["social_link"].'</a></li>';
			
		}		
		if ($row["social_type"]=='email'){
		    
		$logo_image = file_get_contents(BASE_URL_WEB.'images/email.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);
			
			$output .= '<li><a href="mailto:'.$row["social_link"].'" target="_blank" ><img src="'.$logo_base64.'
		" style="width:15px;height:15px;margin-right:5px;"> '.$row["social_link"].'</a></li>';
			
		}		
		if ($row["social_type"]=='link'){
			
		$logo_image = file_get_contents(BASE_URL_WEB.'images/web.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);			
			if (strpos($row["social_link"],'http://') === false){
   			 $domain = 'http://'.$row["social_link"];
			}
			
			
			$output .= '<li><a href="'.$domain.'" target="_blank" ><img src="'.$logo_base64.'
		" style="width:15px;height:15px;margin-right:5px;">'.$row["social_link"].'</a></li>';
			
		}		
		if ($row["social_type"]=='text'){
		$logo_image = file_get_contents(BASE_URL_WEB.'images/location.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);			
			$output .= '<li><img src="'.$logo_base64.'
		" style="width:15px;height:15px;margin-right:5px;">'.$row["social_link"].'</li>';
			
		}
		
		
		
		
		
	}
	
	$output.='</ul>';
	return $output;
}

	function to_domain($url){
		
			$input = $url;

		$input = trim($input, '/');

		if (!preg_match('#^http(s)?://#', $input)) {
			$input = 'http://' . $input;
		}

		$urlParts = parse_url($input);

		$domain = preg_replace('/^www\./', '', $urlParts['host']);
			
			return $domain;
	}


	function to_url($url){

			if (strpos($url,'http://') === false){
				$url = 'http://'.$url;
				return $url;
			}
	}

	function send_email($receiver_email,$from_email,$from_name, $subject, $body){
		$mail = new PHPMailer;

		//$mail->IsSMTP();

		//$mail->Host = '';

		//$mail->Port = '';

		//$mail->SMTPAuth = true;

		//$mail->Username = '';

		//$mail->Password = '';

		//$mail->SMTPSecure = '';
		$mail->CharSet = 'UTF-8';

		$mail->From = $from_email;

		$mail->FromName = $from_name;

		$mail->AddAddress($receiver_email, '');

		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();		
	}
	
 	function createInvoiceNo($connect) {
			$statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row){	
			$invoice_no_start = $row['invoice_no'];
			}
			$statement = $connect->prepare("SELECT MAX(invoice_no) AS invoice_no FROM mr_order");
			$statement->execute();
		
			$invoice_no = $statement->fetchColumn();
	
			if ($invoice_no) {
				$invoice_no = $invoice_no + 1;
			} else {
				$invoice_no = $invoice_no_start;
			}

			return $invoice_no;
		
	}

	function createCustomerNo($connect) {

		$statement = $connect->prepare("SELECT MAX(customer_no) AS customer_no FROM mr_customer");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$customer_no=$row['customer_no'];
		}

			if ($customer_no) {
				$customer_no = $customer_no + 1;
			} else {
				$customer_no = 1;
			}

			return $customer_no;
		
	}

	function get_order_data($connect, $code){
			$query = "
			SELECT * FROM mr_order WHERE code =:code
			";
			$statement = $connect->prepare($query);
			$statement->execute(array( ':code'=> $code));
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				return $row;
			}
	}
	function get_order_data_by_id($connect, $order_id){
		$query = "
		SELECT * FROM mr_order WHERE order_id =:order_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(array( ':order_id'=> $order_id));
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			return $row;
		}
}
	function get_contract_data($connect, $code){
		$query = " SELECT * FROM mr_contract WHERE code = :code LIMIT 1";
		$statement = $connect->prepare($query);
		$statement->execute(array(':code' => $code ));
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			return $row;
		}

	}
	function get_quotation_data($connect, $code){
		$query = " SELECT * FROM mr_quotation WHERE code = :code LIMIT 1";
		$statement = $connect->prepare($query);
		$statement->execute(array(':code' => $code ));
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			return $row;
		}

	}
	function get_delivery_data($connect, $code){
		$query = " SELECT * FROM mr_delivery WHERE code = :code LIMIT 1";
		$statement = $connect->prepare($query);
		$statement->execute(array(':code' => $code ));
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			return $row;
		}

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
				$product = fetch_product_details($row['product_id'], $connect);
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



 	function price_format($price_number){
	
	
		$output =	number_format($price_number,2,',','.');

		//$output = sprintf("%02d", $output);
			
			return $output;
	}


	function new_price_format($number, $symbol_left='', $symbol_right = '', $format = true) {
		
	
		$decimal_place = 2;


		$amount = $number;
		
		$amount = round($amount, (int)$decimal_place);
		
		if (!$format) {
			return $amount;
		}

		$string = '';

		if ($symbol_left) {
			$string .= '<div class="ccsymbol" >'.$symbol_left.'</div>';
		}

		$string .= '<div class="ccsymbol">'.number_format($amount, (int)$decimal_place, ',', '.').'</div> ';

		if ($symbol_right) {
			$string .= ' '.'';
		}

		return $string;
	}

	function getUserIP()
	{
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
		require(ROOT.$file.".php");
		return ob_get_clean();
	}
	
?>
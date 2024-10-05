<?php
if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
    die('No direct script access allowed');
}
include('config.php');
session_start();


if (isset($_POST["action"])) {

    //Get_Quotations

    if ($_POST['action'] == 'Get_Quotations') {

        $query = '';

        $output = array();

        $query .= " SELECT * FROM mr_quotation  ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE (quotation_id   LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR quotation_date LIKE "%' . $_POST["search"]["value"] . '%") ';
        }
        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY quotation_id DESC ';
        }
        if ($_POST["length"] != -1) {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $data = array();
        $filtered_rows = $statement->rowCount();
        foreach ($result as $row) {
            $customer_data= get_customer_data($connect, $row['customer_id']);
            $sub_array = array();
            $sub_array[] = $row['quotation_id'];
            $sub_array[] = $customer_data['company'];
            $sub_array[] ='<p style="direction:ltr;display: flex;flex-direction: column;color: black;"><span> total : '. price_format($row['quotation_total']) .'  '.$ccsympol .'</span> <span>  tax : ' . price_format($row['total_tax']).' '.$ccsympol.'</span></p>';
            $sub_array[] = $row['quotation_date'];
            $sub_array[] = $row['date_added'];
            $sub_array[] = $row['date_updated'];
			$url = BASE_URL_PUBLIC. 'quotation.php?code=' .$row["code"].'&pdfview=1';
            $sub_array[] = '<button type="button" name="make_qr" id="'.$url.'" data-name="'.$customer_data['company'].'.png" class="btn btn-dark btn-xs make_qr">صنع QR </button>
            <button class="btn btn-primary m-2 MR_copy_clipboard"  data-clipboard-text="'.$url.'"><i class="far fa-copy"></i></button>';
            $sub_array[] = '
            <a href="quotation_view.php?code='.$row["code"].'" class="btn btn-info btn-xs m-2">تحميل PDF</a>
			<a href="quotation_view.php?code='.$row["code"].'&pdfview=1" class="btn btn-info btn-xs m-2">عرض PDF</a>';
            $sub_array[] = '<button type="button" name="update" id="'.$row["quotation_id"].'" class="btn btn-warning btn-xs update">تحديث</button>';
            $data[] = $sub_array;
        }
        function get_total_all_records($connect)
        {
            $statement = $connect->prepare("SELECT * FROM mr_quotation");
            $statement->execute();
            return $statement->rowCount();
        }
        $output = array(
            "draw"                =>     intval($_POST["draw"]),
            "recordsTotal"      =>  $filtered_rows,
            "recordsFiltered"     =>     get_total_all_records($connect),
            "data"                =>     $data
        );
        echo json_encode($output);
    }

    //add_new

    if ($_POST['action'] == 'add_new') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();

        $valid_keys = [
            "customer_id",
            "quotation_date",
            "quotation_number",
            "payment_status",
            "shipping_cost",
            "first_payment",
            "discount_total",
            "comment",
            "password",
            "product_id",
            "price",
            "quantity"
        ];
        foreach ($valid_keys as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '';
            }
        }

        $required_keys = [
            "customer_id",
            "quotation_date"
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] = 'هذا الحقل مطلوب';
            }
        }
        if ($error == 0) {

            $password ='';
            if(isset($_POST["password"]) && $_POST["password"] !== ''){
                $password = $_POST["password"];
            }

            $data =array(
                ':customer_id'  => $_POST["customer_id"],
                ':quotation_date'		=>	$_POST["quotation_date"],
				':payment_status'		=>	$_POST["payment_status"],
                ':shipping_cost'		=>	$_POST["shipping_cost"],
				':first_payment'		=>	$_POST["first_payment"],
				':discount_total'		=>	$_POST["discount_total"],
                ':comment'		=>	$_POST["comment"],
                ':code' => md5(microtime().rand()),
                ':password'		=>	$password,
                ':date_added' =>date("Y-m-d H:i:s"),
                ':date_updated' => date("Y-m-d H:i:s")
			);
            $query = " INSERT INTO mr_quotation 
            (  `customer_id`, `quotation_date`,
             `payment_status`, `shipping_cost`, `first_payment`,
                `discount_total`, `comment`,`code`, `password`, `date_added`, `date_updated`) 
            VALUES
            (:customer_id,:quotation_date,
            :payment_status, :shipping_cost,:first_payment,
              :discount_total,:comment,:code,:password,:date_added,:date_updated
              )";	
            $statement = $connect->prepare($query);
               if($statement->execute($data)){

                    $quotation_id  =$connect->lastInsertId();

                    $total_amount = 0;
                    $total_tax =0;
					for($count = 0; $count<count($_POST["product_id"]); $count++){
                        $product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				    $sub_query = "INSERT INTO mr_quotation_product 
                    (quotation_id, product_id, quantity, price, tax) VALUES 
                    (:quotation_id, :product_id, :quantity, :price, :tax)";
                    $statement = $connect->prepare($sub_query);
					$statement->execute(
							array(
								':quotation_id'	=>	$quotation_id,
								':product_id'			=>	$_POST["product_id"][$count],
								':quantity'				=>	$_POST["quantity"][$count],
								':price'				=>	$_POST["price"][$count],
								':tax'					=>	$product_details['tax']
							)
						);
                        $base_price = 	$_POST["price"][$count];
						$tax = ($base_price/100)*$product_details['tax'];
						$total_amount = $total_amount + $base_price ;
                        $total_tax = $total_tax + $tax ;
                    }
                    $update_query = "
					UPDATE mr_quotation 
					SET quotation_total = '".$total_amount."' , total_tax = '".$total_tax."'
					WHERE quotation_id = '".$quotation_id."'
					";
					$statement = $connect->prepare($update_query);
					if($statement->execute()){
                        
                    $output = array(
                        'success'        =>    true,
                        'success_msg'    =>    'تم اضافة عرض السعر  بنجاح'
                    ); 
                    }
               }
        }
        if ($error > 0) {
            $output = array(
                'error'        =>    true,
                'error_msg'    =>    $error_msg
            );
        }
        echo json_encode($output);
    }

    //GET_quotation_DATA

    if($_POST['action'] == 'GET_quotation_DATA')
	{
		$query = "
		SELECT * FROM mr_quotation WHERE quotation_id = :quotation_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':quotation_id'	=>	$_POST["quotation_id"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach($result as $row)
		{
			$output['customer_id'] = $row['customer_id'];
			$output['quotation_date'] = $row['quotation_date'];			
			$output['payment_status'] = $row['payment_status'];
			$output['shipping_cost'] = $row['shipping_cost'];
			$output['first_payment'] = $row['first_payment'];			
			$output['discount_total'] = $row['discount_total'];
			$output['comment'] = $row['comment'];	
            $output['password'] = $row['password'];	
            $output['quotation_id'] = $row['quotation_id'];			
		
		}
		$sub_query = "
		SELECT * FROM mr_quotation_product 
		WHERE quotation_id = '".$_POST["quotation_id"]."'
		";
		$statement = $connect->prepare($sub_query);
		$statement->execute();
		$sub_result = $statement->fetchAll();
		$product_details = '';
		$count = 0;
		foreach($sub_result as $sub_row)
		{$count = $count + 1;
			$product_details .= '
			<script>
			$(document).ready(function(){
				$("#product_id'.$count.'").selectpicker("val", '.$sub_row["product_id"].');
				$(".selectpicker").selectpicker();
			});
			</script>
			<span id="row'.$count.'">
				<div class="row">
					<div class="col-md-5"><label>المنتج</label>
						<select name="product_id[]" id="product_id'.$count.'" class="form-control selectpicker" data-live-search="true" required>
							'.fill_product_list($connect).'
						</select>
						<input type="hidden" name="hidden_product_id[]" id="hidden_product_id'.$count.'" value="'.$sub_row["product_id"].'" />
					</div>
					
					<div class="col-md-3"><label>السعر</label>
					<input type="text" name="price[]" id="product_price'.$count.'" class="form-control" required value="'.$sub_row["price"].'" /></div>
					
					<div class="col-md-3"><label>الكمية</label>
						<input type="text" name="quantity[]" class="form-control" value="'.$sub_row["quantity"].'" required />
					</div>
					<div class="col-md-1">
			';

			if($count == 1)
			{
				$product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				$product_details .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
			}
			$product_details .= '
						</div>
					</div>
				</div><br />
			</span>
			';
			
		}
		$output['product_details'] = $product_details;
        $output['count'] =$count;
		echo json_encode($output);
	}

    //edit_quotation
    if ($_POST['action'] == 'edit_quotation') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();
        $valid_keys = [
            "customer_id",
            "quotation_date",
            "quotation_number",
            "payment_status",
            "shipping_cost",
            "first_payment",
            "discount_total",
            "comment",
            "password",
            "product_id",
            "price",
            "quantity",
            "quotation_id"
        ];
        foreach ($valid_keys as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '';
            }
        }

        $required_keys = [
            "customer_id",
            "quotation_date"
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] = 'هذا الحقل مطلوب';
            }
        }

        if ($error == 0) {

            $password ='';
            if(isset($_POST["password"]) && $_POST["password"] !== ''){
                $password = $_POST["password"];
            }

            $delete_query = "DELETE FROM mr_quotation_product 
            WHERE quotation_id = '".$_POST["quotation_id"]."' ";
            $statement = $connect->prepare($delete_query);
            $statement->execute();
            $total_amount = 0;
            $total_tax =0;
            for($count = 0; $count<count($_POST["product_id"]); $count++){
                $product_details = fetch_product_details($_POST["product_id"][$count], $connect);
            $sub_query = "INSERT INTO mr_quotation_product 
            (quotation_id, product_id, quantity, price, tax) VALUES 
            (:quotation_id, :product_id, :quantity, :price, :tax)";
            $statement = $connect->prepare($sub_query);
            $statement->execute(
                    array(
                        ':quotation_id'	=>	$_POST["quotation_id"],
                        ':product_id'			=>	$_POST["product_id"][$count],
                        ':quantity'				=>	$_POST["quantity"][$count],
                        ':price'				=>	$_POST["price"][$count],
                        ':tax'					=>	$product_details['tax']
                    )
                );
                $base_price = 	$_POST["price"][$count];
                $tax = ($base_price/100)*$product_details['tax'];
                $total_amount = $total_amount + $base_price ;
                $total_tax = $total_tax + $tax ;
            }

            $data =array(
                ':customer_id'  => $_POST["customer_id"],
                ':quotation_date'		=>	$_POST["quotation_date"],
				':payment_status'		=>	$_POST["payment_status"],
                ':quotation_total'      => $total_amount,
                ':total_tax'            =>$total_tax,
                ':shipping_cost'		=>	$_POST["shipping_cost"],
				':first_payment'		=>	$_POST["first_payment"],
				':discount_total'		=>	$_POST["discount_total"],
                ':comment'		=>	$_POST["comment"],
                ':password'		=>	$password,
                ':date_updated' => date("Y-m-d H:i:s"),
                ':quotation_id'		=>	$_POST["quotation_id"]
			);

            $query = " UPDATE mr_quotation SET
            `customer_id`=:customer_id,
            `quotation_date`=:quotation_date,
            `payment_status`=:payment_status,
            `quotation_total` =:quotation_total,
            `total_tax` =:total_tax,
            `shipping_cost`=:shipping_cost,
            `first_payment`=:first_payment,
            `discount_total`=:discount_total,
            `comment`=:comment,
            `password`=:password,
            `date_updated`=:date_updated
            
            WHERE quotation_id = :quotation_id ";
            $statement = $connect->prepare($query);
            if($statement->execute($data)){
                $output = array(
                    'success'        =>    true,
                    'success_msg'    =>    'تم تعديل عرض السعر بنجاح '
                );               
           }

        }

        if ($error > 0) {
            $output = array(
                'error'        =>    true,
                'error_msg'    =>    $error_msg
            );
        }
        echo json_encode($output);
    }



}


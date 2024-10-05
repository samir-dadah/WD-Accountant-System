<?php
if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
    die('No direct script access allowed');
}
include('config.php');
session_start();


if (isset($_POST["action"])) {

    //Get_Delivery

    if ($_POST['action'] == 'Get_Delivery') {

        $query = '';

        $output = array();

        $query .= " SELECT * FROM mr_delivery  ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE (delivery_id   LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR delivery_date LIKE "%' . $_POST["search"]["value"] . '%") ';
        }
        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY delivery_id DESC ';
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
            $order_data = get_order_data_by_id($connect, $row['order_id']);

            $sub_array = array();
            $sub_array[] = $row['delivery_id'];
            $sub_array[] = $customer_data['company'];
            $sub_array[] =$order_data['invoice_no'];
            $sub_array[] = $row['delivery_date'];
            $sub_array[] = $row['date_added'];
            $sub_array[] = $row['date_updated'];
			$url = BASE_URL_PUBLIC. 'delivery.php?code=' .$row["code"].'&pdfview=1';
            $sub_array[] = '<button type="button" name="make_qr" id="'.$url.'" data-name="'.$customer_data['company'].'.png" class="btn btn-dark btn-xs make_qr">صنع QR </button>
            <button class="btn btn-primary m-2 MR_copy_clipboard"  data-clipboard-text="'.$url.'"><i class="far fa-copy"></i></button>';
            $sub_array[] = '
            <a href="delivery_view.php?code='.$row["code"].'" class="btn btn-info btn-xs m-2">تحميل PDF</a>
			<a href="delivery_view.php?code='.$row["code"].'&pdfview=1" class="btn btn-info btn-xs m-2">عرض PDF</a>';
            $sub_array[] = '<button type="button" name="update" id="'.$row["delivery_id"].'" class="btn btn-warning btn-xs update">تحديث</button>';
            $data[] = $sub_array;
        }
        function get_total_all_records($connect)
        {
            $statement = $connect->prepare("SELECT * FROM mr_delivery");
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
            "order_id",
            "customer_id",
            "delivery_date",
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
            "order_id",
            "delivery_date"
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
                ':order_id'		=>	$_POST["order_id"],
                ':customer_id'  => $_POST["customer_id"],
                ':delivery_date'		=>	$_POST["delivery_date"],
                ':comment'		=>	$_POST["comment"],
                ':code' => md5(microtime().rand()),
                ':password'		=>	$password,
                ':date_added' =>date("Y-m-d H:i:s"),
                ':date_updated' => date("Y-m-d H:i:s")
			);
            $query = " INSERT INTO mr_delivery 
            (`order_id`,`customer_id`,`delivery_date`,`comment`,`code`,`password`,`date_added`,`date_updated`) 
            VALUES
            (:order_id,:customer_id,:delivery_date,:comment,:code,:password,:date_added,:date_updated)";	
            $statement = $connect->prepare($query);
               if($statement->execute($data)){

                    $delivery_id  =$connect->lastInsertId();

                    $total_amount = 0;
                    $total_tax =0;
					for($count = 0; $count<count($_POST["product_id"]); $count++){
                        $product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				    $sub_query = "INSERT INTO mr_delivery_product 
                    (delivery_id, product_id, quantity, price, tax) VALUES 
                    (:delivery_id, :product_id, :quantity, :price, :tax)";
                    $statement = $connect->prepare($sub_query);
					$statement->execute(
							array(
								':delivery_id'	=>	$delivery_id,
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

                    
                    $output = array(
                        'success'        =>    true,
                        'success_msg'    =>    'تم اضافة ملف تسليم فاتورة  بنجاح'
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

    //GET_delivery_DATA

    if($_POST['action'] == 'GET_delivery_DATA')
	{
		$query = "
		SELECT * FROM mr_delivery WHERE delivery_id = :delivery_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':delivery_id'	=>	$_POST["delivery_id"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach($result as $row)
		{
            $output['order_id'] = $row['order_id'];
			$output['customer_id'] = $row['customer_id'];
			$output['delivery_date'] = $row['delivery_date'];			
			$output['comment'] = $row['comment'];	
            $output['password'] = $row['password'];	
            $output['delivery_id'] = $row['delivery_id'];			
		
		}
		$sub_query = "
		SELECT * FROM mr_delivery_product 
		WHERE delivery_id = '".$_POST["delivery_id"]."'
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

    //edit_delivery
    if ($_POST['action'] == 'edit_delivery') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();
        $valid_keys = [
            "order_id",
            "customer_id",
            "delivery_date",
            "comment",
            "password",
            "product_id",
            "price",
            "quantity",
            "delivery_id"
        ];
        foreach ($valid_keys as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '';
            }
        }

        $required_keys = [
            "order_id",
            "customer_id",
            "delivery_date"
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

            $delete_query = "DELETE FROM mr_delivery_product 
            WHERE delivery_id = '".$_POST["delivery_id"]."' ";
            $statement = $connect->prepare($delete_query);
            $statement->execute();
            $total_amount = 0;
            $total_tax =0;
            for($count = 0; $count<count($_POST["product_id"]); $count++){
                $product_details = fetch_product_details($_POST["product_id"][$count], $connect);
            $sub_query = "INSERT INTO mr_delivery_product 
            (delivery_id, product_id, quantity, price, tax) VALUES 
            (:delivery_id, :product_id, :quantity, :price, :tax)";
            $statement = $connect->prepare($sub_query);
            $statement->execute(
                    array(
                        ':delivery_id'	=>	$_POST["delivery_id"],
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
                ':order_id'		=>	$_POST["order_id"],
                ':customer_id'  => $_POST["customer_id"],
                ':delivery_date'		=>	$_POST["delivery_date"],    
                ':comment'		=>	$_POST["comment"],
                ':password'		=>	$password,
                ':date_updated' => date("Y-m-d H:i:s"),
                ':delivery_id'		=>	$_POST["delivery_id"]
			);

            $query = " UPDATE mr_delivery SET
            `order_id`=:order_id,
            `customer_id`=:customer_id,
            `delivery_date`=:delivery_date,
            `comment`=:comment,
            `password`=:password,
            `date_updated`=:date_updated
            
            WHERE delivery_id = :delivery_id ";
            $statement = $connect->prepare($query);
            if($statement->execute($data)){
                $output = array(
                    'success'        =>    true,
                    'success_msg'    =>    'تم تعديل ملف تسليم فاتورة بنجاح '
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


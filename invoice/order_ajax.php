<?php

include('config.php');

session_start();

if (isset($_POST["action"])) {

	if ($_POST["action"] == "fetchorder") {

		$query = '';

		$output = array();

		$query .= " SELECT * FROM mr_order WHERE ";

		if ($_SESSION['type'] == 'user') {
			$query .= 'user_id = "' . $_SESSION["mr_admin"] . '" AND ';
		}

		if (isset($_POST["search"]["value"])) {
			$query .= '(order_id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$query .= 'OR invoice_no LIKE "%' . $_POST["search"]["value"] . '%" ';
			$query .= 'OR order_total LIKE "%' . $_POST["search"]["value"] . '%" ';
			$query .= 'OR order_status LIKE "%' . $_POST["search"]["value"] . '%" ';
			$query .= 'OR invoice_date LIKE "%' . $_POST["search"]["value"] . '%") ';
		}

		if (isset($_POST["order"])) {
			$query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY order_id DESC ';
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
			$payment_status = get_payment_method_name($connect, $row['payment_status']);
			$status = '';
			if ($row['order_status'] == 'active') {
				$status = '<span class="label label-success">Active</span>';
			} else {
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$company = 'Error';
			$customer_data = get_customer_data($connect, $row['customer_id']);
			if ($customer_data) {
				$company = $customer_data['company'];
			}
			$slug = 'invoice.php';
			$url = BASE_URL_PUBLIC . $slug . '?code=' . $row["code"] . '&pdfview=1';
			$sub_array = array();
			$sub_array[] ='<div class="col-md-12">
			<div class="form-group">
			<input type="checkbox" name="selected[]" value="'.$row['order_id'].'" id="check-'.$row['order_id'].'" class="form-check-input"/>
			<label for="check-'.$row['order_id'].'"> '.$row['order_id'].'</label>
			</div></div>';
			$sub_array[] = $company;
			$sub_array[] = '<p style="direction:ltr;display: flex;flex-direction: column;color: black;"><span>
			 total : ' . price_format($row['order_total']) . '  ' . $ccsympol . '</span> <span>  tax : ' . price_format($row['total_tax']) . ' ' . $ccsympol . '</span></p>';

			$sub_array[] = $payment_status;
			$sub_array[] = $status;
			$sub_array[] = $row['invoice_date'];

			$sub_array[] = '<button type="button" name="make_qr" id="' . $url . '" data-name="' . $company . '.png" class="btn btn-dark btn-xs make_qr">صنع QR </button>
			<button class="btn btn-primary m-2 MR_copy_clipboard"  data-clipboard-text="' . $url . '"><i class="far fa-copy"></i></button>';

			$sub_array[] = '<a href="order_view.php?code=' . $row["code"] . '" class="btn btn-info btn-xs m-2">تحميل PDF</a>
			<a href="order_view.php?code=' . $row["code"] . '&pdfview=1" class="btn btn-info btn-xs m-2">عرض PDF</a>';
			$sub_array[] = '<button type="button" name="update" id="' . $row["order_id"] . '" class="btn btn-warning btn-xs update">تحديث</button>';
			$sub_array[] = '<button type="button" name="delete" id="' . $row["order_id"] . '" class="btn btn-danger btn-xs delete" data-status="' . $row["order_status"] . '">تغيير الحالة</button>';
			$data[] = $sub_array;
		}

		function get_total_all_records($connect)
		{
			$statement = $connect->prepare("SELECT * FROM mr_order");
			$statement->execute();
			return $statement->rowCount();
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $filtered_rows,
			"recordsFiltered" 	=> 	get_total_all_records($connect),
			"data"    			=> 	$data
		);

		echo json_encode($output);
	}



	if ($_POST['action'] == 'get_product_price') {

		$query = "
			SELECT * FROM mr_product 
			WHERE product_id = '" . $_POST["product_id"] . "'";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = array();
		foreach ($result as $row) {

			$output['price'] = $row['product_base_price'];
		}

		echo json_encode($output);
	}



	if ($_POST['action'] == 'Get_New_Invoice_Number') {
		$output['invoice_no'] = createInvoiceNo($connect);
		echo json_encode($output);
	}
}


if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'Add') {

		$code = md5(microtime() . rand());
		$invoice_no =	$_POST['invoice_no'];
		$invoice_prfex = $invoice_prfex;
		
		$password = '';
		$quotation_id ='';
		if(isset($_POST["quotation_id"]) && $_POST["quotation_id"] !== ''){
			$quotation_id = $_POST["quotation_id"];
		}

		$query = "INSERT INTO mr_order 
		(user_id, order_total, invoice_date,invoice_no,invoice_prfex, customer_id,quotation_id, payment_status,shipping_cost,first_payment, discount_total,order_status,code, date_added) 
		VALUES
		(:user_id, :order_total, :order_date,:invoice_no,:invoice_prfex, :customer_id,:quotation_id, :payment_status,:shipping_cost,:first_payment, :discount_total,:order_status,:code, :date_added)";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':user_id'						=>	$_SESSION["mr_admin"],
				':order_total'		=>	0,
				':order_date'			=>	$_POST['order_date'],
				':invoice_no'		=>	$invoice_no,
				':invoice_prfex'			=>	$invoice_prfex,
				':customer_id'			=>	$_POST['customer_id'],
				':quotation_id'			=>	$quotation_id,
				':payment_status'				=>	$_POST['payment_status'],
				':shipping_cost'			=>	$_POST['shipping_cost'],
				':first_payment'			=>	$_POST['first_payment'],
				':discount_total'			=>	$_POST['discount_total'],
				':order_status'		=>	'active',
				':code'		=>	$code,
				':date_added'	=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		$statement = $connect->query("SELECT LAST_INSERT_ID()");
		$order_id = $statement->fetchColumn();

		if (isset($order_id)) {
			$total_amount = 0;
			$total_tax = 0;
			for ($count = 0; $count < count($_POST["product_id"]); $count++) {
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
						INSERT INTO mr_order_product (order_id, product_id, quantity, price, tax) VALUES (:order_id, :product_id, :quantity, :price, :tax)
						";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':order_id'	=>	$order_id,
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>	$_POST["price"][$count],
						':tax'					=>	$product_details['tax']
					)
				);


				$base_price = 	$_POST["price"][$count];
				$tax = ($base_price / 100) * $product_details['tax'];

				$total_amount = $total_amount + $base_price;
				$total_tax = $total_tax + $tax;
			}


			$qr_code = '';


			$update_query = "
					UPDATE mr_order 
					SET order_total = '" . $total_amount . "' , total_tax ='" . $total_tax . "'
					WHERE order_id = '" . $order_id . "'
					";
			$statement = $connect->prepare($update_query);
			$statement->execute();
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'تم انشاء الفاتورة';
				echo '<br />';
				echo $total_amount;
				echo '<br />';
				echo $order_id;
			}
		}
	}








	if ($_POST['btn_action'] == 'fetch_single') {
		$query = "
		SELECT * FROM mr_order WHERE order_id = :order_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':order_id'	=>	$_POST["order_id"]
			)
		);
		$result = $statement->fetchAll();
		$output = array();
		foreach ($result as $row) {
			
			$output['quotation_id'] = $row['quotation_id'];
			$output['customer_id'] = $row['customer_id'];
			$output['invoice_date'] = $row['invoice_date'];
			$output['payment_status'] = $row['payment_status'];
			$output['shipping_cost'] = $row['shipping_cost'];
			$output['first_payment'] = $row['first_payment'];
			$output['discount_total'] = $row['discount_total'];
			$output['invoice_no'] = $row['invoice_no'];
		}
		$sub_query = "
		SELECT * FROM mr_order_product 
		WHERE order_id = '" . $_POST["order_id"] . "'
		";
		$statement = $connect->prepare($sub_query);
		$statement->execute();
		$sub_result = $statement->fetchAll();
		$product_details = '';
		$count = 0;
		foreach ($sub_result as $sub_row) {
			$count = $count + 1;
			$product_details .= '
			<script>
			$(document).ready(function(){
				$("#product_id' . $count . '").selectpicker("val", ' . $sub_row["product_id"] . ');
				$(".selectpicker").selectpicker();
			});
			</script>
			<span id="row' . $count . '">
				<div class="row">
					<div class="col-md-5"><label>المنتج</label>
						<select name="product_id[]" id="product_id' . $count . '" class="form-control selectpicker" data-live-search="true" required>
							' . fill_product_list($connect) . '
						</select>
						<input type="hidden" name="hidden_product_id[]" id="hidden_product_id' . $count . '" value="' . $sub_row["product_id"] . '" />
					</div>
					
					<div class="col-md-3"><label>السعر</label>
					<input type="text" name="price[]" id="product_price' . $count . '" class="form-control" required value="' . $sub_row["price"] . '" /></div>
					
					<div class="col-md-3"><label>الكمية</label>
						<input type="text" name="quantity[]" class="form-control" value="' . $sub_row["quantity"] . '" required />
					</div>
					<div class="col-md-1">
			';

			if ($count == 1) {
				$product_details .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			} else {
				$product_details .= '<button type="button" name="remove" id="' . $count . '" class="btn btn-danger btn-xs remove">-</button>';
			}
			$product_details .= '
						</div>
					</div>
				</div><br />
			</span>
			';
		}
		$output['product_details'] = $product_details;
		echo json_encode($output);
	}



	if ($_POST['btn_action'] == 'Edit') {
		$delete_query = "
				DELETE FROM mr_order_product 
				WHERE order_id = '" . $_POST["order_id"] . "'
				";
		$statement = $connect->prepare($delete_query);
		$statement->execute();
		$delete_result = $statement->fetchAll();
		if (isset($delete_result)) {
			$total_amount = 0;
			for ($count = 0; $count < count($_POST["product_id"]); $count++) {
				$product_details = fetch_product_details($_POST["product_id"][$count], $connect);
				$sub_query = "
						INSERT INTO mr_order_product (order_id, product_id, quantity, price, tax) VALUES (:order_id, :product_id, :quantity, :price, :tax)
						";
				$statement = $connect->prepare($sub_query);
				$statement->execute(
					array(
						':order_id'	=>	$_POST["order_id"],
						':product_id'			=>	$_POST["product_id"][$count],
						':quantity'				=>	$_POST["quantity"][$count],
						':price'				=>		$_POST["price"][$count],
						':tax'					=>	$product_details['tax']
					)
				);
				$base_price = 	$_POST["price"][$count] * $_POST["quantity"][$count];
				$tax = ($base_price / 100) * $product_details['tax'];
				$total_amount = $total_amount + ($base_price + $tax);
			}
			$quotation_id ='';
            if(isset($_POST["quotation_id"]) && $_POST["quotation_id"] !== ''){
                $quotation_id = $_POST["quotation_id"];
            }
			$update_query = "
					UPDATE mr_order 
					SET customer_id = :customer_id, 
					quotation_id =:quotation_id,
					invoice_date = :invoice_date, 		
					order_total = :order_total, 
					payment_status = :payment_status, 
					shipping_cost = :shipping_cost, 		
					first_payment = :first_payment, 
					discount_total = :discount_total,
					invoice_no=:invoice_no
					WHERE order_id = :order_id
					";
			$statement = $connect->prepare($update_query);
			$statement->execute(
				array(
					':customer_id'			=>	$_POST["customer_id"],
					':quotation_id'			=>	$quotation_id,
					':invoice_no'			=>	$_POST["invoice_no"],
					':invoice_date'			=>	$_POST["order_date"],
					':shipping_cost'			=>	$_POST['shipping_cost'],
					':first_payment'			=>	$_POST['first_payment'],
					':discount_total'			=>	$_POST['discount_total'],
					':order_total'		=>	$total_amount,
					':payment_status'				=>	$_POST["payment_status"],
					':order_id'			=>	$_POST["order_id"]
				)
			);
			$result = $statement->fetchAll();
			if (isset($result)) {
				echo 'تم تعديل الفاتورة';
			}
		}
	}

	if ($_POST['btn_action'] == 'delete') {
		$status = 'active';
		if ($_POST['status'] == 'active') {
			$status = 'inactive';
		}
		$query = "UPDATE mr_order 
		SET order_status = :order_status 
		WHERE order_id = :order_id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':order_status'	=>	$status,
				':order_id'		=>	$_POST["order_id"]
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'تم تغيير حالة الفاتورة الى ' . $status;
		}
	}
}

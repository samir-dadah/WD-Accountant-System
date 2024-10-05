<?php


include('config.php');
session_start();


if(isset($_POST['btn_action']))
{
	

	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO mr_product ( product_name, product_qty, product_unit, product_base_price, product_tax, product_enter_by, product_status, product_date) 
		VALUES (:product_name, :product_quantity, :product_unit, :product_base_price, :product_tax, :product_enter_by, :product_status, :product_date)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				
				':product_name'			=>	$_POST['product_name'],				
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_unit'			=>	$_POST['product_unit'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_tax'			=>	$_POST['product_tax'],
				':product_enter_by'		=>	$_SESSION["mr_admin"],
				':product_status'		=>	'active',
				':product_date'			=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'تم اضافة المنتج';
		}
	}
	if($_POST['btn_action'] == 'product_details')
	{
		$query = "
		SELECT * FROM mr_product 
		
		INNER JOIN mr_admin ON mr_admin.admin_id = mr_product.product_enter_by 
		WHERE mr_product.product_id = '".$_POST["product_id"]."'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['product_status'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>اسم المنتج</td>
				<td>'.$row["product_name"].'</td>
			</tr>
			
			<tr>
				<td>الكمية المتاحة</td>
				<td>'.$row["product_qty"].' '.$row["product_unit"].'</td>
			</tr>
			<tr>
				<td>السعر</td>
				<td>'.$row["product_base_price"].'</td>
			</tr>
			<tr>
				<td>Tax (%)</td>
				<td>'.$row["product_tax"].'</td>
			</tr>
			<tr>
				<td>تم اضافته من قبل</td>
				<td>'.$row["user_name"].'</td>
			</tr>
			<tr>
				<td>حالة المنتج</td>
				<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM mr_product WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_id'	=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			
			$output['product_name'] = $row['product_name'];			
			$output['product_quantity'] = $row['product_qty'];
			$output['product_unit'] = $row['product_unit'];
			$output['product_base_price'] = $row['product_base_price'];
			$output['product_tax'] = $row['product_tax'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE mr_product 
		set 
		product_name = :product_name,
		 
		product_qty = :product_quantity, 
		product_unit = :product_unit, 
		product_base_price = :product_base_price, 
		product_tax = :product_tax 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				
				':product_name'			=>	$_POST['product_name'],
				':product_quantity'		=>	$_POST['product_quantity'],
				':product_unit'			=>	$_POST['product_unit'],
				':product_base_price'	=>	$_POST['product_base_price'],
				':product_tax'			=>	$_POST['product_tax'],
				':product_id'			=>	$_POST['product_id']
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'تم تعديل المنتج';
		}
	}
	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE mr_product 
		SET product_status = :product_status 
		WHERE product_id = :product_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':product_status'	=>	$status,
				':product_id'		=>	$_POST["product_id"]
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo 'تم تغيير حالة لمنتج الى  ' . $status;
		}
	}
}


?>
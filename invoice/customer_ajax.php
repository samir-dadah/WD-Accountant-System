<?php
session_start();
include('config.php');
if(isset($_POST["action"]))
{

if($_POST['action'] == 'fetch_customer')
{


$query = " SELECT * FROM mr_customer ";


if(isset($_POST["search"]["value"]))
		{
			$query .= 'WHERE company LIKE "%'.$_POST["search"]["value"].'%"
		               OR city LIKE "%'.$_POST["search"]["value"].'%"
			           OR address_1 LIKE "%'.$_POST["search"]["value"].'%"';
		}
		


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY customer_id DESC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	
	$sub_array = array();
	$sub_array[] = $row['customer_id'];
	$sub_array[] = $row['company'];
	$sub_array[] = $row['address_1'];
	$sub_array[] = $row['city'];
	$sub_array[] = '<button type="button" name="update" id="'.$row["customer_id"].'" class="btn btn-warning btn-xs update">تعديل</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["customer_id"].'" class="btn btn-danger btn-xs delete" >حذف</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	get_total_records($connect, 'mr_customer'),
	"data"    			=> 	$data
);


echo json_encode($output);


}	




}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		
		$data =array(
				':firstname'		=>	$_POST["firstname"],
				':surename'		=>	$_POST["surename"],
				':company'		=>	$_POST["company"],
				':email'		=>	$_POST["email"],
				':address_1'		=>	$_POST["address_1"],
				':city'		=>	$_POST["city"],
				':postcode'		=>	$_POST["postcode"],
				':tax_number'		=>	$_POST["tax_number"],
				':customer_no'		=>	$_POST["customer_no"]
			);
		
		$query = "
		INSERT INTO mr_customer (firstname, surename, company, email, address_1,city,postcode,tax_number,customer_no) 
		VALUES (:firstname, :surename, :company, :email, :address_1,:city,:postcode,:tax_number,:customer_no)
		";	
		$statement = $connect->prepare($query);
		
           if($statement->execute($data)){
			$output = array(
				'success'	=>	'تم اضافة الزبون بنجاح'
			);
				}
			echo json_encode($output);
		}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM mr_customer WHERE customer_id = :customer_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':customer_id'	=>	$_POST["customer_id"]
			)
		);
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['customer_id'] = $row['customer_id'];
			$output['firstname'] = $row['firstname'];
			$output['surename'] = $row['surename'];
			$output['company'] = $row['company'];
			$output['email'] = $row['email'];
			$output['address_1'] = $row['address_1'];
			$output['city'] = $row['city'];
			$output['postcode'] = $row['postcode'];
			$output['tax_number'] = $row['tax_number'];
			$output['customer_no'] = $row['customer_no'];
			
		}
		echo json_encode($output);
	}
	
	
	
	
	if($_POST['btn_action'] == 'Edit')
	{
		
			$query = "
			UPDATE mr_customer SET 
				firstname = '".$_POST["firstname"]."', 
				surename = '".$_POST["surename"]."'
				, 
				company = '".$_POST["company"]."'
				, 
				email = '".$_POST["email"]."'
				, 
				address_1 = '".$_POST["address_1"]."'
				, 
				city = '".$_POST["city"]."'
				, 
				postcode = '".$_POST["postcode"]."'
				, 
				tax_number = '".$_POST["tax_number"]."'
				, 
				customer_no = '".$_POST["customer_no"]."'
				WHERE customer_id = '".$_POST["customer_id"]."'
			";
		
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		if(isset($result))
		{
			$output = array(
				'success'	=>	'تم التعديل بنجاح'
			);
		}
		echo json_encode($output);
		
	}
	
	
	
	
	
	if($_POST['btn_action'] == 'delete')
	{
		
		$query = "
		DELETE FROM mr_customer 
		
		WHERE customer_id = :customer_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				
				':customer_id'		=>	$_POST["customer_id"]
			)
		);	
		$result = $statement->fetchAll();	
		if(isset($result))
		{
			echo 'تم الحذف بنجاح';
		}
	}


}

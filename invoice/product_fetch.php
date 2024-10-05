<?php


include('config.php');
session_start();
$query = '';

$output = array();
$query .= "
	SELECT * FROM mr_product 

";

if(isset($_POST["search"]["value"]))
{
	
	$query .= 'WHERE mr_product.product_name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR mr_product.product_qty LIKE "%'.$_POST["search"]["value"].'%" ';

	$query .= 'OR mr_product.product_id LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['order']))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY product_id DESC ';
}

if($_POST['length'] != -1)
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
	$status = '';
	if($row['product_status'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['product_id'];
	$sub_array[] = $row['product_name'];
	$sub_array[] = available_product_quantity($connect, $row["product_id"]) . ' ' . $row["product_unit"];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["product_id"].'" class="btn btn-info btn-xs view">عرض</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["product_id"].'" class="btn btn-warning btn-xs update">تحديث</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["product_id"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["product_status"].'">تغيير حالة المنتج</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect)
{
	$statement = $connect->prepare('SELECT * FROM mr_product');
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

?>
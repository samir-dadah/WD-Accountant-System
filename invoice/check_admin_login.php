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

include("config.php");
session_start();
 if(!isset($_POST['admin_user_name'])) {
	die('ERR');
}
sleep(2);

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'login')
	{

$admin_user_name = '';
$admin_password = '';
$error_admin_user_name = '';
$error_admin_password = '';
$error = 0;

if(empty($_POST["admin_user_name"]))
{
	$error_admin_user_name = 'يجب كتابة اسم المستخدم';
	$error++;
}
else
{
	$admin_user_name = $_POST["admin_user_name"];
}

if(empty($_POST["admin_password"]))
{
	$error_admin_password = 'يجب كتابة كلمة المرور';
	$error++;
}
else
{
	$admin_password = $_POST["admin_password"];
}

if($error == 0)
{
	$query = "
	SELECT * FROM mr_admin 
	WHERE admin_mail = '".$admin_user_name."'
	";

	$statement = $connect->prepare($query);

	if($statement->execute())
	{
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if(password_verify($admin_password, $row["admin_password"]))
				{
					$_SESSION["mr_admin"] = $row["admin_id"];
					$_SESSION['type'] = $row['user_role'];
					$_SESSION['user_name'] = $row['user_name'];
				}
				else
				{
					$error_admin_password = "كلمة المرور خاطئة";
					$error++;
				}
			}
		}
		else
		{
			$error_admin_user_name = 'البريد الالكتروني غير صحيح';
			$error++;
		}
	}
}

if($error > 0)
{
	$output = array(
		'error'					=>	true,
		'error_admin_user_name'	=>	$error_admin_user_name,
		'error_admin_password'	=>	$error_admin_password
	);
}
else
{
	$output = array(
		'success'		=>	true
	);	
}

echo json_encode($output);
	}








	
}
?>
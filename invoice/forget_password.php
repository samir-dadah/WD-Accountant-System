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

include('config.php');

$message = '';

session_start();

if(isset($_SESSION["mr_admin"]))
{
	header("location:index.php");
}

if(isset($_POST["submit"]))
{
	if(empty($_POST["user_admin_mail"]))
	{
		$message = '<div class="alert alert-danger">يجب كتابة البريد الالكتروني </div>';
	}
	else
	{
		$data = array(
			':user_admin_mail'	=>	trim($_POST["user_admin_mail"])
		);

		$query = "
		SELECT * FROM mr_admin 
		WHERE admin_mail = :user_admin_mail
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			$result = $statement->fetchAll();

			foreach($result as $row)
			{
				 
					$admin_otp = rand(100000, 999999);

					$sub_query = "
					UPDATE mr_admin 
					SET admin_otp = '".$admin_otp."' 
					WHERE admin_id = '".$row["admin_id"]."'
					";

					$connect->query($sub_query);

					require_once('class/class.phpmailer.php');

$subject='طلب نسيان كلمة مرور الادارة ';
				$body = '
					<p>لاستعادة كلمة المرور ادخل هذا الرمز عندما يطلب منك: <b>'.$admin_otp.'</b>.</p>
					<p>مع اطيب التحيات</p>
					';
	
send_admin_mail($row["admin_mail"],$outgoing_admin_mail,$sitetitle, $subject, $body);


echo '<script>alert("يرجى تفقد بريدك الالكتروني لاستعادة كلمة المرور")</script>';

						echo '<script>window.location.replace("forget_admin_password.php?step2=1&code=' . $row["admin_activation_code"] . '")</script>';
					

				
				
			}
		}
		else
		{
			$message = '<div class="alert alert-danger">البريد الالكتروني غير مسجل من قبل</div>';
		}
	}
}

if(isset($_POST["check_otp"]))
{
	if(empty($_POST["admin_otp"]))
	{
		$message = '<div class="alert alert-danger">ادخل رمز التحقق</div>';
	}
	else
	{
		$data = array(
			':admin_activation_code'		=>	$_POST["user_code"],
			':admin_otp'					=>	$_POST["admin_otp"]
		);

		$query = "
		SELECT * FROM mr_admin 
		WHERE admin_activation_code = :admin_activation_code 
		AND admin_otp = :admin_otp
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			echo '<script>window.location.replace("forget_admin_password.php?step3=1&code=' . $_POST["user_code"] . '")</script>';
		}
		else
		{
			$message = '<div class="alert alert-danger">رمز التحقق خاطئ</div>';
		}
	}
}

if(isset($_POST["change_admin_password"]))
{
	$new_admin_password = $_POST["user_admin_password"];
	$confirm_admin_password = $_POST["confirm_admin_password"];

	if($new_admin_password == $confirm_admin_password)
	{
		$query = "
		UPDATE mr_admin 
		SET admin_password = '".password_hash($new_admin_password, PASSWORD_DEFAULT)."' 
		WHERE admin_activation_code = '".$_POST["user_code"]."'
		";

		$connect->query($query);

		echo '<script>window.location.replace("login.php?reset_admin_password=success")</script>';
	}
	else
	{
		$message = '<div class="alert alert-danger">كلمة المرور غير متطابقتان</div>';
	}
}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		
		
		  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>استعادة كلمة المرور</title>
  
  	<!-- Favicon -->

<!--===============================================================================================-->	
	
<link rel="stylesheet" href="<?php echo $base_url;?>css/all.css">
<link href="<?php echo $base_url;?>assest/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base_url;?>assest/css/admincp_rtl.css">
<script src="<?php echo $base_url;?>assest/js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>assest/js/popper.min.js"></script>
<script src="<?php echo $base_url;?>assest/js/bootstrap.min.js"></script>

	</head>
	<body>
		<br />
		<div class="container">
			<h3 align="center">استعادة كلمة المرور</h3>
			<br />
			
		
  <div class="row justify-content-center">
   
    <div class="col-md-8 " style="margin-top:20px;">
      <div class="card">
		  <div class="card-body">	
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">اجراءات استعادة كلمة المرور</h3>
				</div>
				<div class="panel-body">
					<?php

					echo $message;

					if(isset($_GET["step1"]))
					{
					?>
					<form method="post">
						<div class="form-group">
							<label>البريد الالكتروني</label>
							<input type="text" name="user_admin_mail" class="form-control" />
						</div>
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-success" value="ارسال" />
						</div>
					</form>
					<?php
					}
					if(isset($_GET["step2"], $_GET["code"]))
					{
					?>
					<form method="POST">
						<div class="form-group">
							<label>اكتب رمز التحقق</label>
							<input type="text" name="admin_otp" class="form-control" />
						</div>
						<div class="form-group">
							<input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>" />
							<input type="submit" name="check_otp" class="btn btn-success" value="ارسال" />
						</div>
					</form>
					<?php
					}

					if(isset($_GET["step3"], $_GET["code"]))
					{
					?>
					<form method="post">
						<div class="form-group">
							<label>اكتب كلمة المرور الجديدة</label>
							<input type="admin_password" name="user_admin_password" class="form-control" />
						</div>
						<div class="form-group">
							<label>اعد كتابة كلمة المرور</label>
							<input type="admin_password" name="confirm_admin_password" class="form-control" />
						</div>
						<div class="form-group">
							<input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>" />
							<input type="submit" name="change_admin_password" class="btn btn-success" value="تغيير" />
						</div>
					</form>
					<?php	
					}
					?>
				</div>
			</div>
	
</div>
	</div>
		 </div>
   
 </div>
  </div>
		
		
		
		
		
		<br />
		<br />
	</body>
</html>
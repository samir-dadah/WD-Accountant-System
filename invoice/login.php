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
ob_start();
session_start();

if(isset($_SESSION["mr_admin"]))
{
  header('location:index.php');
}



// if(!($_GET['mr_oauth']=="fc70b8685d8cc7f3c91hd99bd1fc85917")) {
// die('ERR YOU DONT HAVE ACCESSS TO THIS PAGE ');
//}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>تسجيل دخول الادارة</title>
  
  	<!-- Favicon -->

<!--===============================================================================================-->	
	
<link rel="stylesheet" href="<?php echo $base_url;?>assets/css/all.css">
<link href="<?php echo $base_url;?>assets/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo $base_url;?>assets/js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>assets/js/popper.min.js"></script>
<script src="<?php echo $base_url;?>assets/js/bootstrap.min.js"></script>









</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-4">

    </div>
    <div class="col-md-4" style="margin-top:20px;">
      <div class="card">
	  
        <div class="card-header">تسجيل دخول الادمن</div>
        <div class="card-body">
		
		<?php 
		if(isset($_GET["reset_password"]))
			{
				if($_GET["reset_password"] == 'success')
				{
					echo '<span class="text-success">تم تغيير كلمة المرور بنجاح .يمكنك الان تسجيل الدخول</span>';
				}
			}
			?>
          <form method="post" id="admin_login_form">
            <div class="form-group">
              <label>البريد الالكتروني</label>
              <input type="text" name="admin_user_name" id="admin_user_name" class="form-control" />
              <span id="error_admin_user_name" class="text-danger"></span>
            </div>
            <div class="form-group">
              <label>كلمة المرور</label>
              <input type="password" name="admin_password" id="admin_password" class="form-control" />
              <span id="error_admin_password" class="text-danger"></span>
            </div>
            <div class="form-group">
			<input type="hidden" name="action" id="action" value="login" />
              <input type="submit" name="admin_login" id="admin_login" class="btn btn-info" value="دخول" />
            </div>
				<div align="center">
						<b><a href="forget_password.php?step1=1">نسيت كلمة المرور ؟</a></b>
					</div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">

    </div>
  </div>
</div>

</body>
</html>

<script>
$(document).ready(function(){
	    $('form').attr('autocomplete', 'chrome-off');
     $('form').attr('autocomplete', 'off');
  $('#admin_login_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"check_admin_login.php",
      method:"POST",
      data:$(this).serialize(),
      dataType:"json",
      beforeSend:function(){
        $('#admin_login').val('جاري التحقق');
        $('#admin_login').attr('disabled', 'disabled');
      },
      success:function(data)
      {
        if(data.success)
        {
          location.href = "<?php echo $base_url; ?>index.php";
        }
        if(data.error)
        {
          $('#admin_login').val('دخول');
          $('#admin_login').attr('disabled', false);
          if(data.error_admin_user_name != '')
          {
            $('#error_admin_user_name').text(data.error_admin_user_name);
          }
          else
          {
            $('#error_admin_user_name').text('');
          }
          if(data.error_admin_password != '')
          {
            $('#error_admin_password').text(data.error_admin_password);
          }
          else
          {
            $('#error_admin_password').text('');
          }
        }
      }
    });
  });
});
</script>
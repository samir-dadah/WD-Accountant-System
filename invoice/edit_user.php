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
 require_once('header.php'); 
 
$error_message='';
$success_message='';
 
 
 if(isset($_POST['form1'])) {
 
        $statement = $connect->prepare("UPDATE mr_admin SET  user_name=?,admin_mail=? WHERE admin_id=?");
		$statement->execute(array($_POST['user_name'],$_POST['admin_mail'],$_REQUEST['id']));

    	$success_message = 'تم تعديل الملف الشخصي بنجاح.';

 
 
 
 
 
 
 }
 if(isset($_POST['form3'])) {
	  $statement = $connect->prepare("UPDATE mr_admin SET  admin_password=? WHERE admin_id=?");
		$statement->execute(array(password_hash($_POST['admin_password'], PASSWORD_DEFAULT),$_REQUEST['id']));

    	$success_message = 'تم تحديث كلمة المرور بنجاح.';
	 
 }
 	if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $connect->prepare("SELECT * FROM mr_admin WHERE admin_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0) {
		header('location: logout.php');
		exit;
	}
}	
foreach ($result as $row) {
	
	$user_name = $row['user_name'];
	$admin_mail     = $row['admin_mail'];

}	

 ?>
 
 
 
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الادارة تعديل حساب ادارة</h1>
           
          </div>
		  	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="alert alert-danger" role="alert">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="alert alert-success" role="alert">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="container">
          <div class="row justify-content-center">
		    <div class="col-md-8">
		  
		  
	<form class="form-horizontal" id="admin_form" method="post" enctype="multipart/form-data">
<div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">تعديل حساب </h1>
           
          </div>

		    <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">اسم المستخدم  <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $user_name; ?>" required />
          
              </div>
            </div>
          </div>
 		    <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">البريد الالكتروني  <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="admin_mail" id="admin_mail" class="form-control" value="<?php echo $admin_mail; ?>" required data-parsley-type="admin_mail" data-parsley-trigger="keyup" />
          
              </div>
            </div>
          </div>
          
		            
		  
		  		  	            <div class="form-group">
            <div class="row">
             
              <div class="col-md-8">
                 <button type="submit" class="btn btn-success pull-left" name="form1">حفظ</button>
              </div>
            </div>
          </div>
		  
		  



</form>
</div>
</div>
</div>	
 
 

 

 
 
 
 
 
 
 
 
 <div class="container">
          <div class="row justify-content-center">
		    <div class="col-md-8">
		  
		  
	<form class="form-horizontal" id="admin_form1" method="post" enctype="multipart/form-data">
<div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">تعديل كلمة مرور </h1>
           
          </div>


 
           <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">كلمة المرور <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="admin_password" id="admin_password" class="form-control"  />
                
              </div>
            </div>
          </div>
		             <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">تأكيد  كلمة المرور <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="radmin_password" id="radmin_password" class="form-control"  />
                
              </div>
            </div>
          </div>
		  
		  		  	            <div class="form-group">
            <div class="row">
             
              <div class="col-md-8">
                 <button type="submit" class="btn btn-success pull-left" name="form3">تعديل كلمة مرور</button>
              </div>
            </div>
          </div>
		  
		  



</form>
</div>
</div>
</div>	

 
 
 
 
 
 
 
 
 
 
 
 	<?php
 require_once('footer.php'); ?>
 
<script>
  $('#admin_password').attr('required', 'required');

    $('#radmin_password').attr('required', 'required');

    $('#radmin_password').attr('data-parsley-equalto', '#admin_password');
  $('#admin_form').parsley();
  $('#admin_form1').parsley();
 
 </script>
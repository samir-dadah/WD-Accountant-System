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
 
 
$admin_activation_code = md5(rand());
 
   $statement = $connect->prepare("INSERT INTO mr_admin (user_name,admin_mail,admin_password,admin_activation_code) VALUES (?,?,?,?)");
		$statement->execute(array($_POST['user_name'],$_POST['admin_mail'],password_hash($_POST['admin_password'], PASSWORD_DEFAULT),$admin_activation_code));
			
		$success_message = 'تم اضافة مستخدم جديد بنجاح';
 
 }
 
  if(isset($_REQUEST['delete_id'])) {
	

	// Delete from mr_social
	$statement = $connect->prepare("DELETE FROM mr_admin WHERE admin_id=?");
	$statement->execute(array($_REQUEST['delete_id']));
	
	$success_message = 'تم الحذف بنجاح';
	 header('Refresh:4;url=user.php');
	
	
	
}
 ?>
 
 
 
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الادارة</h1>
           
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
            <h1 class="h3 mb-0 text-gray-800">اضافة جديد </h1>
           
          </div>

		    <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">اسم المستخدم  <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="user_name" id="user_name" class="form-control" required />
          
              </div>
            </div>
          </div>
 		    <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">البريد الالكتروني  <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="admin_mail" id="admin_mail" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
          
              </div>
            </div>
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
                 <button type="submit" class="btn btn-success pull-left" name="form1">حفظ</button>
              </div>
            </div>
          </div>
		  
		  



</form>
</div>
</div>
</div>	
 
 
  <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">جميع المستخدمين الادارة</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                       <th>تسلسل</th>
			        <th>الاسم</th>
			        <th>البريد الالكتروني</th>
                   <th>عمل اجراء</th>
                    </tr>
                  </thead>
                 
                  <tbody>
				  <?php
                    $i=0;
                    $statement = $connect->prepare("SELECT * FROM mr_admin");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                    	$i++;
                    	?>
						<tr>
		                    <td><?php echo $i; ?></td>
		                    <td><?php echo $row['user_name']; ?></td>

		                    <td>
							
							<?php echo $row['admin_mail']; ?>

		                    </td>
							 <td>
							 <?php  
							  echo '<a href="edit_user.php?id='.$row['admin_id'].'" class="btn btn-primary btn-xs">تعديل </a> ';
		                        	if($row['admin_id'] != 1)
									{
			                        	echo '<a href="#" class="btn btn-danger btn-xs" data-href="user.php?delete_id='.$row['admin_id'].'" data-toggle="modal" data-target="#confirm-delete">حذف</a> ';	
		                        	}		                        	
		                        ?>
								 </td>
		                </tr>
                    	<?php
                    }
                ?>

            </tbody>
				   </table>
              </div>
			
            </div>
          </div>
	
	
		
 

 
 
 
 
 
 
 
 
 
 
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">تاكيد حذف</h4>
            </div>
            <div class="modal-body">
                <p>هل انت متاكد من الحذف ؟ </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                <a class="btn btn-danger btn-ok">حذف</a>
            </div>
        </div>
    </div>
</div>
 
 
 
 
 
 
 
 
 
 
 
 	<?php
 require_once('footer.php'); ?>
 
 <script>

 $('#admin_form').parsley();
  $('#admin_password').attr('required', 'required');

    $('#radmin_password').attr('required', 'required');

    $('#radmin_password').attr('data-parsley-equalto', '#admin_password');

 
 </script>
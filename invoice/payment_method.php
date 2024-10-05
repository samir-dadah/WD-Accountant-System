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
 
  if (isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['name'])) {
        $valid = 0;
        $error_message .= "لا يمكن ترك الاسم  فارغ<br>";
    }
 
  if($valid == 1) {
	  
	  $statement = $connect->prepare("INSERT INTO mr_payment_method (name) VALUES (?)");
      $statement->execute(array($_POST['name']));
	  $success_message = 'تم اضافته بنجاح.';
  }
 
 
 }
 if (isset($_REQUEST['delete_name'])) {
	 
	 $statement = $connect->prepare("DELETE FROM mr_payment_method WHERE id=?");
	 $statement->execute(array($_REQUEST['delete_name']));
	 
	 $success_message = 'تم حذف بنجاح.';
	 header('Refresh:3;url=payment_method.php');
	 
 }
 
 
 
 ?>
 
 
 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">طرق الدفع</h1>
           
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary text-center">اضافة جديد</h6>
            </div>
            <div class="card-body">
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
			 <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
						<div class="row">
							<label for="" class="col-sm-2 control-label">طرق دفع  جديد <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="name" >
							</div>
						</div>
						</div>
			<div class="form-group">
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">اضافة جديد</button>
							</div>
						</div>
			</form>
			</div>
			</div>

 <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">جميع طرق الدفع</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                       <th>تسلسل</th>
			        <th>الوسيلة</th>
			        <th>عمل اجراء</th>
                  
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    <th>تسلسل</th>
			        <th>الوسيلة</th>
			        <th>عمل اجراء</th>
                 
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php
                    $i=0;
                    $statement = $connect->prepare("SELECT * FROM mr_payment_method");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                    foreach ($result as $row) {
                    	$i++;
                    	?>
						<tr>
		                    <td><?php echo $i; ?></td>
		                    <td><?php echo $row['name']; ?></td>

		                    <td>
							
							<a href="#" class="btn btn-danger btn-xs" data-href="payment_method.php?delete_name=<?php echo $row['id'];?>" data-toggle="modal" data-target="#confirm-delete">حذف</a> 

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













</div>


 
  <?php
 require_once('footer.php'); ?>


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
 
  if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['social_link'])) {
        $valid = 0;
        $error_message .= "لا يمكن ترك الرابط فارغ<br>";
    } 
 if(empty($_POST['social_icon'])) {
        $valid = 0;
        $error_message .= "لا يمكن ترك الايقونة فارغة<br>";
    }
    if($valid == 1) {

		// Saving data into the main table mr_social
		$statement = $connect->prepare("INSERT INTO mr_social (social_link,social_icon,social_type) VALUES (?,?,?)");
		$statement->execute(array($_POST['social_link'],$_POST['social_icon'],$_POST['social_type']));
	
    	$success_message = 'تم اضافة وسائل تواصل جديدة بنجاح';
    }
}
 if(isset($_REQUEST['delete_item'])) {
	

	// Delete from mr_social
	$statement = $connect->prepare("DELETE FROM mr_social WHERE social_id=?");
	$statement->execute(array($_REQUEST['delete_item']));
	
	$success_message = 'تم الحذف بنجاح';
	 header('Refresh:4;url=social.php');
	
	
	
}
 
 
 
 ?>
 
 
 <style>
 
 .no_display{
	 display:none;
 }
 
</style>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">روابط التواصل الاجتماعي</h1>
           
          </div>
		  
		  
		  		  
	  <div class="card shadow mb-4">
  
  	<form class="form-horizontal" action="" method="post" id="social_form">

				<div class="card">
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
	
	
	<div class="form-group">
							<label for="" class="col-sm-2 control-label">النوع <span>*</span></label>
							<div class="col-sm-4">
								 <select name="social_type" class="form-control" id="social_type" required >
								 <option value="">اختر نوع المحتوى</option>
					<option value="email">بريد الكتروني</option>
					<option value="tel">رقم جوال</option>
					<option value="link">رابط</option>
					<option value="text">نص</option>	
					</select>
							</div>
						</div>
	
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">المحتوى <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="social_link" id="social_link" >
							</div>
						</div>
					
				
					

	<div class="btn-group">
  <button data-selected="graduation-cap" type="button" class="icp demo btn btn-default dropdown-toggle iconpicker-component" data-toggle="dropdown">
      اختيار ايقونة  <i class="fa fa-fw"></i>
      <span class="caret"></span>
  </button>
  <div class="dropdown-menu"></div>
</div>
						<div class="form-group">
						
											
							<label for="" class="col-sm-2 control-label">الايقونة </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="social_icon" id="social_icon" >
							</div>


						</div>
					
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">اضف جديد</button>
							</div>
						</div>
					</div>
				</div>

			</form>
			
			
 
</div>	  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
  <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">وسائل التواصل الاجتماعي</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th>SL</th>
			        <th>الرابط</th>      
					<th>الايقونة</th>
			        <th>عمل اجراء</th>
                  
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                     <th>SL</th>
			         <th>الرابط</th>			    
					<th>الايقونة</th>
			        <th>عمل اجراء</th>
                 
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php
            	$i=0;
            	$statement = $connect->prepare("SELECT * FROM mr_social ORDER BY social_id ASC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?> 
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['social_link']; ?></td>
						 <td><i class="<?php echo $row['social_icon']; ?>"></i></td>
	                    <td>
						
						
						
	                         
	                        <a href="#" class="btn btn-danger btn-xs" data-href="social.php?delete_item=<?php echo $row['social_id']; ?>" data-toggle="modal" data-target="#confirm-delete">حذف</a>
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
 
 <script>  
$(document).ready(function(){  
    $('#social_form').parsley();
 $('#social_type').change(function(){
	 
	  var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
	
 
   if(valueSelected =="link")
   {
 $('#social_link').attr('data-parsley-type', 'url');
 $('#social_link').attr('data-parsley-trigger', 'keyup');
  $('#social_link').attr('placeholder', 'ex : http://twitter.com');
   }

     if(valueSelected =="email")
   {
  
 $('#social_link').attr('data-parsley-type', 'email');
 $('#social_link').attr('data-parsley-trigger', 'keyup');
  $('#social_link').attr('placeholder', 'ex : test@yourdomain.com');
  
   }
 
if(valueSelected =="tel")
   {
	    $('#social_link').attr('data-parsley-type', 'number');
 $('#social_link').attr('data-parsley-length', '[6, 20]');
 $('#social_link').attr('data-parsley-pattern', '^[0-9]+$');
  $('#social_link').attr('placeholder', 'ex : 00000000000');
   $('#social_link').attr('data-parsley-trigger', 'keyup');
  
   }

  if(valueSelected =="text")
   {
 
  $('#social_link').attr('data-parsley-type', false);
 $('#social_link').attr('data-parsley-trigger', 'keyup');
  $('#social_link').attr('placeholder', 'ex : test address');
   }
 
 });

 });  
</script>
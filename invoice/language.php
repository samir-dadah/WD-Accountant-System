  <?php
 require_once('header.php'); 




$error_message='';
$success_message='';
 
 
 
 if(isset($_POST['form1'])) {
	 
	 $count_item=  count($_POST['phrase']);
	 $count_item= count($_POST['phrase_id']);
	 
	 
	for($count = 0; $count <$count_item ; $count++) {
		
		$phrase=$_POST['phrase'][$count] ;
		$phrase_id=$_POST['phrase_id'][$count];
		
	 $statement = $connect->prepare(" UPDATE mr_language SET phrase='".$phrase."' WHERE phrase_id='".$phrase_id."' ");
		$statement->execute();

        $success_message = 'language update successfull ' ; 
	}
 }








  







?>

 <!-- Begin Page Content -->
        <div class="container-fluid">





 
 
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">update language</h1>
           
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
          <div class="row">
		  <div class="col-md-12">  
  <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
  <?php  $statement = $connect->prepare("SELECT * FROM mr_language ORDER BY phrase_id ASC ");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{  ?>
           <div class="form-group">
            <div class="row">
              <label class="col-md-4 text-right">  <span class="text-success"> <?php echo $row['phrase_key'] ;?></span>|<?php echo $row['phrase'] ;?> <span class="text-danger">*</span></label>
              <div class="col-md-8">
                <input type="text" name="phrase[]" id="phrase" value="<?php echo $row['phrase'] ;?>" class="form-control" required />
          
              </div>
            </div>
          </div>
 
           <div class="form-group">
            <div class="row">
         
              <div class="col-md-8">
                <input type="hidden" name="phrase_id[]" id="phrase_id" value="<?php echo $row['phrase_id'] ;?>" class="form-control" />
                
              </div>
            </div>
          </div>
<?php }?>
		  
		   <div class="form-group">
            <div class="row align-items-center justify-content-center">
             
              <div class="col-md-2">
                 <button type="submit" class="btn btn-success pull-left" name="form1"> save</button>
              </div>
            </div>
          </div>
		 </form>
 
   </div>
    </div>
 
 </div>
 
 
 
  <?php
 require_once('footer.php'); ?>




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
 require_once('header.php'); ?>
 
 
 

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">لوحة التحكم الرئيسية</h1>
           
          </div>

          <!-- Content Row -->
          <div class="row">
 
   <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">عدد الادارة</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_total_records($connect, 'mr_admin') ;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

  <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">اجمالي المنتجات</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_total_records($connect, 'mr_product') ;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">عدد الطلبات</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_total_records($connect, 'mr_order') ;?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-ad fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			
			
	

 </div> 
 	


</div>


 
  <?php
 require_once('footer.php'); ?>
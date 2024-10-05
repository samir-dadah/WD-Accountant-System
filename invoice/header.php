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
ob_start();
session_start();
include("config.php");


if(!isset($_SESSION["mr_admin"]))
{
 	header('location: login.php');
 		exit;
}



$error_message='';
$success_message = '';




?>









<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Panel</title>
  
  	<!-- Favicon -->

<!--===============================================================================================-->	
<link rel="stylesheet" href="<?php echo $base_url;?>assets/css/all.css">
  <link href="<?php echo $base_url;?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo $base_url;?>assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">
   <link href="<?php echo $base_url;?>assets/css/fontawesome-iconpicker.min.css" rel="stylesheet">
	  <link rel="stylesheet" href="<?php echo $base_url;?>assets/css/summernote.css">
	    <link rel="stylesheet" href="<?php echo $base_url;?>assets/bootstrap-select/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="<?php echo $base_url;?>assets/css/adminp.css">
	  <link rel="stylesheet" href="<?php echo $base_url;?>assets/css/admincp_rtl.css">
	   <link rel="stylesheet" href="<?php echo $base_url;?>assets/css/datepicker.css">
	<style>
.modal-header .close {
    padding: 1rem 1rem;
    margin: -1rem auto -1rem -1rem;
}

	.delete_close{
    padding: 1rem 1rem;
    margin: -1rem auto -1rem -1rem;
}
.bootstrap-select .dropdown-toggle .filter-option-inner-inner {
   
    display: inline-block !important;
    overflow: hidden !important;
    width: 100% !important;
    text-align: right !important;
}
 input.parsley-success,
 select.parsley-success,
 textarea.parsley-success {
   color: #468847;
   background-color: #DFF0D8;
   border: 1px solid #D6E9C6;
 }

 input.parsley-error,
 select.parsley-error,
 textarea.parsley-error {
   color: #B94A48;
   background-color: #F2DEDE;
   border: 1px solid #EED3D7;
 }

 .parsley-errors-list {
   margin: 2px 0 3px;
   padding: 0;
   list-style-type: none;
   font-size: 0.9em;
   line-height: 0.9em;
   opacity: 0;

   transition: all .3s ease-in;
   -o-transition: all .3s ease-in;
   -moz-transition: all .3s ease-in;
   -webkit-transition: all .3s ease-in;
 }

 .parsley-errors-list.filled {
   opacity: 1;
 }
 
 .parsley-type, .parsley-required, .parsley-equalto{
  color:#ff0000;
 }
  
 
  .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }


 
 
 </style>

</head>











<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

   
    

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>لوحة التحكم</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        
      </div>

  <li class="nav-item ">
        <a class="nav-link collapsed" href="product.php">
          <i class="fas fa-fw fa-link"></i>
          <span>المنتجات</span>
        </a>
      </li>
        <li class="nav-item ">
        <a class="nav-link collapsed" href="quotation.php">
          <i class="fas fa-fw fa-file-contract"></i>
          <span>عرض سعر</span>
        </a>
      </li>    
      <li class="nav-item ">
        <a class="nav-link collapsed" href="contract.php">
          <i class="fas fa-fw fa-file-contract"></i>
          <span>العقود</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link collapsed" href="order.php">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>الطلبات</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link collapsed" href="delivery.php">
          <i class="fas fa-fw fa-file-contract"></i>
          <span>وصول استلام</span>
        </a>
      </li>
	        <li class="nav-item ">
        <a class="nav-link collapsed" href="social.php">
          <i class="fas fa-fw fa-link"></i>
          <span>اعدادات وسائل التواصل الاجتماعي</span>
        </a>
      </li>

	  <li class="nav-item ">
        <a class="nav-link collapsed" href="customer.php">
          <i class="fas fa-fw fa-users"></i>
          <span>الزبائن</span>
        </a>
      </li>
	  
	  <li class="nav-item ">
        <a class="nav-link collapsed" href="payment_method.php">
          <i class="fas fa-fw fa-bars"></i>
          <span>طرق الدفع</span>
        </a>

      </li>
	  	  <li class="nav-item ">
        <a class="nav-link collapsed" href="product_unit.php">
          <i class="fas fa-fw fa-bars"></i>
          <span> الواحدات</span>
        </a>

      </li>
	  

	  <li class="nav-item ">
        <a class="nav-link collapsed" href="user.php">
          <i class="fas fa-fw fa-user"></i>
          <span>الادارة</span>
        </a>

      </li>
	  
	  

	  <li class="nav-item ">
        <a class="nav-link collapsed" href="language.php">
          <i class="fas fa-fw fa-globe"></i>
          <span>اعدادات اللغة</span>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link collapsed" href="settings.php">
          <i class="fas fa-fw fa-cog"></i>
          <span>الاعدادات</span>
        </a>
      </li>




      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
	
	
	 <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

        

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

      


            <div class="topbar-divider d-sm-block"></div>
            

              <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 e d-lg-inline text-gray-600 small">تسجيل خروج</span>
               
              </a>
            
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      
               
                <a class="dropdown-item" href="logout.php" >
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                 تسجيل خروج
                </a>
              </div>
            </li>
          </ul>

        </nav>
        <!-- End of Topbar -->
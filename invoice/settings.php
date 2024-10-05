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



  $path = $_FILES['favicon']['name'];
  $path_tmp = $_FILES['favicon']['tmp_name'];

  if ($path !== '') {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $file_name = basename($path, '.' . $ext);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
      $valid = 0;
      $error_message .= 'يمكن تحميل فقط jpg, jpeg, gif  png <br>';
    }
  }

  if ($path !== '') {
    $valid = 1;

    $statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $favicon = $row['favicon'];
      unlink('images/' . $favicon);
    }


    $final_name = 'favicon' . '.' . $ext;
    move_uploaded_file($path_tmp, 'images/' . $final_name);


    $statement = $connect->prepare(" UPDATE mr_settings SET    company_name='" . $_POST['company_name'] . "',company_address='" . $_POST['company_address'] . "',company_city='" . $_POST['company_city'] . "',company_postcode='" . $_POST['company_postcode'] . "',company_email='" . $_POST['company_email'] . "',company_number='" . $_POST['company_number'] . "',conditions_page_link='" . $_POST['conditions_page_link'] . "',conditions_page_title='" . $_POST['conditions_page_title'] . "',outgoing_admin_mail='" . $_POST['outgoing_admin_mail'] . "',ccsympol='" . $_POST['ccsympol'] . "',logo_link='" . $_POST['logo_link'] . "',address='" . $_POST['address'] . "',title='" . $_POST['title'] . "',invoice_no='" . $_POST['invoice_no'] . "',invoice_prfex='" . $_POST['invoice_prfex'] . "',tax_system='" . $_POST['tax_system'] . "',tax_rate='" . $_POST['tax_rate'] . "',invoice_bottom_content='" . $_POST['invoice_bottom_content'] . "',favicon='" . $final_name . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم التحديث بنجاح';
  } else {
    $valid = 1;
    $statement = $connect->prepare(" UPDATE mr_settings SET    company_name='" . $_POST['company_name'] . "',company_address='" . $_POST['company_address'] . "',company_city='" . $_POST['company_city'] . "',company_postcode='" . $_POST['company_postcode'] . "',company_email='" . $_POST['company_email'] . "',company_number='" . $_POST['company_number'] . "',conditions_page_link='" . $_POST['conditions_page_link'] . "',conditions_page_title='" . $_POST['conditions_page_title'] . "',outgoing_admin_mail='" . $_POST['outgoing_admin_mail'] . "',ccsympol='" . $_POST['ccsympol'] . "',logo_link='" . $_POST['logo_link'] . "',address='" . $_POST['address'] . "',title='" . $_POST['title'] . "',invoice_no='" . $_POST['invoice_no'] . "',invoice_prfex='" . $_POST['invoice_prfex'] . "',tax_system='" . $_POST['tax_system'] . "',tax_rate='" . $_POST['tax_rate'] . "',invoice_bottom_content='" . $_POST['invoice_bottom_content'] . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم التحديث بنجاح';
  }
}



if (isset($_POST['formbarcode'])) {

  $valid = 1;



  $path = $_FILES['qr_logo']['name'];
  $path_tmp = $_FILES['qr_logo']['tmp_name'];

  if ($path !== '') {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $file_name = basename($path, '.' . $ext);
    if ($ext != 'png') {
      $valid = 0;
      $error_message .= 'يمكن تحميل فقط  png <br>';
    }
  }

  if ($path !== '') {
    $valid = 1;

    $statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $qr_logo = $row['qr_logo'];
      unlink('images/' . $qr_logo);
    }


    $final_name = 'qr_logo' . '.' . $ext;
    move_uploaded_file($path_tmp, 'images/' . $final_name);


    $statement = $connect->prepare(" UPDATE mr_settings SET   qr_color='" . $_POST['qr_color'] . "',qr_background='" . $_POST['qr_background'] . "',qr_size='" . $_POST['qr_size'] . "',qr_logo='" . $_POST['qr_logo'] . "',qr_logo_size='" . $_POST['qr_logo_size'] . "',qr_logo='" . $final_name . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم تحديث اعدادات الشعار بنجاح';
  } else {
    $valid = 1;
    $statement = $connect->prepare(" UPDATE mr_settings SET   qr_color='" . $_POST['qr_color'] . "',qr_background='" . $_POST['qr_background'] . "',qr_size='" . $_POST['qr_size'] . "',qr_logo_size='" . $_POST['qr_logo_size'] . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم تحديث اعدادات الشعار بنجاح';
  }
}

if (isset($_POST['form2'])) {

  $valid = 1;



  $path = $_FILES['logo']['name'];
  $path_tmp = $_FILES['logo']['tmp_name'];

  if ($path !== '') {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $file_name = basename($path, '.' . $ext);
    if ($ext != 'png') {
      $valid = 0;
      $error_message .= 'يمكن فقط تحميل  png <br>';
    }
  }


  if ($path !== '') {
    $valid = 1;

    $statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $logo = $row['logo'];
      unlink('images/' . $logo);
    }


    $final_name = 'logo' . '.' . $ext;
    move_uploaded_file($path_tmp, 'images/' . $final_name);

    $statement = $connect->prepare(" UPDATE mr_settings SET logo='" . $final_name . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم التحديث بنجاح';
  }
}



if (isset($_POST['form3'])) {

  $valid = 1;



  $path = $_FILES['invoice_background']['name'];
  $path_tmp = $_FILES['invoice_background']['tmp_name'];

  if ($path !== '') {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $file_name = basename($path, '.' . $ext);
    if ($ext != 'png') {
      $valid = 0;
      $error_message .= 'يمكن فقط تحميل  png <br>';
    }
  }


  if ($path !== '') {
    $valid = 1;

    $statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $invoice_background = $row['invoice_background'];
      unlink('images/' . $invoice_background);
    }


    $final_name = 'background' . '.' . $ext;
    move_uploaded_file($path_tmp, 'images/' . $final_name);

    $statement = $connect->prepare(" UPDATE mr_settings SET invoice_background='" . $final_name . "' WHERE id=1");
    $statement->execute();

    $success_message = 'تم التحديث بنجاح';
  }
}










$statement = $connect->prepare("SELECT * FROM mr_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $logo = $row['logo'];
  $favicon = $row['favicon'];
  $qr_background = $row['qr_background'];
  $qr_size = $row['qr_size'];
  $address = $row['address'];
  $qr_color = $row['qr_color'];
  $qr_logo = $row['qr_logo'];
  $qr_logo_size = $row['qr_logo_size'];
  $invoice_bottom_content = $row['invoice_bottom_content'];
  $tax_system = $row['tax_system'];
  $invoice_prfex = $row['invoice_prfex'];
  $invoice_no = $row['invoice_no'];
  $title = $row['title'];
  $tax_rate = $row['tax_rate'];
  $invoice_background = $row['invoice_background'];
  $logo_link = $row['logo_link'];
  $ccsympol = $row['ccsympol'];
  $outgoing_admin_mail = $row['outgoing_admin_mail'];
  $company_name = $row['company_name'];
  $company_address = $row['company_address'];
  $company_city = $row['company_city'];
  $company_postcode = $row['company_postcode'];
  $company_email = $row['company_email'];
  $company_number = $row['company_number'];
  $conditions_page_link = $row['conditions_page_link'];
  $conditions_page_title = $row['conditions_page_title'];
}






?>




<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">الاعدادات</h1>

  </div>
  <div class="row">
    <div class="col-md-12">
      <?php if ($error_message) : ?>
        <div class="alert alert-danger" role="alert">

          <p>
            <?php echo $error_message; ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if ($success_message) : ?>
        <div class="alert alert-success" role="alert">

          <p><?php echo $success_message; ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <form class="form-horizontal" id="setting_form" method="post" enctype="multipart/form-data">








        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">التفاصيل اسفل الفاتورة <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <textarea name="invoice_bottom_content" id="invoice_bottom_content" class="form-control"><?php echo $invoice_bottom_content; ?></textarea>

            </div>
          </div>
        </div>



        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">العنوان اسفل الشعار في الفاتورة<span class="text-danger">*</span></label>
            <div class="col-md-8">
              <textarea name="title" id="title" class="form-control"><?php echo $title; ?></textarea>

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">العنوان<span class="text-danger">*</span></label>
            <div class="col-md-8">
              <textarea name="address" id="address" class="form-control"><?php echo $address; ?></textarea>

            </div>
          </div>
        </div>


        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">حساب الضرائب </label>
            <div class="col-md-8">
              <select name="tax_system" class="form-control" id="tax_system">
                <option value="product" <?php if ($tax_system == 'product') {
                                          echo 'selected';
                                        } ?>>على المنتج </option>


              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">نسبة الضريبة <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="hidden" name="tax_rate" id="tax_rate" class="form-control" value="<?php echo $tax_rate; ?>">

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">رابط الموقع الالكتروني للشعار <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="text" name="logo_link" id="logo_link" class="form-control" value="<?php echo $logo_link; ?>">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">شعار العملة <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="text" name="ccsympol" id="ccsympol" class="form-control" value="<?php echo $ccsympol; ?>">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">البريد الصادر <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="text" name="outgoing_admin_mail" id="outgoing_admin_mail" class="form-control" value="<?php echo $outgoing_admin_mail; ?>">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">رقم بداية اول فاتورة </label>
            <div class="col-md-8">
              <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="<?php echo $invoice_no; ?>">

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">تسلسل احرف للفاتورة INV_ </label>
            <div class="col-md-8">
              <input type="text" name="invoice_prfex" id="invoice_prfex" class="form-control" value="<?php echo $invoice_prfex; ?>">


            </div>
          </div>
        </div>



        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> صورة مصغرة favicon<span class="text-danger">*</span></label>
            <div class="col-md-8" style="padding-top:20px;">
              <img src="images/<?php echo $favicon; ?>" class="existing-photo" style="height:60px;">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">تحميل جديدة<span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="file" name="favicon" id="favicon" class="form-control" accept="image/*" />

            </div>
          </div>
        </div>



        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> اسم الشركة </label>
            <div class="col-md-8">
              <input type="text" name="company_name" id="company_name" class="form-control" value="<?php echo $company_name; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> العنوان</label>
            <div class="col-md-8">
              <input type="text" name="company_address" id="company_address" class="form-control" value="<?php echo $company_address; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> المدينة</label>
            <div class="col-md-8">
              <input type="text" name="company_city" id="company_city" class="form-control" value="<?php echo $company_city; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> الرمز البريدي</label>
            <div class="col-md-8">
              <input type="text" name="company_postcode" id="company_postcode" class="form-control" value="<?php echo $company_postcode; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> البريد الالكتروني</label>
            <div class="col-md-8">
              <input type="text" name="company_email" id="company_email" class="form-control" value="<?php echo $company_email; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> رقم الجوال</label>
            <div class="col-md-8">
              <input type="text" name="company_number" id="company_number" class="form-control" value="<?php echo $company_number; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> رابط صفحة الشروط والاحكام</label>
            <div class="col-md-8">
              <input type="text" name="conditions_page_link" id="conditions_page_link" class="form-control" value="<?php echo $conditions_page_link; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> اسم صفحة الشروط والاحكام</label>
            <div class="col-md-8">
              <input type="text" name="conditions_page_title" id="conditions_page_title" class="form-control" value="<?php echo $conditions_page_title; ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">

            <div class="col-md-8 text-left">
              <button type="submit" class="btn btn-success pull-left" name="form1">حفظ</button>
            </div>
          </div>
        </div>










      </form>


    </div>


  </div>




  <div class="container">
    <div class="row">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> اللوجو السابق<span class="text-danger">*</span></label>
            <div class="col-md-8" style="padding-top:20px;">
              <img src="images/<?php echo $logo; ?>" class="existing-photo" style="height:60px;">

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> تحميل جديد <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="file" name="logo" id="logo" class="form-control" required accept="image/*" />

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">

            <div class="col-md-8 text-left">
              <button type="submit" class="btn btn-success pull-right" name="form2">حفظ</button>
            </div>
          </div>
        </div>










      </form>



    </div>


  </div>




  <div class="container">
    <div class="row">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> خلفية الفاتورة <span class="text-danger">*</span></label>
            <div class="col-md-8" style="padding-top:20px;">
              <img src="images/<?php echo $invoice_background; ?>" class="existing-photo" style="height:500px;">

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> تحميل جديد <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="file" name="invoice_background" id="invoice_background" class="form-control" required accept="image/*" />

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">

            <div class="col-md-8 text-left">
              <button type="submit" class="btn btn-success pull-right" name="form3">حفظ</button>
            </div>
          </div>
        </div>










      </form>



    </div>


  </div>

  <div class="container mt-4">

    <div class="row">
      <div class="align-items-center justify-content-center mb-4 mt-4">
        <h1 class="h3 text-gray-800">اعدادات الباركود</h1>

      </div>
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">اللون <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="color" name="qr_color" id="qr_color" value="<?php echo $qr_color; ?>" class="form-control" />

            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> قياس الشعار في الوسط <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <span id="qr_logo_size_text"><?php echo $qr_logo_size; ?>%</span>
              <input type="range" name="qr_logo_size" id="qr_logo_size" class="form-control" value="<?php echo $qr_logo_size; ?>" min="0" max="25" step="1">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">لون خلفية الباركود <span class="text-danger">*</span></label>
            <div class="col-md-8">
              <input type="color" name="qr_background" id="qr_background" value="<?php echo $qr_background; ?>" class="form-control" />

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right"> الشعار السابق <span class="text-danger">*</span></label>
            <div class="col-md-8" style="padding-top:20px;">
              <img src="images/<?php echo $qr_logo; ?>" class="existing-photo" style="height:60px;">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">الشعار مخصص* <span class="text-danger">*</span></label>


            <div class="col-md-8">
              <input type="file" name="qr_logo" id="qr_logo" class="form-control" />

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <label class="col-md-4 text-right">قياس الباركود 200 / 400 / 600 /800<span class="text-danger">*</span></label>
            <div class="col-md-8">
              <span id="qr_size_text"><?php echo $qr_size; ?></span>
              <input id="qr_size" type="range" name="qr_size" value="<?php echo $qr_size; ?>" min="100" max="1000" step="50" class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row">

            <div class="col-md-8 text-left">
              <button type="submit" class="btn btn-success pull-right" name="formbarcode">حفظ</button>
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
  $('#setting_form').parsley();




  $('#tax_system').change(function() {

    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;


    if (valueSelected == "fixed") {
      $('#tax_rate').attr('data-parsley-type', 'number');
      $('#tax_rate').attr('data-parsley-trigger', 'keyup');
      $('#tax_rate').attr('required', 'required');




    } else {

      $('#tax_rate').attr('required', false);

    }



  });
  $('#qr_size').change(function() {

    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $('#qr_size_text').text(valueSelected);
  });
  $('#qr_logo_size').change(function() {

    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $('#qr_logo_size_text').text(valueSelected + '%');
  });
</script>
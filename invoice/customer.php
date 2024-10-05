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


?>




<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">الزبائن</h1>

	</div>
















	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">حسابات الزبائن</h6>
		</div>
		<div class="card-body">
			<span id="alert_action"></span>
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
								<h3 class="card-title">قائمة الزبائن</h3>
							</div>
							<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
								<button type="button" name="add" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success btn-xs">اضافة</button>
							</div>
						</div>

						<div class="clear:both"></div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 table-responsive">
								<table id="user_data" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>ID</th>
											<th>اسم الشركة</th>
											<th>العنوان </th>
											<th>المدينة </th>
											<th>تعديل</th>
											<th>حذف</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="userModal" class="modal fade">
				<div class="modal-dialog  modal-lg">
					<form method="post" id="user_form">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><i class="fa fa-plus"></i> اضافة زبون جديد</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label>الاسم الاول</label>
									<input type="text" name="firstname" id="firstname" class="form-control" />
								</div>
								<div class="form-group">
									<label>الاسم الاخير</label>
									<input type="text" name="surename" id="surename" class="form-control" />
								</div>
								<div class="form-group">
									<label>اسم الشركة<span>*</span></label>
									<input type="text" name="company" id="company" class="form-control" required />
								</div>
								<div class="form-group">
									<label>البريد الاكتروني<span>*</span></label>
									<input type="text" name="email" id="email" class="form-control" required />
								</div>
								<div class="form-group">
									<label> العنوان<span>*</span></label>
									<input type="text" name="address_1" id="address_1" class="form-control" required />
								</div>
								<div class="form-group">
									<label>المدينة<span>*</span></label>
									<input type="text" name="city" id="city" class="form-control" required />
								</div>
								<div class="form-group">
									<label>الكود البريدي<span>*</span></label>
									<input type="text" name="postcode" id="postcode" class="form-control" required />
								</div>
								<div class="form-group">
									<label>الرقم الضريبي</label>
									<input type="text" name="tax_number" id="tax_number" class="form-control" />
								</div>
								<div class="form-group">
									<label>الرقم التسلسلي</label>
									<input type="text" name="customer_no" pattern="[+-]?([0-9]*[.])?[0-9]+" id="customer_no" class="form-control" value="<?php echo createCustomerNo($connect); ?>" />
								</div>

							</div>
							<div class="modal-footer">
								<input type="hidden" name="customer_id" id="customer_id" />
								<input type="hidden" name="btn_action" id="btn_action" />
								<input type="submit" name="action" id="action" class="btn btn-info" value="اضافة" />
								<button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
							</div>
						</div>
					</form>

				</div>
			</div>


		</div>











	</div>



	<?php
	require_once('footer.php'); ?>

	<script>
		$(document).ready(function() {

			$('#add_button').click(function() {
				$('#user_form')[0].reset();
				$('.modal-title').html("<i class='fa fa-plus'></i> اضافة زبون جديد");
				$('#action').val("اضافة");
				$('#btn_action').val("Add");
			});

			var userdataTable = $('#user_data').DataTable({
				"processing": true,
				"serverSide": true,
				"order": [],
				"ajax": {
					url: "customer_ajax.php",
					type: "POST",
					data: {
						action: 'fetch_customer'
					}
				},
				"columnDefs": [{
					"targets": [4, 5],
					"orderable": false,
				}, ],
			});

			$(document).on('submit', '#user_form', function(event) {
				event.preventDefault();

				$.ajax({
					url: "customer_ajax.php",
					method: "POST",
					data: new FormData(this),
					dataType: "json",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						$('#action').attr('disabled', 'disabled');
						$('#action').val('جاري التحقق');
					},

					success: function(data) {
						console.log(data);
						if (data.success) {
							$('#user_form')[0].reset();
							$('#userModal').modal('hide');
							$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.success + '</div>');
							$('#action').attr('disabled', false);
							userdataTable.ajax.reload();
						}
					}
				})
			});

			$(document).on('click', '.update', function() {
				var customer_id = $(this).attr("id");
				var btn_action = 'fetch_single';
				$.ajax({
					url: "customer_ajax.php",
					method: "POST",
					data: {
						customer_id: customer_id,
						btn_action: btn_action
					},
					dataType: "json",
					success: function(data) {
						$('#userModal').modal('show');
						$('#firstname').val(data.firstname);
						$('#surename').val(data.surename);
						$('#company').val(data.company);
						$('#email').val(data.email);
						$('#address_1').val(data.address_1);
						$('#city').val(data.city);
						$('#postcode').val(data.postcode);
						$('#tax_number').val(data.tax_number);
						$('#customer_no').val(data.customer_no);

						$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit User");
						$('#customer_id').val(customer_id);
						$('#action').val('تعديل');
						$('#btn_action').val('Edit');

					}
				})
			});

			$(document).on('click', '.delete', function() {
				var customer_id = $(this).attr("id");
				var btn_action = "delete";
				if (confirm("Are you sure you want to delete ?")) {
					$.ajax({
						url: "customer_ajax.php",
						method: "POST",
						data: {
							customer_id: customer_id,
							btn_action: btn_action
						},
						success: function(data) {
							$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
							userdataTable.ajax.reload();
						}
					})
				} else {
					return false;
				}
			});

		});
	</script>
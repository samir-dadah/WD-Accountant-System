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

<style>
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

	.parsley-type,
	.parsley-required,
	.parsley-equalto,
	.parsley-checkewebsite,
	.parsley-imagemindimensions {
		color: #ff0000;
	}

	.header-right .parsley-type,
	.header-right .parsley-required {
		background: white;
		height: 20px;
	}
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">الطلبات و الفواتير</h1>
	</div>


	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">جميع الطلبات</h6>
		</div>
		<div class="card-body">

			<span id="alert_action"></span>
			<div class="row">
				<div class="col-lg-12">

					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
									<h3 class="panel-title">قائمة الطلبات والفواتير</h3>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
									<button type="button" name="add" id="add_button" class="btn btn-success btn-xs">اضافة جديد</button>
									
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div class="col-sm-12 table-responsive">
								<table id="order_data" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Order ID</th>
											<th>اسم الشركة</th>
											<th>الاجمالي</th>
											<th>حالة الدفع</th>
											<th>حالة الطلب</th>
											<th>تاريخ الفاتورة</th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="orderModal" class="modal fade">

				<div class="modal-dialog modal-lg">
					<form method="post" id="order_form">
						<div class="modal-content">
							<div class="modal-header">

								<h4 class="modal-title"><i class="fa fa-plus"></i> انشاء فاتورة / طلب جديد</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<div class="row">

									<div class="col-md-12">
										<div class="form-group"><label>عرض السعر</label>
											<select name="quotation_id" id="quotation_id" class="form-control selectpicker" data-live-search="true" data-parsley-errors-container="#error-container-1" title="اختر" >
											<option value="">اختر</option>
											<?php echo fill_quotation_list($connect); ?>
											</select>
											<div id="error-container-1"></div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group"><label>الزبون</label>
											<select name="customer_id" id="customer_id" class="form-control selectpicker" data-live-search="true" data-parsley-errors-container="#error-container" title="اختر" required>
											<option value="">اختر</option>
												<?php echo fill_customer_list($connect); ?>
											</select>
											<div id="error-container"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>تاريخ الفاتورة المستحق</label>
											<input type="text" name="order_date" id="order_date" class="form-control" required />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>اضف المنتجات الى الفاتورة</label>
											<hr />
											<span id="span_product_details"></span>

										</div>
									</div>
								</div>
								<hr />
								<div class="form-group">
									<label>اختر طريقة الدفع</label>
									<select name="payment_status" id="payment_status" class="form-control" required>
										<?php echo fill_payment_method_list($connect); ?>


										< </select>
								</div>

								<div class="form-group">
									<label>تكلفة الشحن اضافي</label>
									<input type="text" name="shipping_cost" id="shipping_cost" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
								</div>
								<div class="form-group">
									<label>دفعة مقدمة</label>
									<input type="text" name="first_payment" id="first_payment" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
								</div>
								<div class="form-group">
									<label>سعر تخفيض على الاجمالي بعد اضافة الضريبة</label>
									<input type="text" name="discount_total" id="discount_total" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
								</div>

								<div class="form-group">
									<label>رقم الفاتورة</label>
									<input type="text" name="invoice_no" id="invoice_no" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
								</div>


							</div>
							<div class="modal-footer">
								<input type="hidden" name="order_id" id="order_id" />
								<input type="hidden" name="btn_action" id="btn_action" />
								<input type="submit" name="action" id="action" class="btn btn-info" value="اضافة" />
							</div>
						</div>
					</form>
				</div>

			</div>


		</div>
	</div>



	<div id="qrmodal" class="modal fade">

		<div class="modal-dialog modal-lg">
			<div id="qr-code-wrapper"></div>
		</div>
	</div>
</div>
<input type="hidden" class="color-input" name="qr_fg_color" value=" <?php echo $qr_color; ?>">
<input type="hidden" class="color-input" name="qr_bg_color" value="<?php echo $qr_background; ?>">
<input id="qr-padding" name="qr_padding" type="hidden" value="1">
<input id="qr-mode" name="qr_mode" value="4" type="hidden">
<input id="qr-text" class="with-border" name="qr_text" type="hidden" value="">
<input type="hidden" class="color-input" name="qr_text_color" value="">
<img id="img-buffer" src="<?php echo $base_url . 'images/' . $qr_logo; ?>" class="d-none">
<input class="range-slider-single" name="qr_mode_size" id="qr-mode-size" type="hidden" value="<?php echo $qr_logo_size; ?>">
<input class="range-slider-single" name="qr_position_x" id="qr-position-x" type="hidden" value="50">
<input class="range-slider-single" name="qr_position_y" id="qr-position-y" type="hidden" value="50">


<?php
require_once('footer.php'); ?>

<script>
	$(document).ready(function() {

		var $qr_wrapper = $('#qr-code-wrapper'),

			$fb_color_input = $('.color-input'),
			$bg_color_input = $('.qr-bg-color-wrapper .color-input'),
			$padding_input = $('#qr-padding'),
			$radius_input = $('#qr-radius'),
			$qr_mode = $('#qr-mode'),
			$qr_label = $('#qr-text'),
			$qr_label_color_input = $('.qr-text-color-wrapper .color-input'),
			$qr_image = $('#qr-image'),
			$qr_mode_size = $('#qr-mode-size'),
			$qr_position_x = $('#qr-position-x'),
			$qr_position_y = $('#qr-position-y'),
			$qr_mode_customization = $('#qr-mode-customization'),
			$qr_mode_label = $('#qr-mode-label'),
			$qr_mode_image = $('#qr-mode-image');


		$(document).on('click', '.make_qr', function() {
			var url_qr = $(this).attr("id");
			var name = $(this).data("name");
			createQRCode(url_qr);
			downloadQR(name);

		});

		var img_buffer = window.document.getElementById('img-buffer');

		/*
 function createQRCode(url_qr) {
        $qr_wrapper.empty().qrcode({
            text: url_qr,
            fill: $fb_color_input.val(),
            background: $bg_color_input.val(),
            quiet: parseInt($padding_input.val(), 10),
            radius: .01 * parseInt($radius_input.val(), 10),
            mode: parseInt($qr_mode.val(), 10),
            label: $qr_label.val(),
            fontcolor: $qr_label_color_input.val(),
            image: $("#img-buffer")[0],
            mSize: .01 * parseInt($qr_mode_size.val(), 10),
            mPosX: .01 * parseInt($qr_position_x.val(), 10),
            mPosY: .01 * parseInt($qr_position_y.val(), 10),
            render: 'image',
            fontname: 'Nunito',
            size: <?php echo $qr_size; ?>,
            ecLevel: 'H',
            minVersion: 3,
        });
    }
    */

		function createQRCode(url_qr) {
			$qr_wrapper.empty().kjua({
				render: 'image',
				crisp: 'true',
				ecLevel: 'H',
				minVersion: parseInt(5, 10),
				fill: '<?php echo $qr_color; ?>',
				back: '<?php echo $qr_background; ?>',
				text: url_qr,
				<?php if ($qr_size !== "") { ?>
					size: parseInt(<?php echo $qr_size; ?>, 10),
				<?php } ?>
				rounded: parseInt(100, 10),
				quiet: parseInt(4, 10),
				mode: 'image',
				mSize: parseInt(<?php echo $qr_logo_size; ?>, 10),
				mPosX: parseInt(50, 10),
				mPosY: parseInt(50, 10),
				<?php if ($qr_logo !== "") { ?>
					image: img_buffer
				<?php } ?>
			});

		}

		function downloadQR(name) {
			var imgsrc = $qr_wrapper.find('img').attr('src');
			var image = new Image();
			image.src = imgsrc;
			image.onload = function() {
				var canvas = document.createElement('canvas');
				canvas.width = image.width;
				canvas.height = image.height;
				var canvasCtx = canvas.getContext('2d');
				canvasCtx.drawImage(image, 0, 0);
				var imgData = canvas.toDataURL('image/png');

				var a = document.createElement("a");
				a.download = name;
				a.href = imgData;
				a.click();
			};
		}

		function invoice_number(){
			$.ajax({
				url: "order_ajax.php",
				method: "POST",
				data: {action: 'Get_New_Invoice_Number'},
				dataType: "json",
				success: function(data) { 
					$('#invoice_no').val(data.invoice_no);
				}
			});
		}

		$('#order_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});


		var orderdataTable = $('#order_data').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "order_ajax.php",
				type: "POST",
				data: {
					action: 'fetchorder'
				}
			},

			"pageLength": 10
		});


		var count = 1;

		$('#add_button').click(function() {
			$('#orderModal').modal('show');
			$('#order_form')[0].reset();
			$('#order_form').parsley().reset();
			$('#customer_id').attr('required', 'required');
			$('.modal-title').html("<i class='fa fa-plus'></i> عمل فاتورة جديدة");
			$('#action').val('اضافة');
			$('#btn_action').val('Add');
			$('#span_product_details').html('');
			add_product_row(count);
			invoice_number();
			$('#customer_id').selectpicker("val", '');
			$('#quotation_id').selectpicker("val", '');
			$('#customer_id').removeClass('js_error');
		});

		function add_product_row(count = '') {
			var html = '';
			html += '<span id="row' + count + '"><div class="row">';
			html += '<div class="col-md-5"><label>المنتج</label>';
			html += '<select name="product_id[]" id="product_id' + count + '" class="form-control selectpicker product_item" data-count="' + count + '" data-live-search="true" title="اختر" required>';
			html += '<?php echo fill_product_list($connect); ?>';
			html += '</select><input type="hidden" name="hidden_product_id[]" id="hidden_product_id' + count + '" />';
			html += '</div>';

			html += '<div class="col-md-3"><label>السعر</label>';
			html += '<input type="text" name="price[]" id="product_price' + count + '" class="form-control" required />';
			html += '</div>';

			html += '<div class="col-md-3"><label>الكمية</label>';
			html += '<input type="text" name="quantity[]" class="form-control" required />';
			html += '</div>';
			html += '<div class="col-md-1"><label></label>';
			if (count == 1) {
				html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			} else {
				html += '<button type="button" name="remove" id="' + count + '" class="btn btn-danger btn-xs remove">-</button>';
			}
			html += '</div>';
			html += '</div></div><br /></span>';



			$('#span_product_details').append(html);
			$('.selectpicker').selectpicker();



			$('#product_id' + count + '').on("change", function() {
				var product_id = this.value;

				//console.log(product_id);
				$.ajax({
					url: "order_ajax.php",
					method: "POST",
					data: {
						action: "get_product_price",
						product_id: product_id
					},
					dataType: "json",

					success: function(data) {
						//console.log(data);
						$('#product_price' + count + '').val(data.price);

					}
				})



			});


		}

		$(document).on('click', '#add_more', function() {
			count = count + 1;
			add_product_row(count);
		});
		$(document).on('click', '.remove', function() {
			var row_no = $(this).attr("id");
			$('#row' + row_no).remove();
		});

		$('.selectpicker').selectpicker();

		$('#order_form').parsley();


		$('#order_form').on('submit', function(event) {
			event.preventDefault();

			if ($('#order_form').parsley().validate()) {
				$('#action').attr('disabled', 'disabled');
				var form_data = $(this).serialize();
				$.ajax({
					url: "order_ajax.php",
					method: "POST",
					data: form_data,
					success: function(data) {
						$('#order_form')[0].reset();
						$('#order_form').parsley().reset();
						$('#orderModal').modal('hide');
						$('#alert_action').fadeIn().html('<div class="alert alert-success">' + data + '</div>');
						$('#action').attr('disabled', false);
						orderdataTable.ajax.reload();
					}
				});

			}
		});


		$(document).on('click', '.update', function() {
			var order_id = $(this).attr("id");
			var btn_action = 'fetch_single';
			//console.log(order_id);
			$.ajax({
				url: "order_ajax.php",
				method: "POST",
				data: {
					order_id: order_id,
					btn_action: btn_action
				},
				dataType: "json",
				success: function(data) { //console.log(data);
					$('#order_form').parsley().reset();
					$('#orderModal').modal('show');
					$('#customer_id').selectpicker("val", data.customer_id);
					$('#quotation_id').selectpicker("val", data.quotation_id);
					$('#order_date').val(data.invoice_date);
					$('#invoice_no').val(data.invoice_no);
					$('#shipping_cost').val(data.shipping_cost);
					$('#first_payment').val(data.first_payment);
					$('#discount_total').val(data.discount_total);
					$('#span_product_details').html(data.product_details);
					$('#payment_status').val(data.payment_status);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Order");
					$('#order_id').val(order_id);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');
				}
			})
		});

		$(document).on('click', '.delete', function() {
			var order_id = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "delete";
			if (confirm("Are you sure you want to change status?")) {
				$.ajax({
					url: "order_ajax.php",
					method: "POST",
					data: {
						order_id: order_id,
						status: status,
						btn_action: btn_action
					},
					success: function(data) {
						$('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
						orderdataTable.ajax.reload();
					}
				})
			} else {
				return false;
			}
		});

		$('#quotation_id').change(function(e) {
            var quotation_id = $(this).val();
            console.log(quotation_id);
            if (quotation_id) {

				$.ajax({
                    url: "quotation_ajax.php",
                    method: "POST",
                    data: {
                        action: 'GET_quotation_DATA',
                        quotation_id: quotation_id
                    },
                    dataType: 'json',
                    cache: false,
                    async: true,
                    success: function(data) {
						invoice_number();
						$('#order_form').parsley().reset();
                        $('#customer_id').selectpicker("val", data.customer_id);
                        $('#order_date').val(data.quotation_date);
                        $('#shipping_cost').val(data.shipping_cost);
					    $('#first_payment').val(data.first_payment);
					    $('#discount_total').val(data.discount_total);
					    $('#span_product_details').html(data.product_details);
					    $('#payment_status').val(data.payment_status);
                        count = data.count + 1;
                        
                    }

                });



			}
		});







	});
</script>
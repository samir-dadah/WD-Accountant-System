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
        <h1 class="h3 mb-0 text-gray-800"> عروض الاسعار </h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">جميع عروض الاسعار</h6>
        </div>
        <div class="card-body">
            <span id="alert_action"></span>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                    <h3 class="panel-title">قائمة عروض الاسعار</h3>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                                    <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">اضافة جديد</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 table-responsive">
                                <table id="quotation_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> ID</th>
                                            <th>اسم الشركة</th>
                                            <th>الاجمالي</th>
                                            <th> تاريخ العرض</th>
                                            <th> تاريخ الاضافة</th>
                                            <th>تاريخ التعديل</th>
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
        </div>

    </div>
</div>


<div id="quotationModal" class="modal fade">

    <div class="modal-dialog modal-lg">
        <form method="post" id="quotation_form">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><i class="fa fa-plus"></i> انشاء عرض سعر جديد</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label>الزبون</label>
                                <select name="customer_id" id="customer_id" class="form-control selectpicker" data-live-search="true" data-parsley-errors-container="#error-container" title="اختر" required>
                                    <?php echo fill_customer_list($connect); ?>
                                </select>
                                <div id="error-container"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>تاريخ العرض</label>
                                <input type="text" name="quotation_date" id="quotation_date" class="form-control" required />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>اضف المنتجات الى العرض</label>
                                <hr />
                                <span id="span_product_details"></span>

                            </div>
                        </div>
                        <hr>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>اختر طريقة الدفع</label>
                                <select name="payment_status" id="payment_status" class="form-control" required>
                                    <?php echo fill_payment_method_list($connect); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>تكلفة الشحن اضافي</label>
                                <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>دفعة مقدمة</label>
                                <input type="text" name="first_payment" id="first_payment" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>سعر تخفيض على الاجمالي بعد اضافة الضريبة</label>
                                <input type="text" name="discount_total" id="discount_total" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ملاحظات</label>
                                <textarea name="comment" id="comment" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label> كلمة المرور حماية عرض السعر</label>
                                    <input type="text" name="password" id="password" class="form-control" />
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="quotation_id" id="quotation_id" />
                    <input type="hidden" name="action" id="action" value="add_new" />
                    <input type="submit" id="btn_submit" class="btn btn-info" value="اضافة" />
                </div>
            </div>
        </form>
    </div>

</div>

<div id="qrmodal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div id="qr-code-wrapper"></div>
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

<?php require_once('footer.php'); ?>


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

$('.selectpicker').selectpicker();
$('#quotation_date').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true
});

         var dataTable = $('#quotation_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "quotation_ajax.php",
                type: "POST",
                data: {
                    action: 'Get_Quotations'
                }
            },
            "pageLength": 10,
            "columnDefs": [{
                "targets": [6, 7, 8],
                "orderable": false,
            }, ]
        });

        var count = 1;

        $('#add_button').click(function() {
            $('#quotationModal').modal('show');
            $('#quotation_form')[0].reset();
            $('#quotation_form').parsley().reset();
            $('#comment').summernote('code', '');
            $('.modal-title').html("<i class='fa fa-plus'></i> اضافة عرض سعر جديد  ");
            $('#btn_submit').val('اضافة');
            $('#action').val('add_new');
            $('#customer_id').attr('required', 'required');
            $('#span_product_details').html('');
			add_product_row(count);
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


        $('#quotation_form').parsley();
        $('#quotation_form').on('submit', function(e) {
            e.preventDefault();

            if ($('#quotation_form').parsley().validate()) {

                $.ajax({
                    url: "quotation_ajax.php",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btn_submit').val('جاري الاضافة...');
                        $('#btn_submit').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#btn_submit').attr('disabled', false);
                        $('#btn_submit').val('اضافة');
                        if (data.success) {
                            $('#quotation_form')[0].reset();
                            $('#quotation_form').parsley().reset();
                            $('#quotationModal').modal('hide');
                            $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.success_msg + '</div>');
                            dataTable.ajax.reload();
                        }
                        if (data.error) {
                            $('.error_display').hide();
                            $('#quotation_form').parsley().reset();

                            if (typeof data['error_msg'] == 'string') {
                                $('#alert_action').fadeIn().html('<div class="alert alert-danger">' + data.error_msg + '</div>');
                            }
                            if (typeof data['error_msg'] == 'object') {
                                if (data['error_msg']['warning']) {
                                    $('#alert_action').fadeIn().html('<div class="alert alert-danger">' + data.error_msg.warning + '</div>');
                                }
                                for (var key in data['error_msg']) {
                                    console.log(key);
                                    var input_field = $('#' + key);
                                    input_field.addClass('parsley-error');
                                    var err_msg = '<span class="text-danger error_display">' + data['error_msg'][key] + '</span>';
                                    $(err_msg).insertAfter(input_field);
                                }
                            }


                        }

                    }
                });
            }
        });


        $(document).on('click', '.update', function() {
            var quotation_id  = $(this).attr("id");
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
                        $('#quotationModal').modal('show');
                        $('#quotation_form')[0].reset();
                        $('#quotation_form').parsley().reset();
                        $('#comment').summernote('code', '');
                        $('.modal-title').html("<i class='fa fa-edit'></i> تعديل عرض السعر ");
                        $('#btn_submit').val('تعديل');
                        $('#action').val('edit_quotation');
                        $('#customer_id').selectpicker("val", data.customer_id);
                        $('#quotation_date').val(data.quotation_date);
                        $('#shipping_cost').val(data.shipping_cost);
					    $('#first_payment').val(data.first_payment);
					    $('#discount_total').val(data.discount_total);
					    $('#span_product_details').html(data.product_details);
					    $('#payment_status').val(data.payment_status);
                        $('#comment').summernote('code', data.comment);
                        $('#password').val(data.password);
                        $('#quotation_id').val(data.quotation_id);
                        count = data.count + 1;
                        
                    }

                });
            }
        });




    });
</script>
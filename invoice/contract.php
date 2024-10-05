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
        <h1 class="h3 mb-0 text-gray-800"> العقود</h1>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">جميع العقود</h6>
        </div>
        <div class="card-body">
            <span id="alert_action"></span>
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                                    <h3 class="panel-title">قائمة العقود </h3>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                                    <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">اضافة جديد</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 table-responsive">
                                <table id="contract_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Contract ID</th>
                                            <th>اسم الشركة</th>
                                            <th>تاريخ العقد</th>
                                            <th>تاريخ الانشاء</th>
                                            <th>تاريخ التعديل</th>
                                            <th>الموافقة</th>
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


    <div id="ContractModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <form method="post" id="contract_form">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title text-right"><i class="fa fa-plus"></i> اضافة عقد جديد</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group"><label>الزبون</label>
                                    <select name="customer_id" id="customer_id" class="form-control selectpicker" data-live-search="true" data-parsley-errors-container="#error-container" title="اختر">
                                        <option value="0">لايوجد</option>
                                        <?php echo fill_customer_list($connect); ?>
                                    </select>
                                    <div id="error-container"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group"><label>الفاتورة</label>
                                    <select name="order_id" id="order_id" class="form-control selectpicker" data-live-search="true" data-parsley-errors-container="#error-container-1" title="اختر">
                                        <option value="0">لايوجد</option>
                                        <?php echo fill_order_list($connect); ?>
                                    </select>
                                    <div id="error-container-1"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>اسم الشركة <span class="text-danger"> * </span> </label>
                                    <input type="text" name="company" id="company" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم الاول <span class="text-danger"> * </span></label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم الاخير <span class="text-danger"> * </span></label>
                                    <input type="text" name="surename" id="surename" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> رقم الجوال <span class="text-danger"> * </span></label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ الميلاد</label>
                                    <input type="text" name="birth_date" id="birth_date" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>البريد الاكتروني <span class="text-danger"> * </span></label>
                                    <input type="email" name="email" id="email" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> العنوان <span class="text-danger"> * </span></label>
                                    <input type="text" name="address_1" id="address_1" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>المدينة <span class="text-danger"> * </span></label>
                                    <input type="text" name="city" id="city" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البلد <span class="text-danger"> * </span></label>
                                    <input type="text" name="country" id="country" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الكود البريدي <span class="text-danger"> * </span></label>
                                    <input type="text" name="postcode" id="postcode" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الرقم الضريبي</label>
                                    <input type="text" name="tax_number" id="tax_number" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>مدينة الطلب <span class="text-danger"> * </span> </label>
                                    <input type="text" name="order_city" id="order_city" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>تاريخ العقد <span class="text-danger"> * </span></label>
                                    <input type="text" name="contract_date" id="contract_date" class="form-control" data-parsley-trigger="keyup" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for=""> المتفق عليه <span class="text-danger"> * </span></label>
                                    <textarea name="conditions" id="conditions" class="form-control" data-parsley-trigger="keyup" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">

                                    <input type="checkbox" name="approve" id="approve" value='1'>
                                    <label for="">
                                        <?php echo get_l('TEXT_AGREEMENT_BUTTON_I_READ_CONDITIONS'); ?> <a href="<?php echo $conditions_page_link; ?>" target="_blank"><?php echo $conditions_page_title; ?></a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> كلمة المرور حماية العقد</label>
                                    <input type="text" name="password" id="password" class="form-control" />
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="contract_id" id="contract_id" />
                        <input type="hidden" name="action" id="action" value="add_new" />
                        <input type="submit" id="btn_submit" class="btn btn-info" value="اضافة" />
                    </div>
                </div>

            </form>
        </div>
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
                <?php if ($qr_size !== ""): ?>
                    size: parseInt(<?php echo $qr_size; ?>, 10),
                <?php endif; ?>
                rounded: parseInt(100, 10),
                quiet: parseInt(4, 10),
                mode: 'image',
                mSize: parseInt(<?php echo $qr_logo_size; ?>, 10),
                mPosX: parseInt(50, 10),
                mPosY: parseInt(50, 10),
                <?php if ($qr_logo !== ""): ?>
                    image: img_buffer
                <?php endif;?>
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
        $('#contract_date,#birth_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });


        var dataTable = $('#contract_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "contract_ajax.php",
                type: "POST",
                data: {
                    action: 'Get_Contract'
                }
            },

            "pageLength": 10,
            "columnDefs": [{
                "targets": [3, 4, 5],
                "orderable": false,
            }, ]
        });

        $('#add_button').click(function() {
            $('#ContractModal').modal('show');
            $('#contract_form')[0].reset();
            $('#contract_form').parsley().reset();
            $('#conditions').summernote('code', '');
            $('#approve').attr('checked', false);
            $('.modal-title').html("<i class='fa fa-plus'></i> اضافة عقد جديد  ");
            $('#btn_submit').val('اضافة');
            $('#action').val('add_new');


        });

        $('#contract_form').parsley();
        $('#contract_form').on('submit', function(e) {
            e.preventDefault();

            if ($('#contract_form').parsley().validate()) {

                $.ajax({
                    url: "contract_ajax.php",
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
                            $('#contract_form')[0].reset();
                            $('#contract_form').parsley().reset();
                            $('#ContractModal').modal('hide');
                            $('#alert_action').fadeIn().html('<div class="alert alert-success">' + data.success_msg + '</div>');
                            dataTable.ajax.reload();
                        }
                        if (data.error) {
                            $('.error_display').hide();
                            $('#contract_form').parsley().reset();

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
            var contract_id = $(this).attr("id");
            if (contract_id) {
                $.ajax({
                    url: "contract_ajax.php",
                    method: "POST",
                    data: {
                        action: 'GET_CONTRACT_DATA',
                        contract_id: contract_id
                    },
                    dataType: 'json',
                    cache: false,
                    async: true,
                    success: function(data) {
                        $('#ContractModal').modal('show');
                        $('#contract_form')[0].reset();
                        $('#contract_form').parsley().reset();
                        $('#conditions').summernote('code', '');
                        $('#approve').attr('checked', false);
                        $('.modal-title').html("<i class='fa fa-edit'></i> تعديل العقد ");
                        $('#btn_submit').val('تعديل');
                        $('#action').val('edit_contract');
                        $('#customer_id').selectpicker("val", data.customer_id);
                        $('#order_id').selectpicker("val", data.order_id);
                        $('#company').val(data.company);
                        $('#firstname').val(data.firstname);
                        $('#surename').val(data.surename);
                        $('#birth_date').val(data.birth_date);
                        $('#email').val(data.email);
                        $('#phone_number').val(data.phone_number);
                        $('#address_1').val(data.address_1);
                        $('#city').val(data.city);
                        $('#country').val(data.country);
                        $('#postcode').val(data.postcode);
                        $('#tax_number').val(data.tax_number);
                        $('#conditions').summernote('code', data.conditions);
                        if (data.approve == 1) {
                            $('#approve').attr('checked', true);
                        }
                        $('#order_city').val(data.order_city);
                        $('#contract_date').val(data.contract_date);
                        $('#password').val(data.password);
                        $('#contract_id').val(data.contract_id);

                    }

                });

            }

        });


        $('#customer_id').change(function(e) {
            var customer_id = $(this).val();
            console.log(customer_id);
            if (customer_id) {
                $.ajax({
                    url: "contract_ajax.php",
                    method: "POST",
                    data: {
                        action: 'GET_CUSTOMER_DATA',
                        customer_id: customer_id
                    },
                    dataType: 'json',
                    cache: false,
                    async: true,
                    success: function(data) {
                        $('#firstname').val(data.firstname);
                        $('#surename').val(data.surename);
                        $('#company').val(data.company);
                        $('#email').val(data.email);
                        $('#address_1').val(data.address_1);
                        $('#city').val(data.city);
                        $('#postcode').val(data.postcode);
                        $('#tax_number').val(data.tax_number);
                    }

                });
            }


        });

    });
</script>
<?php require_once './header.php' ?>
<main>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 ">
                <div class="main-title text-center">
                    <h2><?php echo get_l('CONTRACT_TITLE'); ?></h2>
                    <p class="text-muted"><?php echo get_l('CONTRACT_SUBTITLE'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container main-form-section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form id="contract_form" class="contract_form">

                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="company" class="form-label"><?php echo get_l('TEXT_COMPANY'); ?></label>
                            <input type="text" name="company" id="company" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_COMPANY'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="firstname" class="form-label"><?php echo get_l('TEXT_FIRSTNAME'); ?></label>
                            <input type="text" name="firstname" id="firstname" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_FIRSTNAME'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="surename" class="form-label"><?php echo get_l('TEXT_LASTNAME'); ?></label>
                            <input type="text" name="surename" id="surename" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_LASTNAME'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="email" class="form-label"><?php echo get_l('TEXT_EMAIL'); ?></label>
                            <input type="email" name="email" id="email" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_EMAIL'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="phone_number" class="form-label"><?php echo get_l('TEXT_PHONE_NUMBER'); ?></label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_PHONE_NUMBER'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="birth_date" class="form-label"><?php echo get_l('BIRTH_DATE'); ?></label>
                            <input type="text" name="birth_date" id="birth_date" class="form-control" placeholder="<?php echo get_l('BIRTH_DATE'); ?>" />
                        </div>
                        <div class="col-sm-6">
                            <label for="tax_number" class="form-label"><?php echo get_l('TEXT_TAXNUMBER'); ?></label>
                            <input type="text" name="tax_number" id="tax_number" class="form-control" placeholder="<?php echo get_l('TEXT_TAXNUMBER'); ?>" />
                        </div>
                        <div class="col-sm-12">
                            <label for="address_1" class="form-label"><?php echo get_l('TEXT_ADDRESS'); ?></label>
                            <input type="text" name="address_1" id="address_1" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_ADDRESS'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="city" class="form-label"><?php echo get_l('TEXT_CITY'); ?></label>
                            <input type="text" name="city" id="city" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_CITY'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="postcode" class="form-label"><?php echo get_l('TEXT_POSTCODE'); ?></label>
                            <input type="text" name="postcode" id="postcode" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_POSTCODE'); ?>" required />
                        </div>
                        <div class="col-sm-6">
                            <label for="country" class="form-label"><?php echo get_l('TEXT_COUNTRY'); ?></label>
                            <input type="text" name="country" id="country" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_COUNTRY'); ?>" required />
                        </div>

                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6">
                            <label for="order_city" class="form-label"><?php echo get_l('TEXT_ORDER_CITY'); ?></label>
                            <input type="text" name="order_city" id="order_city" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_ORDER_CITY'); ?>" required />
                        </div>

                        <div class="col-sm-6">
                            <label for="contract_date" class="form-label"><?php echo get_l('TEXT_CONTRACT_DATE'); ?></label>
                            <input type="text" name="contract_date" id="contract_date" class="form-control" data-parsley-trigger="keyup" placeholder="<?php echo get_l('TEXT_CONTRACT_DATE'); ?>" required />
                        </div>


                        <div class="col-sm-12">
                            <label for="conditions" class="form-label"><?php echo get_l('TEXT_CONDITIONS'); ?></label>
                            <textarea name="conditions" id="conditions" class="form-control" placeholder="<?php echo get_l('TEXT_CONDITIONS'); ?>" data-parsley-trigger="keyup" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="approve" id="approve" value='1' required>
                                <label class="form-check-label" for="approve">
                                    <?php echo get_l('TEXT_AGREEMENT_BUTTON_I_READ_CONDITIONS'); ?> <a href="<?php echo get_s('conditions_page_link');?>" target="_blank" ><?php echo get_s('conditions_page_title');?></a>
                                </label>
                            </div>    
	
                        </div>

                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-10 text-center">
                            <input type="hidden" name="code" id="code" />
                            <input type="hidden" name="action" id="action" value="Submit_contract_New" />
                            <button type="submit" id="btn_submit" class="btn btn-primary btn-lg">
                                <?php echo get_l('TEXT_SAVE'); ?> <i class="fa-brands fa-telegram-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center" id="display_button"></div>
        </div>
    </div>

</main>
<?php require_once './footer.php' ?>

<script>
    $(document).ready(function() {
        $('#contract_date,#birth_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });



        $('#contract_form').parsley();
        $('#contract_form').on('submit', function(e) {
            e.preventDefault();

            if ($('#contract_form').parsley().validate()) {

                $.ajax({
                    url: "form_ajax.php",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btn_submit').html('<?php echo get_l('TEXT_LOADING'); ?> <i class="fa-solid fa-spinner fa-spin"></i>');
                        $('#btn_submit').attr('disabled', 'disabled');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#btn_submit').attr('disabled', false);
                        $('#btn_submit').html(' <?php echo get_l('TEXT_SAVE'); ?>   <i class="fa-brands fa-telegram-plane"></i>');
                        if (data.success) {
                            $('#contract_form')[0].reset();
                            $('#contract_form').parsley().reset();
                            $('.main-form-section').fadeOut(500);
                            $('body').append('<div class="alert alert-success alert-dismissible success_alert" role="alert"><h4 class="alert-heading">' + data.success_msg.title + '</h4><hr><p class="mb-0">' + data.success_msg.sub_title + '</p><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                            if (data.success_msg.link) {
                                var html = ' <p class="text-muted">' + data.success_msg.view_contract + '</p>';
                                html += '<a href="' + data.success_msg.link + '" class="btn btn-dark btn-lg" role="button" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>';
                                $('#display_button').append(html);
                            }
                        }
                        if (data.error) {
                            $('.error_display').hide();
                            $('#contract_form').parsley().reset();

                            if (typeof data['error_msg'] == 'string') {

                            }
                            if (typeof data['error_msg'] == 'object') {
                                if (data['error_msg']['warning']) {

                                }
                                for (var key in data['error_msg']) {
                                    console.log(key);
                                    var input_field = $('#' + key);
                                    if (input_field.length) {
                                        input_field.addClass('js_error');
                                        input_field.parsley().removeError('validate_error');
                                        input_field.parsley().addError('validate_error', {
                                            message: data['error_msg'][key]
                                        });
                                    }
                                }
                            }


                        }

                    }
                });
            }
        });
       
        <?php if (isset($_GET['code']) && $_GET['code'] !=='' && isset($_GET['valid']) && $_GET['valid'] =='false') { ?>

            var code = '<?php echo $_GET['code'];?>';
            $('#code').val(code);
            $('#action').val('Update_Contract');
            get_contract_data(code);

            function get_contract_data(code){
                $.ajax({
                    url: "form_ajax.php",
                    method: "POST",
                    data: {
                        action: 'GET_CONTRACT_DATA',
                        code: code
                    },
                    dataType: 'json',
                    cache: false,
                    async: true,
                    success: function(data) {

                        if(data.success){
                        $('#contract_form')[0].reset();
                        $('#contract_form').parsley().reset();
                        $('#approve').attr('checked',false);                  
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
                        $('#conditions').val(data.conditions);
                        if(data.approve == 1){
                            $('#approve').attr('checked',true);
                        }
                        $('#order_city').val(data.order_city);
                        $('#contract_date').val(data.contract_date);
                    }
                    if(data.error){
                        window.location.href =data.link; 
                    }

                    }

                });
            }


        <?php } ?>

    });
</script>
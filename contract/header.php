<?php
define('MR', true);
include_once './core/config.php'; ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, minimum-scale=1">
    <title><?php echo get_s('company_name'); ?></title>
    <link rel="stylesheet" href="<?php echo PUBLIC_BASE_URL; ?>assets/fonts/fontawesome/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css">
    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/parsley.js"></script>
    <script src="./assets/js/i18n/de.js"></script>
    <link rel="stylesheet" href="./assets/css/datepicker.css">
    <script src="./assets/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css?v=1">
    <script src="./assets/js/main.js?v=1"></script>
    <link rel="shortcut icon" href="<?php echo PUBLIC_BASE_URL; ?>assets/images/favicon.png" type="image/x-icon">
</head>
<style>
    header {
        padding: 20px;
        background: #eee;
        border-bottom: 1px solid #ddd;
    }

    .logo img {
        width: 250px;
    }

    footer {
        background: black;
        color: white;
        padding: 20px;
    }

    main {
        padding: 20px 10px 20px;
        min-height: 200px;
    }

    .main-title {
        border-bottom: 1px solid #c1c1c1;
        padding: 5px;
    }

    .main-title p {
        margin-top: 20px;
    }

    .main-form-section {
        margin-top: 30px;
        background: #e9ecef;
        padding: 30px;
        border-radius: 5px;
        padding-bottom: 50px;
    }

    .contract_form input[type="text"],
    .contract_form input[type="email"] {
        height: 50px;
        border: 1px solid darkgrey;
        border-radius: 15px;
    }

    .contract_form textarea {
        height: 150px;
        border: 1px solid darkgrey;
        border-radius: 15px;
    }

    .success_alert {
        position: fixed;
        top: 30%;
        width: 90%;
        left: 5%;
        z-index: 5;
    }

    #display_button {
        padding: 25px;
        background: aliceblue;
    }
</style>

<body>
    <header>
        <div class="container">
            <div class="row">
                <?php
                $logo_image = file_get_contents(SYSTEM_BASE_URL_WEB . 'images/logo.png');
                $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image); ?>
                <div class="col-md-6 logo"><a href="<?php echo PUBLIC_BASE_URL; ?>"><img src="<?php echo $logo_base64; ?>" alt=""></a></div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </header>
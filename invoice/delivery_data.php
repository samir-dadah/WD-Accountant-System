<?php defined('ROOT') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $data['lang']; ?>" dir="<?php echo $data['direction']; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['page_title']; ?></title>

</head>

<style>
    @font-face {
        font-family: "Arial";
        font-style: bold;
        font-weight: bold;
        src: url('<?php echo $data['base_url']; ?>assets/fonts/Arial_Bold.ttf') format("truetype");
    }

    * {
        font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
    }

    html {
        margin: 0;
    }

    body {
        background-image: url('<?php echo $data['background']; ?>');
        background-repeat: no-repeat;
        background-position: center center;
        background-size: contain;
        color: black;
        padding-top: 440px;
        padding-bottom: 180px;
        margin-bottom: 10px;

    }

    header {
        position: fixed;
        width: 85%;
        left: 7.5%;
        top: 0;
        height: 425px;
    }

    footer {
        position: fixed;
        width: 100%;
        bottom: 25px;
        height: 145px;

    }

    main {
        position: relative;
        width: 85%;
        left: 7.5%;
        page-break-after: always;
    }

    main:last-child {
        page-break-after: avoid;
    }

    .product_table {
        border: 1px solid black;
        text-align: center;
    }

    .table td {
        padding: 2px;
        vertical-align: top;

    }

    .table th {
        padding-top: 4px;
    }

    table {
        width: 100%;
        max-width: 100%;

    }

    img {
        width: 100%;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td style="width: 50%;padding-top:50px;"><a href="<?php echo $data['logo_link']; ?>" target="_blank">
                        <img src="<?php echo $data['logo']; ?>" alt="" style="margin-top:23px;width:350px;"></a></td>
                <td></td>
            </tr>
            <tr>
                <td style="width:100%; color:black;font-size:18px;font-weight: 700;text-align:left;padding-top:10px;" colspan="2">
                    <h4 style="font-weight: 700;"><?php echo $data['company_title']; ?></h4>
                    <div style="width: 420px;height: 2px;background-color: #fb0498;margin-top:-12px;"></div>
                </td>

            </tr>
            <tr>
                <td style="width: 50%; padding-top:3px;">
                    <?php if ($data['customer_data']['company']) { ?>
                        <div style="font-size:22px;font-weight: 800;font-family: Arial , sans-serif ;font-weight: bold;"><?php echo $data['customer_data']['company']; ?></div>
                    <?php } ?>
                    <?php if ($data['customer_data']['firstname']) { ?>
                        <div><?php echo $data['customer_data']['firstname']; ?> <?php echo $data['customer_data']['surename']; ?></div>
                    <?php } ?>
                    <?php if ($data['customer_data']['address_1']) { ?>
                        <div><?php echo $data['customer_data']['address_1']; ?>, <?php echo $data['customer_data']['postcode']; ?> <?php echo $data['customer_data']['city']; ?></div>
                    <?php } ?>
                    <?php if ($data['customer_data']['tax_number']) { ?>
                        <div><?php echo $data['customer_data']['tax_number']; ?></div>
                    <?php } ?>

                </td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 60%;">
                    <p style="font-size:26px;font-weight:700;padding-top:24px;"><?php echo get_l('TEXT_DELIVERY') . ' : ' . $data['delivery_data']['delivery_id'] . ' - ' . date('y', strtotime($data['delivery_data']['delivery_date'])); ?></p>
                </td>
                <td style="width: 40%;padding-left:42.5px;padding-top:3px;line-height:1.5;">
                    <div style="display: inline-block;margin:0 auto;">
                        <?php echo get_l('INVOICE_NUMBER') . ' : ' . $data['invoice_data']['invoice_prfex'].' '. $data['invoice_data']['invoice_no'] . ' - ' . date('y', strtotime($data['invoice_data']['invoice_date'])); ?><br />
                        <?php echo get_l('CUSTOMER_NUMBER') . ' : ' . $data['customer_data']['customer_no']; ?><br />
                        <?php echo get_l('INVOICE_DATE_TEXT') . ' : ' . date('d.m.Y', strtotime($data['delivery_data']['delivery_date'])); ?>
                    </div>
                </td>
            </tr>
        </table>

    </header>
    <footer>

        <table>
            <tr>
                <td style="width: 47.5%;"></td>
                <td style="padding-top:78px;width:52.5%;line-height: 1.5;">
                    <div style="font-size: 10px;text-align:left;display:flex;">
                        <div style="word-wrap: break-word;"> <?php echo $data['address']; ?></div>
                        <div style="width:3px;height:50px;background-color:#fb0498;position:relative;left:190px;top:10px;"></div>
                        <div style="padding-left:210px;word-wrap: break-word;"> <?php echo $data['invoice_bottom_content'] ?></div>
                    </div>
                </td>
            </tr>
        </table>
    </footer>
    <main>

        <table style="margin-top:-8px;" width="100%" class="table text-center product_table " cellpadding="0" cellspacing="0">
            <tr style="background-color:rgba(243, 243, 243); padding-top: 4px !important;">
                <th align="center"><?php echo get_l('PRODUCT_TITLE'); ?></th>
                <th align="center"><?php echo get_l('QUANTITY_TXT'); ?></th>


            </tr>
            <?php
            $total = 0;
            $total_actual_amount = 0;
            $total_tax_amount = 0;
            foreach ($data['products_data'] as $product) {

                $actual_amount = $product["price"];
                $tax_amount = ($actual_amount * $product["tax"]) / 100;
                $total_product_amount = $actual_amount + $tax_amount;
                $total_actual_amount = $total_actual_amount + $actual_amount;
                $total_tax_amount = $total_tax_amount + $tax_amount;
                $total = $total + $total_product_amount;
            ?>
                <tr>

                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <table>
            <tr>
                <th align="center" width=""></th>
                <th align="center" width=""></th>
                <th align="center" width=""></th>
                <th align="center" width="25%"></th>

            </tr>
            <tr>
                <td colspan="4" style="text-align: left;font-size:12px;">
                 
                    <p><?php echo get_l('TEXT_DELIVERY_BOTTOM'); ?></p>
                    <p><?php echo get_l('TEXT_DELIVERY_BOTTOM_2'); ?></p>
                </td>
            </tr>
        </table>
        <?php if ($data['delivery_data']['comment'] !== '') { ?>
            <table>

                <tr>
                    <td colspan="4" style="text-align: left;font-size:12px;">
                        <?php echo $data['delivery_data']['comment']; ?>
                    </td>
                </tr>

            </table>
        <?php } ?>
    </main>
</body>

</html>
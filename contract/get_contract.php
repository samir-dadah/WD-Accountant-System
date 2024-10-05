<?php
defined('MR') or exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="<?php echo $data['lang']; ?>" dir="<?php echo $data['direction']; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['page_title']; ?></title>
    <style>
        html {
            margin: 0;
        }

        body {
            padding-top: 170px;
            padding-bottom: 120px;
            font-family: Arial, Helvetica, sans-serif !important;
        }

        header {
            position: fixed;
            width: 90%;
            top: 0;
            left: 5%;
            height: 170px;
            border-bottom: 1px solid #ccc;

        }

        footer {
            position: fixed;
            width: 90%;
            bottom: 0;
            left: 5%;
            height: 120px;
            border-top: 1px solid #ccc;
        }

        main {
            position: relative;
            width: 90%;
            left: 5%;
            page-break-after: always;

        }

        main:last-child {
            page-break-after: avoid;
        }

        table {
            width: 100%;
            max-width: 100%;
        }

        img {
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td style="width: 50%;"><a href="<?php echo $data['logo_link']; ?>" target="_blank">
                        <img src="<?php echo $data['logo']; ?>" alt=""></a>
               
                </td>
                <td></td>
            </tr>
        </table>

    </header>
    <footer>
        <table>
            <tr style="padding: 20px;">
                <td style="width:50%;padding:10px 0 0 10px;"><?php echo $data['address']; ?></td>
                <td style="width:50%;padding:10px 0 0 10px;"><?php echo $data['invoice_bottom_content'] ?></td>
            </tr>
        </table>
    </footer>
    <main>
        <table>
            <tr>
                <td style="text-align:center;width:100%;">
                                        <?php 
                    $contract_id = 0;
                    if ($data['contract_data']['contract_id'] <= 9 ){
                    $contract_id = '0'.$data['contract_data']['contract_id'];
                    } else{
                        $contract_id = $data['contract_data']['contract_id'];
                    }
                    
                    ?>
                    <h1><?php echo get_l('CONTRACT_TITLE'); ?> Nr.:<?php echo $contract_id; ?></h1>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <?php $width = 50;
                if (isset($data['invoice_no']) && $data['invoice_no'] !== 0) {
                    $width = 33.33;
                }
                ?>
                <td style="width: <?php echo $width; ?>%;"><?php echo get_l('TEXT_CITY'); ?> : <?php echo $data['contract_data']['order_city']; ?></td>
                <td style="width: <?php echo $width; ?>%;"><?php echo get_l('TEXT_DATE'); ?> : <?php echo $data['contract_data']['contract_date']; ?></td>
                <?php if (isset($data['invoice_no']) && $data['invoice_no'] !== 0) { ?>
                    <td><?php echo get_l('INVOICE_NUMBER') . ' : ' . $data['invoice_no']; ?></td>
                <?php } ?>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 35%;">
                    <h2><?php echo get_l('TEXT_SELLER'); ?></h2>
                </td>
                <td style="width: 30%;">
                    <h2><?php echo get_l('TEXT_BUYER'); ?></h2>
                </td>
                 <td style="width:35%;"></td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width:35%;"><?php echo $data['company_name']; ?></td>
                <td style="width:30%;"><?php echo get_l('TEXT_COMPANY'); ?>:</td>
                <td style="width:35%;"><?php echo $data['contract_data']['company']; ?></td>
            </tr>
            <tr>
                <td><?php echo $data['company_address']; ?></td>
                <td><?php echo get_l('TEXT_FIRSTNAME') . ',' . get_l('TEXT_LASTNAME'); ?>:</td>
                <td><?php echo $data['contract_data']['firstname']; ?><?php echo $data['contract_data']['surename']; ?></td>
            </tr>
            <tr>
                <td><?php echo $data['company_postcode']; ?> , <?php echo $data['company_city']; ?></td>
                <td><?php echo get_l('TEXT_EMAIL'); ?>:</td>
                <td><?php echo $data['contract_data']['email']; ?></td>
            </tr>
            <tr>
                <td><?php echo $data['company_email']; ?></td>
                <td><?php echo get_l('TEXT_PHONE_NUMBER'); ?>:</td>
                <td><?php echo $data['contract_data']['phone_number']; ?></td>
            </tr>
            <tr>
                <td><?php echo $data['company_number']; ?></td>
                <td><?php echo get_l('BIRTH_DATE'); ?>:</td>
                <td><?php echo $data['contract_data']['birth_date']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo get_l('TEXT_TAXNUMBER'); ?>:</td>
                <td><?php echo $data['contract_data']['tax_number']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo get_l('TEXT_ADDRESS'); ?>:</td>
                <td><?php echo $data['contract_data']['address_1']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo get_l('TEXT_POSTCODE'); ?>,<?php echo get_l('TEXT_CITY'); ?>:</td>
                <td><?php echo $data['contract_data']['postcode']; ?> , <?php echo $data['contract_data']['city']; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo get_l('TEXT_COUNTRY'); ?>:</td>
                <td><?php echo $data['contract_data']['country']; ?></td>
            </tr>

        </table>


        <table>
            <tr>
                <td><?php echo get_l('TEXT_CONDITIONS'); ?></td>
            </tr>
            <tr>
                <td style="background: #ccc;padding:20px;width:100%;"><?php echo $data['contract_data']['conditions']; ?></td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>

        <table style="margin-top: 20px;">
            <tr>
                <td style="width: 100%;">
                    <?php if ($data['contract_data']['approve'] && $data['contract_data']['approve'] == 1) { ?>
                        <div style="width:100%;">
                            <img src="<?php echo $data['icon']; ?>" style="width:20px;" alt=""> <?php echo get_l('TEXT_AGREEMENT_BUTTON_I_READ_CONDITIONS'); ?> <a href="<?php echo $data['conditions_page_link']; ?>"><?php echo $data['conditions_page_title']; ?></a>
                        </div>
                    <?php } else { ?>
                        <p style="color:red;"><?php echo get_l('TEXT_CUSTOMER_NOT_APPROVED'); ?></p>
                    <?php } ?>
                </td>
            </tr>
        </table>

        <table style="margin-top: 30px;">
            <tr>
                <td style="width: 50%;text-align:left;"><?php echo get_l('TEXT_BUYER'); ?></td>
                <td style="width: 50%;"></td>
            </tr>
            <tr>
                <td style="text-align:left;"><?php echo $data['contract_data']['company']; ?><br><?php echo $data['contract_data']['firstname']; ?><?php echo $data['contract_data']['surename']; ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;"><?php echo get_l('TEXT_SIGNATURE'); ?></td>
            </tr>
        </table>

    </main>
</body>

</html>

<?php
if (!isset($_GET['code'])) {
    header('location:login.php');
} else {
    include('config.php');
    require_once 'pdf.php';

    $quotation_data = get_quotation_data($connect, $_GET['code']);
    if($quotation_data){

        $customer_data= get_customer_data($connect, $quotation_data['customer_id']);
        $quotation = $customer_data['company'] . '-' . get_l('TEXT_QUOTATION').'-' . $quotation_data['quotation_id'] . '-' . $quotation_data['quotation_date'];
        $data = [];
        $data['lang'] = 'de';
        $data['direction'] = 'ltr';
        $data['base_url'] = $base_url;
        $logo_image = file_get_contents($base_url . 'images/logo.png');
        $data['logo'] = 'data:image/png;base64,' . base64_encode($logo_image);
        $data['logo_link'] = $logo_link;
        $background = file_get_contents($base_url.'images/background.png');
        $data['background'] = 'data:image/png;base64,' . base64_encode($background);
        $data['company_title'] = html_entity_decode($title);
        $data['address'] = $address;
        $data['invoice_bottom_content'] = $invoice_bottom_content;

        $data['quotation_data'] = $quotation_data;
        $data['customer_data'] = $customer_data;
        $data['products_data'] = get_products_by_type('mr_quotation_product','quotation_id',$quotation_data['quotation_id']);
        $data['ccsympol'] =$ccsympol;
        $data['payment_status'] =get_payment_method_name($connect, $quotation_data['payment_status']);
        $data['page_title'] = $quotation;

        $output = load_email_view('quotation_data', $data);
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($quotation, array("Attachment" => false));
        } else {
            $dompdf->stream($quotation, array("Attachment" => 1));
        }


    }else {
        header('location:login.php');
    }


}
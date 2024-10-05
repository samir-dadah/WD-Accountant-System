<?php
if (!isset($_GET['code'])) {
    header('location:login.php');
} else {
    include('config.php');
    require_once 'pdf.php';

    $delivery_data = get_delivery_data($connect, $_GET['code']);
    if($delivery_data){

        $customer_data= get_customer_data($connect, $delivery_data['customer_id']);
        $delivery = $customer_data['company'] . '-'. get_l('TEXT_DELIVERY').'-'  . $delivery_data['delivery_id'] . '-' . $delivery_data['delivery_date'];
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

        $data['delivery_data'] = $delivery_data;
        $data['customer_data'] = $customer_data;
        $data['invoice_data'] = get_order_data_by_id($connect, $delivery_data['order_id']);
        $data['products_data'] = get_products_by_type('mr_delivery_product','delivery_id',$delivery_data['delivery_id']);
        $data['ccsympol'] =$ccsympol;
       
        $data['page_title'] = $delivery;

        $output = load_email_view('delivery_data', $data);
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($delivery, array("Attachment" => false));
        } else {
            $dompdf->stream($delivery, array("Attachment" => 1));
        }


    }else {
        header('location:login.php');
    }


}
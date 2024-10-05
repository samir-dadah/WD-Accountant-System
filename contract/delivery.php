<?php
if (!isset($_GET['code'])) {
    header('location:index.php');
} else {
    define('MR', true);
    include_once './core/config.php';
    include_once './pdf.php';
    $delivery_data = get_delivery_data($_GET['code']);
    if ($delivery_data) {
        $customer_data= get_customer_data($delivery_data['customer_id']);
        $delivery = $customer_data['company'] . '-' . get_l('TEXT_DELIVERY').'-' . $delivery_data['delivery_id'] . '-' . $delivery_data['delivery_date'];
        $data = [];
        $data['lang'] = 'de';
        $data['direction'] = 'ltr';
        $data['base_url'] = SYSTEM_BASE_URL_WEB;
        $logo_image = file_get_contents(SYSTEM_BASE_URL_WEB . 'images/logo.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);
        $data['logo'] = $logo_base64;
        $background = file_get_contents(SYSTEM_BASE_URL_WEB.'images/background.png');
        $data['background'] = 'data:image/png;base64,' . base64_encode($background);
        $data['logo_link'] = get_s('logo_link');
        $data['address'] = get_s('address');
        $data['invoice_bottom_content'] = get_s('invoice_bottom_content');
        $data['company_title'] = get_s('title');
        $data['delivery_data'] = $delivery_data;
        $data['customer_data'] = $customer_data;
        $data['invoice_data'] = get_order_data_by_id($delivery_data['order_id']);
        $data['products_data'] = get_products_by_type('mr_delivery_product','delivery_id',$delivery_data['delivery_id']);
        $data['ccsympol'] ='<span style="font-family: DejaVu Sans; sans-serif;">€</span>';
       
        $data['page_title'] = $delivery;
        $output = load_email_view('get_delivery', $data);
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($delivery, array("Attachment" => false));
        } else {
            $dompdf->stream($delivery, array("Attachment" => 1));
        }       


    } else {
        header('location:index.php');
    }
}

<?php
if (!isset($_GET['code'])) {
    header('location:login.php');
} else {
    include('config.php');
    require_once 'pdf.php';

    $invoice_data = get_order_data($connect,$_GET['code']);
    if ($invoice_data) {
        $customer_data= get_customer_data($connect,$invoice_data['customer_id']);
        $invoice = $customer_data['company'] . '-'. get_l('INVOICE_NUMBER').'-' . $invoice_data['invoice_no'] . '-' . $invoice_data['invoice_date'];
        $data = [];
        $data['lang'] = 'de';
        $data['direction'] = 'ltr';
        $data['base_url'] = BASE_URL_WEB;
        $logo_image = file_get_contents(BASE_URL_WEB . 'images/logo.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);
        $data['logo'] = $logo_base64;
        $background = file_get_contents(BASE_URL_WEB.'images/background.png');
        $data['background'] = 'data:image/png;base64,' . base64_encode($background);
        $data['logo_link'] = get_s('logo_link');
        $data['address'] = get_s('address');
        $data['invoice_bottom_content'] = get_s('invoice_bottom_content');
        $data['company_title'] = get_s('title');
        $data['invoice_data'] = $invoice_data;
        $data['customer_data'] = $customer_data;
        $data['products_data'] = get_products_by_type('mr_order_product','order_id',$invoice_data['order_id']);
        $data['ccsympol'] ='<span style="font-family: DejaVu Sans; sans-serif;">€</span>';
        $data['payment_status'] =get_payment_method_name($connect,$invoice_data['payment_status']);
        $data['page_title'] = $invoice;
        $output = load_email_view('order_data', $data);
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($invoice, array("Attachment" => false));
        } else {
            $dompdf->stream($invoice, array("Attachment" => 1));
        }       


    } else {
        header('location:index.php');
    }
}
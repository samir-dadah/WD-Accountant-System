<?php
if (!isset($_GET['code'])) {
    header('location:index.php');
} else {
    define('MR', true);
    include_once './core/config.php';
    include_once './pdf.php';
    $quotation_data = get_quotation_data($_GET['code']);
    if ($quotation_data) {
        $customer_data= get_customer_data($quotation_data['customer_id']);
        $quotation = $customer_data['company'] . '-' . get_l('TEXT_QUOTATION').'-' . $quotation_data['quotation_id'] . '-' . $quotation_data['quotation_date'];
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
        $data['quotation_data'] = $quotation_data;
        $data['customer_data'] = $customer_data;
        $data['products_data'] = get_products_by_type('mr_quotation_product','quotation_id',$quotation_data['quotation_id']);
        $data['ccsympol'] ='<span style="font-family: DejaVu Sans; sans-serif;">€</span>';
        $data['payment_status'] =get_payment_method_name($quotation_data['payment_status']);
        $data['page_title'] = $quotation;

        $output = load_email_view('get_quotation', $data);
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($quotation, array("Attachment" => false));
        } else {
            $dompdf->stream($quotation, array("Attachment" => 1));
        }

    } else {
        header('location:index.php');
    }
}

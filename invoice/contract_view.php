<?php
if (!isset($_GET['code'])) {
    header('location:login.php');
} else {
    include('config.php');
    require_once 'pdf.php';


    $contract_data = get_contract_data($connect, $_GET['code']);

    if ($contract_data) {
        $contract = $contract_data['company'] . '-'. get_l('CONTRACT_TITLE').'-'  . $contract_data['contract_id'] . '-' . $contract_data['contract_date'];
        $data = [];
        $data['lang'] = 'de';
        $data['direction'] = 'ltr';
        $data['base_url'] = $base_url;
        $logo_image = file_get_contents($base_url . 'images/logo.png');
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);
        $data['logo'] = $logo_base64;
        $data['logo_link'] = $logo_link;
        $data['address'] = $address;
        $data['invoice_bottom_content'] = $invoice_bottom_content;
        $data['company_title'] = $title;
        $data['company_name']=$company_name;
        $data['company_address']=$company_address;
        $data['company_city']=$company_city;
        $data['company_postcode']=$company_postcode;
        $data['company_email']=$company_email;
        $data['company_number']=$company_number;
      
        if($contract_data['order_id'] && $contract_data['order_id'] !==0){
            $order_data =get_order_data_by_id($connect, $contract_data['order_id']);
            if($order_data && $order_data['invoice_no'] && $order_data['invoice_no'] !==0){
                $data['invoice_no'] =$order_data['invoice_no'];
            }
        }
        
        $data['conditions_page_link']=$conditions_page_link;
        $data['conditions_page_title'] = $conditions_page_title;
        $icon_image = file_get_contents($base_url . 'images/icon.png');
        $icon_base64 = 'data:image/png;base64,' . base64_encode($icon_image);
        $data['icon'] = $icon_base64;
        $data['contract_data'] = $contract_data;
        $data['page_title'] = $contract;

        $output = load_email_view('contract_data', $data);
        
        $dompdf = new Pdf();
        $dompdf->loadHtml($output);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        if (isset($_GET["pdfview"])) {
            $dompdf->stream($contract, array("Attachment" => false));
        } else {
            $dompdf->stream($contract, array("Attachment" => 1));
        }
        // to do save file and return value to send email 
        //$output_1 = $dompdf->output();
        //file_put_contents(ROOT.'pdf/'.$contract.'.pdf', $output_1);

    } else {
        header('location:login.php');
    }
}

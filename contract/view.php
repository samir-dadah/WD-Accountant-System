<?php
if (!isset($_GET['code'])) {
    header('location:index.php');
} else {
    define('MR' , true);
    include_once './core/config.php';
    include_once './pdf.php';

    $contract_data = get_contract_data($_GET['code']);
    if ($contract_data) {
        if($contract_data['approve'] ==1){
            $contract = $contract_data['company'] . '-' . get_l('CONTRACT_TITLE').'-' . $contract_data['contract_id'] . '-' . $contract_data['contract_date'];

            $data = [];
            $data['lang'] = 'de';
            $data['direction'] = 'ltr';
            $data['base_url'] = SYSTEM_BASE_URL_WEB;
            $logo_image = file_get_contents(SYSTEM_BASE_URL_WEB . 'images/logo.png');
            $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);
            $data['logo'] = $logo_base64;

            $data['logo_link'] = get_s('logo_link');
            $data['address'] = get_s('address');
            $data['invoice_bottom_content'] = get_s('invoice_bottom_content');
            $data['company_title'] = get_s('title');
            $data['company_name']=get_s('company_name');
            $data['company_address']=get_s('company_address');
            $data['company_city']=get_s('company_city');
            $data['company_postcode']=get_s('company_postcode');
            $data['company_email']=get_s('company_email');
            $data['company_number']=get_s('company_number');
          
            if($contract_data['order_id'] && $contract_data['order_id'] !==0){
                $order_data =get_order_data_by_id($contract_data['order_id']);
                if($order_data && $order_data['invoice_no'] && $order_data['invoice_no'] !==0){
                    $data['invoice_no'] =$order_data['invoice_no'];
                }
            }
    
            $data['conditions_page_link']=get_s('conditions_page_link');
            $data['conditions_page_title'] = get_s('conditions_page_title');
            $icon_image = file_get_contents(SYSTEM_BASE_URL_WEB . 'images/icon.png');
            $icon_base64 = 'data:image/png;base64,' . base64_encode($icon_image);
            $data['icon'] = $icon_base64;
            $data['contract_data'] = $contract_data;
            $data['page_title'] = $contract;
    
            $output = load_email_view('get_contract', $data);
            $dompdf = new Pdf();
            $dompdf->loadHtml($output);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            if (isset($_GET["pdfview"])) {
                $dompdf->stream($contract, array("Attachment" => false));
            } else {
                $dompdf->stream($contract, array("Attachment" => 1));
            }

        }else{
            header('location:index.php?code='.$_GET['code'].'&valid=false'); 
        }
    }else{
        header('location:index.php');
    }


}
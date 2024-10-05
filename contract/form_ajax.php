<?php 
define('MR', true);
if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
    die('No direct script access allowed');
}
include_once './core/config.php';

if (isset($_POST["action"])) {


    
    if ($_POST['action'] == 'Submit_contract_New') {
        sleep(2);
        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();

        $valid_keys = [
            "company",
            "firstname",
            "surename",
            "email",
            "phone_number",
            "address_1",
            "city",
            "country",
            "postcode",
            "conditions",
            "order_city",
            "contract_date",
            "birth_date",
            "tax_number",
            "approve",
            "password"
        ];
        foreach ($valid_keys as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '';
            }
        }

        $required_keys = [
            "company",
            "firstname",
            "surename",
            "email",
            "phone_number",
            "address_1",
            "city",
            "country",
            "postcode",
            "conditions",
            "order_city",
            "contract_date",
            'approve'
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] = get_l('TEXT_ERROR_INPUT');
            }
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error++;
            $error_msg['email'] =get_l('TEXT_ERROR_EMAIL');
        }
        if(!isset($_POST['approve']) &&  $_POST['approve'] !==1){
            $error++;
            $error_msg['approve'] =get_l('TEXT_ERROR_APPROVE');
        }


        if ($error == 0) {

            $order_id = 0;
            $customer_id = 0;
            $approve = 0;
            if(isset($_POST["approve"]) && $_POST["approve"] !== ''){
                $approve = 1;
            }
            $password ='';
            if(isset($_POST["password"]) && $_POST["password"] !== ''){
                $password = $_POST["password"];
            }
            $code = md5(microtime().rand());
            $data =array(
                ':order_id'     => $order_id,
                ':customer_id'  => $customer_id,
                ':company'		=>	$_POST["company"],
				':firstname'		=>	$_POST["firstname"],
                ':surename'		=>	$_POST["surename"],
				':birth_date'		=>	$_POST["birth_date"],
				':email'		=>	$_POST["email"],
                ':phone_number'		=>	$_POST["phone_number"],
				':address_1'		=>	$_POST["address_1"],
				':city'		=>	$_POST["city"],
                ':country'		=>	$_POST["country"],
				':postcode'		=>	$_POST["postcode"],
				':tax_number'		=>	$_POST["tax_number"],
                ':conditions'		=>	$_POST["conditions"],
                ':approve'  => $approve,
                ':order_city'		=>	$_POST["order_city"],
                ':contract_date'		=>	$_POST["contract_date"],
                ':ip' => getUserIP(),
                ':code' => $code,
                ':password'		=>	$password,
                ':date_added' =>date("Y-m-d H:i:s"),
                ':date_updated' => date("Y-m-d H:i:s")
			);
            $query = " INSERT INTO mr_contract 
            ( `order_id`, `customer_id`, `company`,
             `firstname`, `surename`, `birth_date`,
                `email`, `phone_number`, `address_1`,
                 `city`, `country`,
                `postcode`, `tax_number`, `conditions`,
                `approve`, `order_city`, `contract_date`,
                `ip`, `code`, `password`, `date_added`, `date_updated`) 
            VALUES
            (:order_id,:customer_id,:company,
            :firstname, :surename,:birth_date,
              :email,:phone_number, :address_1,
              :city,:country,
              :postcode,:tax_number,:conditions,
              :approve,:order_city,:contract_date,
              :ip,:code,:password,:date_added,:date_updated
              )";	
            $statement = $connect->prepare($query);
               if($statement->execute($data)){

                    $success_msg['title']= get_l('TEXT_SUCCESS_TITLE');
                    $success_msg['sub_title']=get_l('TEXT_SUCCESS_SUBTITLE');
                    $success_msg['view_contract'] = get_l('TEXT_YOU_CAN_VIEW_CONTRACT');
                    $success_msg['link']=PUBLIC_BASE_URL.'view.php?code='.$code.'&pdfview=1';
                    $output = array(
                        'success'        =>    true,
                        'success_msg'    =>    $success_msg
                    );               
               }
        }
        if ($error > 0) {
            $output = array(
                'error'        =>    true,
                'error_msg'    =>    $error_msg
            );
        }
        echo json_encode($output);
    }

    if ($_POST['action'] == 'GET_CONTRACT_DATA') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();

        $query = " SELECT * FROM mr_contract WHERE code = :code AND approve !='1' ";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':code'    =>    $_POST["code"]
            )
        );
        $result = $statement->fetchAll();
        if($result){
        foreach ($result as $row) {
            
            $output['success'] =true;
            $output['company'] = $row['company'];
            $output['firstname'] = $row['firstname'];
            $output['surename'] = $row['surename'];
            $output['birth_date'] = $row['birth_date'];
            $output['email'] = $row['email'];
            $output['phone_number'] = $row['phone_number'];
            $output['address_1'] = $row['address_1'];
            $output['city'] = $row['city'];
            $output['country'] = $row['country'];
            $output['postcode'] = $row['postcode'];
            $output['tax_number'] = $row['tax_number'];
            $output['conditions'] = html_entity_decode($row['conditions'], ENT_QUOTES, "UTF-8");
            $output['approve'] = $row['approve'];
            $output['order_city'] = $row['order_city'];
            $output['contract_date'] = $row['contract_date'];
          
        }
        }else{
        $output['error']=true;
        $output['link']=PUBLIC_BASE_URL;
        }
        echo json_encode($output);
    }

    if ($_POST['action'] == 'Update_Contract') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();
        $valid_keys = [
            "company",
            "firstname",
            "surename",
            "email",
            "phone_number",
            "address_1",
            "city",
            "country",
            "postcode",
            "conditions",
            "order_city",
            "contract_date",
            "birth_date",
            "tax_number",
            "approve"
        ];
        foreach ($valid_keys as $key) {
            if (!isset($_POST[$key])) {
                $_POST[$key] = '';
            }
        }

        $required_keys = [
            "company",
            "firstname",
            "surename",
            "email",
            "phone_number",
            "address_1",
            "city",
            "country",
            "postcode",
            "conditions",
            "order_city",
            "contract_date",
            "approve"
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] =  get_l('TEXT_ERROR_INPUT');
            }
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error++;
            $error_msg['email'] =get_l('TEXT_ERROR_EMAIL');
        }
        if(!isset($_POST['approve']) &&  $_POST['approve'] !==1){
            $error++;
            $error_msg['approve'] =get_l('TEXT_ERROR_APPROVE');
        }

        if ($error == 0) {


            $approve = 0;
            if(isset($_POST["approve"]) && $_POST["approve"] !== ''){
                $approve = 1;
            }

            $data =array(

                ':company'		=>	$_POST["company"],
				':firstname'		=>	$_POST["firstname"],
                ':surename'		=>	$_POST["surename"],
				':birth_date'		=>	$_POST["birth_date"],
				':email'		=>	$_POST["email"],
                ':phone_number'		=>	$_POST["phone_number"],
				':address_1'		=>	$_POST["address_1"],
				':city'		=>	$_POST["city"],
                ':country'		=>	$_POST["country"],
				':postcode'		=>	$_POST["postcode"],
				':tax_number'		=>	$_POST["tax_number"],
                ':conditions'		=>	$_POST["conditions"],
                ':approve'  => $approve,
                ':order_city'		=>	$_POST["order_city"],
                ':contract_date'		=>	$_POST["contract_date"],
                ':ip' => getUserIP(),
                ':date_updated' => date("Y-m-d H:i:s"),
                ':code'		=>	$_POST["code"]
			);

            $query = "
            UPDATE mr_contract 
            SET
            `company`=:company,
            `firstname`=:firstname,
            `surename`=:surename,
            `birth_date`=:birth_date,
            `email`=:email,
            `phone_number`=:phone_number,
            `address_1`=:address_1,
            `city`=:city,
            `country`=:country,
            `postcode`=:postcode,
            `tax_number`=:tax_number,
            `conditions`=:conditions,
            `approve`=:approve,
            `order_city`=:order_city,
            `contract_date`=:contract_date,
            `ip`=:ip,
            `date_updated`=:date_updated
            
            WHERE code = :code
            ";
            $statement = $connect->prepare($query);
            if($statement->execute($data)){

                $success_msg['title']= get_l('TEXT_SUCCESS_TITLE');
                $success_msg['sub_title']=get_l('TEXT_SUCCESS_SUBTITLE');
                $success_msg['view_contract'] = get_l('TEXT_YOU_CAN_VIEW_CONTRACT');
                $success_msg['link']=PUBLIC_BASE_URL.'view.php?code='.$_POST["code"].'&pdfview=1';

                $output = array(
                    'success'        =>    true,
                    'success_msg'    =>    $success_msg
                );               
           }

        }

        if ($error > 0) {
            $output = array(
                'error'        =>    true,
                'error_msg'    =>    $error_msg
            );
        }
        echo json_encode($output);
    }
    
}

?>
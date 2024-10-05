<?php
if (!($_SERVER['REQUEST_METHOD'] == 'POST')) {
    die('No direct script access allowed');
}
include('config.php');

session_start();


if (isset($_POST["action"])) {


    if ($_POST['action'] == 'Get_Contract') {

        $query = '';

        $output = array();

        $query .= " SELECT * FROM mr_contract  ";

        if (isset($_POST["search"]["value"])) {
            $query .= 'WHERE (contract_id  LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR company LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR firstname LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR surename LIKE "%' . $_POST["search"]["value"] . '%" ';
            $query .= 'OR email LIKE "%' . $_POST["search"]["value"] . '%") ';
        }
        if (isset($_POST["order"])) {
            $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY contract_id DESC ';
        }
        if ($_POST["length"] != -1) {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $data = array();
        $filtered_rows = $statement->rowCount();
        foreach ($result as $row) {

            $sub_array = array();
            $sub_array[] = $row['contract_id'];
            $sub_array[] = $row['company'];
            $sub_array[] = $row['contract_date'];
            $sub_array[] = $row['date_added'];
            $sub_array[] = $row['date_updated'];
            $approve = '<span class="text-danger">لم يتم الموافقة </span>';
            if ($row['approve'] == 1) {
                $approve = '<span class="text-success">تم الموافقة</span>';
            }
            $sub_array[] = $approve;
            $slug = 'view.php';
            $url = BASE_URL_PUBLIC . 'view.php?code=' . $row["code"] . '&pdfview=1';
            $sub_array[] = '<button type="button" name="make_qr" id="' . $url . '" data-name="' . $row['company'] . '.png" class="btn btn-dark btn-xs make_qr">صنع QR </button>
            <button class="btn btn-primary m-2 MR_copy_clipboard"  data-clipboard-text="' . $url . '"><i class="far fa-copy"></i></button>';
            $sub_array[] = '
            <a href="contract_view.php?code=' . $row["code"] . '" class="btn btn-info btn-xs m-2">تحميل PDF</a>
			<a href="contract_view.php?code=' . $row["code"] . '&pdfview=1" class="btn btn-info btn-xs m-2">عرض PDF</a>';
            $sub_array[] = '<button type="button" name="update" id="' . $row["contract_id"] . '" class="btn btn-warning btn-xs update">تحديث</button>';
            $data[] = $sub_array;
        }
        function get_total_all_records($connect)
        {
            $statement = $connect->prepare("SELECT * FROM mr_contract");
            $statement->execute();
            return $statement->rowCount();
        }
        $output = array(
            "draw"                =>     intval($_POST["draw"]),
            "recordsTotal"      =>  $filtered_rows,
            "recordsFiltered"     =>     get_total_all_records($connect),
            "data"                =>     $data
        );
        echo json_encode($output);
    }

    if ($_POST['action'] == 'add_new') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();

        $valid_keys = [
            "order_id",
            "customer_id",
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
            "contract_date"
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] = 'هذا الحقل مطلوب';
            }
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error++;
            $error_msg['email'] = 'يرجى كتابة بريد الكتروني صالح';
        }



        if ($error == 0) {

            $order_id = 0;
            if (isset($_POST["order_id"]) && $_POST["order_id"] !== '') {
                $order_id = $_POST["order_id"];
            }
            $customer_id = 0;
            if (isset($_POST["customer_id"]) && $_POST["customer_id"] !== '') {
                $customer_id = $_POST["customer_id"];
            }
            $approve = 0;
            if (isset($_POST["approve"]) && $_POST["approve"] !== '') {
                $approve = 1;
            }
            $password = '';
            if (isset($_POST["password"]) && $_POST["password"] !== '') {
                $password = $_POST["password"];
            }

            $data = array(
                ':order_id'     => $order_id,
                ':customer_id'  => $customer_id,
                ':company'        =>    $_POST["company"],
                ':firstname'        =>    $_POST["firstname"],
                ':surename'        =>    $_POST["surename"],
                ':birth_date'        =>    $_POST["birth_date"],
                ':email'        =>    $_POST["email"],
                ':phone_number'        =>    $_POST["phone_number"],
                ':address_1'        =>    $_POST["address_1"],
                ':city'        =>    $_POST["city"],
                ':country'        =>    $_POST["country"],
                ':postcode'        =>    $_POST["postcode"],
                ':tax_number'        =>    $_POST["tax_number"],
                ':conditions'        =>    $_POST["conditions"],
                ':approve'  => $approve,
                ':order_city'        =>    $_POST["order_city"],
                ':contract_date'        =>    $_POST["contract_date"],
                ':ip' => getUserIP(),
                ':code' => md5(microtime() . rand()),
                ':password'        =>    $password,
                ':date_added' => date("Y-m-d H:i:s"),
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
            if ($statement->execute($data)) {
                $output = array(
                    'success'        =>    true,
                    'success_msg'    =>    'تم اضافة العقد بنجاح'
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

        $query = " SELECT * FROM mr_contract WHERE contract_id = :contract_id";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':contract_id'    =>    $_POST["contract_id"]
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['contract_id'] = $row['contract_id'];
            $output['order_id'] = $row['order_id'];
            $output['customer_id'] = $row['customer_id'];
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
            $output['conditions'] = $row['conditions'];
            $output['approve'] = $row['approve'];
            $output['order_city'] = $row['order_city'];
            $output['contract_date'] = $row['contract_date'];
            $output['password'] = $row['password'];
        }

        echo json_encode($output);
    }

    //
    if ($_POST['action'] == 'edit_contract') {

        $error = 0;
        $output = array();
        $error_msg = array();
        $success_msg = array();
        $valid_keys = [
            "order_id",
            "customer_id",
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
            "password",
            "contract_id"
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
            "contract_date"
        ];
        // check empty inputs
        foreach ($required_keys as $key) {
            if (empty($_POST[$key])) {
                $error++;
                $error_msg[$key] = 'هذا الحقل مطلوب';
            }
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error++;
            $error_msg['email'] = 'يرجى كتابة بريد الكتروني صالح';
        }
        if ($error == 0) {

            $order_id = 0;
            if (isset($_POST["order_id"]) && $_POST["order_id"] !== '') {
                $order_id = $_POST["order_id"];
            }
            $customer_id = 0;
            if (isset($_POST["customer_id"]) && $_POST["customer_id"] !== '') {
                $customer_id = $_POST["customer_id"];
            }
            $approve = 0;
            if (isset($_POST["approve"]) && $_POST["approve"] !== '') {
                $approve = 1;
            }
            $password = '';
            if (isset($_POST["password"]) && $_POST["password"] !== '') {
                $password = $_POST["password"];
            }
            $data = array(
                ':order_id'     => $order_id,
                ':customer_id'  => $customer_id,
                ':company'        =>    $_POST["company"],
                ':firstname'        =>    $_POST["firstname"],
                ':surename'        =>    $_POST["surename"],
                ':birth_date'        =>    $_POST["birth_date"],
                ':email'        =>    $_POST["email"],
                ':phone_number'        =>    $_POST["phone_number"],
                ':address_1'        =>    $_POST["address_1"],
                ':city'        =>    $_POST["city"],
                ':country'        =>    $_POST["country"],
                ':postcode'        =>    $_POST["postcode"],
                ':tax_number'        =>    $_POST["tax_number"],
                ':conditions'        =>    $_POST["conditions"],
                ':approve'  => $approve,
                ':order_city'        =>    $_POST["order_city"],
                ':contract_date'        =>    $_POST["contract_date"],
                ':ip' => getUserIP(),
                ':password'        =>    $password,
                ':date_updated' => date("Y-m-d H:i:s"),
                ':contract_id'        =>    $_POST["contract_id"]
            );

            $query = "
            UPDATE mr_contract 
            SET
            `order_id`=:order_id,
            `customer_id`=:customer_id,
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
            `password`=:password,
            `date_updated`=:date_updated
            
            WHERE contract_id = :contract_id
            ";
            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $output = array(
                    'success'        =>    true,
                    'success_msg'    =>    'تم تعديل العقد بنجاح '
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


    if ($_POST['action'] == 'GET_CUSTOMER_DATA') {
        $query = " SELECT * FROM mr_customer WHERE customer_id = :customer_id";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':customer_id'    =>    $_POST["customer_id"]
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['customer_id'] = $row['customer_id'];
            $output['firstname'] = $row['firstname'];
            $output['surename'] = $row['surename'];
            $output['company'] = $row['company'];
            $output['email'] = $row['email'];
            $output['address_1'] = $row['address_1'];
            $output['city'] = $row['city'];
            $output['postcode'] = $row['postcode'];
            $output['tax_number'] = $row['tax_number'];
        }

        echo json_encode($output);
    }
}

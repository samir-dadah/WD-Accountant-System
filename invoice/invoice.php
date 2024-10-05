<?php 

if(!isset($_GET['code']))
	{
		header('location:login.php');
	}

if(isset($_GET["code"]))
{
include('config.php');
require_once 'pdf.php';


ob_start();
session_start();
ini_set('max_execution_time', 300);
ini_set("memory_limit","512M");
$background = file_get_contents($base_url.'images/background.png');
$base64 = 'data:image/png;base64,' . base64_encode($background);

$logo_image = file_get_contents($base_url.'images/logo.png');
$logo_base64 = 'data:image/png;base64,' . base64_encode($logo_image);


$order_data= get_order_data($connect, $_GET["code"]);
if ($order_data)
{

$customer_data= get_customer_data($connect, $order_data['customer_id']);	


 //  <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	$output = '
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link rel="stylesheet" href="assets/css/all.css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
 
  <style type="text/css" >
  
@font-face {
  font-family: "Arial";
  font-style: bold;
  font-weight: bold;
  src: url('.$base_url.'assets/fonts/Arial_Bold.ttf) format("truetype");
}
*{    font-family: Arial, "Helvetica", Arial, "Liberation Sans", sans-serif;
}
  html { margin: 0; }
  body{ background-image: url('.$base64.');background-repeat: no-repeat; background-position: center;color:black;}
    @page { margin: 250px 20px;margin-bottom:200px !important;}
	
	
     table tr {
            page-break-after: always;
        }

        table tr td {
            page-break-after: always;
        }
		
     table tr td:last-child { page-break-after: never; }
		
   header { position: fixed; top: -300px; left: 0px; right: 0px;  height: 300px; }
   .main_logo{
	 position:fixed;
     left:7.5%;
     top:75px;
	 text-align: center; 
	 width:350px;
	 height:110px;
   }
   .main_logo img {
	   width:100%;
	  
	   margin:0 auto;
	   display:block;
	   z-index:100;
   }
 .header_title{
	 position:fixed;
	 left:7.5%;
	top:190px;
	width:450px;
	 color:black;
	 font-size:18px;
	 font-weight: 700;
	 text-align:left;
	

 }
 .header_title_border{
	margin-top:-10px;
	width:420px; 
	height:2px;
	background-color: #fb0498;
 }
.header_title h4{
font-weight: 700;
}	
  .invoice_main_info{
	  position:relative;
	  top:230px;
	  width:85%;
	  margin: 0 auto ;
	  height:150px;
	 
  }
.customer_data{
	position:relative;
	 left:0;
	 top:-5px;
	 width:350px;
	 height:90px; 
	 padding-top:-25px;
	 
}

.customer_data div{
   
   margin-bottom:-5px; 
}

.company_title {
	font-size:22px;
	font-weight: 800;
	 font-family: Arial , sans-serif ;
  font-weight: bold;
}
 .customer_data_left{	
	position:absolute;
	 left:0;
	 top:100px;
	 width:350px;
	 height:50px; 
	 display: inline-block;
	  margin: 0 auto ;
	  font-size:26px;
	  font-weight:700;
} 


.customer_data_right{
	position:absolute;
	 right:30px;
	 top:100px;
	 width:200px;
	 height:50px; 	
	display: inline-block;
	 margin: 0 auto ;
}
.invoice_product_section{
	  position:relative;
	  top:280px;
      width:85%;
	  margin: 0 auto ;
		
	
	
}
.product_table{
	
	  border:1px solid black;	
}
.total_table{
	margin-top:0px !important;
	
}
.total_table tr { 
margin-bottom:0;
height: 30px;
}
.no_border{
	border:none;
}
   footer { position: fixed; bottom: -200px; left: 0px; right: 0px;  height: 200px; }
   
.dot_2{
    background-color:#fb0498;width:5px;height:5px;z-index:50;
    border-radius: 2.5px 2.5px 2.5px 2.5px;
	 display: inline-block;
}   
   .social_icons{
	position:fixed;
	bottom: -50px;
	left:2%;
	width:250px;
    color: white;
	font-size: 12pt;
	font-weight:100;
	font-family:  Arial, Helvetica, sans-serif  ;
	}  
.social_icons a{
color: white;
outline: none;
text-decoration: none;
background-color: transparent;
padding-left: 0;
/*border:1px solid blue;*/
line-height:15px;
height:15px;
}
.social_icons p{
color: white;


}
.social_icons  i{
	color: white;
padding-right: 5px;
}
.social_icons a i{
	color: white;
}
.social_items{
 list-style: none;

}

.social_items li{
/*margin: -5px;*/
/*border:1px solid black;*/
}
.social_items li div {
 display:inline-block;
  	margin-top:5px !important;
}

.social_text {
    display: flex;
 
}
.social_text p {
    word-wrap: break-word;
  
}
.footer_left_box{
	position:fixed;
	bottom: -195px;
	right:10px;
    width:405px;	
	height:100px;
font-size: 10px;
text-align:left;
}
.footer_left_box p{
color:black;	
}
.bottom_detayls_1{
	position: absolute;
	top: 0px;
	left:0px;
	width:190px;	
	display: inline-block;
word-wrap: break-word;
margin: 0 auto ;
padding-top: 15px;


}

.sparetor_v{
width:3px;
height:50px;
background-color:#fb0498;
display: inline-block;
margin: 0 auto ;
position: absolute;
left:190px;
top:25px;}
.bottom_detayls_2{
	position: absolute;
	top: 0px;
	left:210px;
	width:190px;
display: inline-block;
word-wrap: break-word;
margin: 0 auto ;
padding-top: 15px;

}
.ccsymbol {
  


}

.ccsymbol:after {
   content: "  €";
  /* padding-left: 15px;
    padding-right: 15px;*/
}
  </style>
</head>
<body>
  <header>
  <div class="main_logo"><a href="'.$logo_link.'"><img src="'.$logo_base64.'" ></a>
  <div class="header_title"><h4>'.$title.'</h4><div class="header_title_border"></div></div>
  </div>
  
  
  </header>
 <footer>
  <div class="social_icons">'.load_social_links($connect).'</div>
  <div class="footer_left_box">
  
  <div class="bottom_detayls_1">
  '.$address.'
 </div> 
  <div class="sparetor_v"></div>
   <div class="bottom_detayls_2">
  '.$invoice_bottom_content.'
 </div> 
  
  </div>
  </footer>

  <div style="position: fixed; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000;  border: 1px solid gray;">
 <img src="'.$base64.'" style="width: 100%;">
</div>
  
  

  
  
  
  <main>
   
<div class="invoice_main_info">
';
$output .='
<div class="customer_data">';

if ($customer_data['company'])
{
$output .='<div class="company_title">'.$customer_data['company'].'</div>';
}
if ($customer_data['firstname'])
{
$output .='<div>'.$customer_data['firstname'].' '.$customer_data['surename'].'</div>';
}

if ($customer_data['address_1'])
{
$output .='<div>'.$customer_data['address_1'].',  '.$customer_data['postcode'].'  '.$customer_data['city'].'</div>';
}
if ($customer_data['tax_number'])
{
$output .='<div>'.$customer_data['tax_number'].'</div>';
}

$output .='</div>';


$output .='
<div class="customer_data_left">
<br />
<p>'.INVOICE_NUMBER.' : '.$order_data['invoice_prfex'].'  '.$order_data['invoice_no'].' - '.date("y").'</p>

</div>
<div class="customer_data_right">

'.CUSTOMER_NUMBER.' : '.$customer_data['customer_no'].'<br />
'.INVOICE_DATE_TEXT.' : '.date('d.m.Y', strtotime($order_data['invoice_date'])).'<br />
</div>

</div>
 



 



  
         

 
';

$output .='

<div class="invoice_product_section">

<table width="100%" class="text-center product_table "  cellpadding="0" cellspacing="0">
					<tr style="background-color:rgba(243, 243, 243);">
						<th align="center" >'.PRODUCT_TITLE.'</th>
						<th align="center" >'.QUANTITY_TXT.'</th>
						<th align="center" >'.PRICE_TXT.'</th>
						<th align="center" width="25%">'.TOTAL_TXT.'</th>
						
					</tr>


';
$statement = $connect->prepare("
			SELECT * FROM mr_order_product 
			WHERE order_id = :order_id
		");
		$statement->execute(
			array(
				':order_id'       =>  $order_data['order_id']
			)
		);
		$product_result = $statement->fetchAll();
		$count = 0;
		$total = 0;
		$total_actual_amount = 0;
		$total_tax_amount = 0;
		foreach($product_result as $sub_row)
		{
			$count = $count + 1;
			$product_data = fetch_product_details($sub_row['product_id'], $connect);
			
			//update proce quantity 
			//$actual_amount = $sub_row["quantity"] * $sub_row["price"];
			$actual_amount = $sub_row["price"];
			
			$tax_amount = ($actual_amount * $sub_row["tax"])/100;
			$total_product_amount = $actual_amount ;
			$total_product_amount_1 = $actual_amount + $tax_amount;
			$total_actual_amount = $total_actual_amount + $actual_amount;
			$total_tax_amount = $total_tax_amount + $tax_amount;
			$total = $total + $total_product_amount_1 ;

$output .= '
				<tr>
					
					<td class="no_border" >'.$product_data['product_name'].'</td>
					<td class="no_border" >'.$sub_row["quantity"].'</td>
					<td class="no_border text-right" style="padding-right:85px;" > '.price_format($sub_row["price"]).' '.$ccsympol.'</td>
					<td class="no_border text-right" style="padding-right:65px;" >'.price_format($total_product_amount).' '.$ccsympol.'</td>
				</tr>
			';

		}
		
		
		
		
		
		
$output .='</table>';		


$output .= '<table width="100%" class="text-center total_table " cellpadding="0" cellspacing="0">
					<tr style="">
						<th align="center" width=""></th>
						<th align="center" width=""></th>
						<th align="center" width="" ></th>
						<th align="center" width="25%"></th>
						
					</tr>
		<tr>
		    <td ></td>
		    <td ></td>
			<td class="text-right">'.NET_TOTAL_TXT.'</td>
			<td  class="text-right" style="padding-right:65px;">'.price_format($total_actual_amount) .'  '.$ccsympol.'</td>
		</tr>
		<tr>
		
		    <td ></td>
		    <td ></td>
			<td  class="text-right">'.TAX_TXT.'</td>		
			<td class="text-right" style="padding-right:65px;" >'.price_format($total_tax_amount).'  '.$ccsympol.'</td>
		</tr>
	';
//if ($order_data['shipping_cost'] !=='0.00'){
	
	$total = $total + $order_data['shipping_cost'] ;
$output .= '<tr>
		    <td ></td>
		    <td ></td>
			<td   class="text-right">'.SHIPPING_TXT.'</td>
			<td   class="text-right" style="padding-right:65px;"> '.price_format($order_data['shipping_cost']) .'  '.$ccsympol.'</td>
		</tr>';
//}
//if ($order_data['first_payment'] !=='0.00'){
	$total = $total - $order_data['first_payment'] ;
$output .= '<tr>
		    <td ></td>
		    <td ></td>
			<td  class="text-right">'.FIRST_PAYMENT_TXT.'</td>
			<td class="text-right" style="padding-right:65px;" >'.price_format($order_data['first_payment']).'  '.$ccsympol.'</td>
		</tr>';
//}
//if ($order_data['discount_total'] !='0.00'){
	$total = $total - $order_data['discount_total'] ;
$output .= '<tr>
		    <td ></td>
		    <td ></td>
			<td class="text-right"><b>'.DISCOUNT_TXT.'</b></td>
			<td  class="text-right" style="padding-right:65px;" >'.price_format($order_data['discount_total']).' '.$ccsympol.'</td>
		</tr>';
//}

$output .='<tr>
		    <td ></td>
		    <td ></td>
			<td class="text-right">'.GENERAL_TOTAL_TXT.'</td>
			<td   class="text-right" style="padding-right:65px;">'.price_format($total).' '.$ccsympol.'</td>
		</tr>';
		
$output .='<tr>
		    <td colspan="2" class="text-left" >'.PAYMENT_METHOD_TXT.' '.get_payment_method_name($connect, $order_data['payment_status']).'</td>
		    
			<td></td>
			<td></td>
		</tr>';		
$output .='<tr style="">
		    <td colspan="4" class="text-left " style="margin-top:10px !important;font-size:12px;">Die Ware bleibt bis zur restlosen Bezahlung - auch in verarbeitetem Zustand - unser Eigentum.<br>Es gilt der verlängerte und erweiterte Eigentumsvorbehalt.</td>

		</tr>';			
		
/*$output .='<tr style="">
		    <td colspan="4" class="text-left" style="margin-top:5px !important;">Es gilt der verlängerte und erweiterte Eigentumsvorbehalt.</td>

		</tr>';	*/		
		
$output .='
</table>
</div>
 
 </main>
</body>
</html>';


	




$dompdf = new Pdf();

$dompdf->getOptions()->setChroot(ROOT);
//$dompdf->getOptions()->setChroot($base_url);
//$dompdf->getOptions()->setIsRemoteEnabled(TRUE);
$dompdf->loadHtml($output);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();
$invoice_name =INVOICE_NUMBER .'  '.$order_data['invoice_no'];
if (isset($_GET["pdfview"]))
{
	
	
	
// Output the generated PDF to Browser
$dompdf->stream( "'.$invoice_name.'", array("Attachment" => false));
	
}
else {
// Output the generated PDF to Browser
$dompdf->stream( $invoice_name, array("Attachment" => 1));
	
	
}




}
	

else {
	
header('location:order.php');	
	
	
}
}









?>

<?php
include_once "MOLPay.POS.class.php";
$params['amount'] 		= $_POST['amount'];
$params['orderid']		= $_POST['orderid'];
$params['country'] 		= $_POST['country'];
$params['cur'] 			= $_POST['cur'];

$params['merchant_id'] 	= '_MERCHANT_MERCHANT_ID';
$params['verify_key']	= '_MERCHANT_VERIFY_KEY_';

$params['bill_name'] 	= $_POST['bill_name'];
$params['bill_email'] 	= $_POST['bill_email'];
$params['bill_mobile']	= $_POST['bill_mobile'];
$params['bill_desc']	= $_POST['bill_desc'];
$params['terminal_id']	= '_MERCHANT_TERMINAL_ID_';

$payment 	= new POS_MOLPay($params);
$result		= $payment->MobilePay();

print_r (json_encode($result));

?>
<?php
include_once "MOLPay.POS.class.php";
$params['amount'] 		= 2;
$params['orderid']		= "DEMO4001";
$params['country'] 		= 'MY';
$params['cur'] 			= 'MYR';
$params['merchant_id'] 	= 'MyCompany_Dev';

$params['verify_key']	= 'b2d0f925f54efa933a3f7b80a7d37b43'; 

$params['channel'] 		= 'MOLWallet';

$params['bill_name'] 	= 'Hardi';
$params['bill_email'] 	= 'hardi@molpay.com';
$params['bill_mobile']	= '60176176984';//$_GET['bill_mobile'];
$params['bill_desc']	= 'transaction for ';
$params['terminal_id']	= 'test';

$payment 	= new POS_MOLPay($params);
$result		= $payment->getQRCode();

print_r (json_encode($result));

?>
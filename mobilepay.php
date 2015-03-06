<?php
include_once "MOLPay.POS.class.php";
$params['amount'] 		// 10;
$params['orderid']		// "DEMO4001";
$params['country'] 		= 'MY';
$params['cur'] 			= 'MYR';
$params['merchant_id'] 	// '_YOUR_MERCHANT_ID';

$params['verify_key']	// '_YOUR_VERIFY_KEY'; 

$params['channel'] 		= 'MOLWallet';

$params['bill_name'] 	// 'Hardi';
$params['bill_email'] 	// 'hardiansyah@molpay.com';
$params['bill_mobile']	// $_GET['bill_mobile'];
$params['bill_desc']	// 'transaction for '.$params['orderid']. ' '. date('d-m-Y G:i:s');
$params['terminal_id']	// '_YOUR_TERMINAL_ID';

$payment 	= new POS_MOLPay($params);
$result		= $payment->MobilePay();

print_r (json_encode($result));

?>
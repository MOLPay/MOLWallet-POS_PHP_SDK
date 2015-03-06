<?php
include_once "MOLPay.POS.class.php";

$params['merchant_id'] 			// '_YOUR_MERCHANT_ID';
$params['merchant_order_id']	// '_YOUR_ORDER_ID'; 

$payment 	= new POS_MOLPay();
$result		= $payment->CheckInvoice($params);

echo $result;

//result//
// 0 = no invoice created
// 1 = invoice created
// 2 = invoice accepted
// 3 = invoice paid
// 4 = invoice canceled

?>
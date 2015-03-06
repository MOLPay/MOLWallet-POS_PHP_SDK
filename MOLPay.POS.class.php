<?php
/***
	======================= MOLPay.POS.class ======== Created By : HardyBoyz - 10-02-2015 ================
	used to post data to MOLPay from POS machine. consist of 2 method : 
	1. QR4Buyer Payment : Buyer scan QRCode in POS machine. QRCode is obtained from MOLWallet.
	2. MobilePay		: POS machine send notification to buyer mobile app, buyer approve the payment in mobile app.
	-----------------------
***/
Class POS_MOLPay {
	
	var $url 	= 'https://www.onlinepayment.com.my/MOLPay/API/mobile_new/index.php';
	var $params = array();
	var $verify_key;	
	
	function __construct($params){
		$this->params['merchant_id'] 		= $params['merchant_id'];
		$this->params['merchant_order_id'] 	= $params['merchant_order_id'];
		$this->params['bill_desc']			= $params['bill_desc'];
		$this->params['channel']			= 'MOLWallet'; // DO NOT CHANGE THIS VALUE
		$this->params['bill_mobile']		= '60388888888'; // DO NOT CHANGE THIS VALUE
		$this->params						= $params;
		
		$this->params['vcode'] 			= md5($this->params['amount'].$params['merchant_id'].$this->params['orderid'].									$params['verify_key']."E9");		
		return $this->params;
	}
	
	function getQRCode(){
		$this->params['method']		= 'QR4Buyer';
		$this->params['msgType']	= 'E9';
		$this->params['l_version']	= '2';
		$this->params['app_name']	= $this->params['merchant_id'];
		
		$postdata 				= json_encode($this->params);
		
		$QRCode = curl_init( $this->url );
		curl_setopt($QRCode,CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($QRCode,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($QRCode,CURLOPT_HTTPHEADER, array( "Accept:application/json" ) );	
		curl_setopt($QRCode,CURLOPT_POSTFIELDS, $postdata);
		
		$result = curl_exec( $QRCode );
		
		curl_close( $QRCode );
		
		$results = json_decode($result, 1);
		
		if($results['msgType'] == 'E10'){
			$urlMobile = 'https://web.molwallet.com/MOLWallet-GTWs/APIs/index.php';
			
			$mobile['merchant_id']		= $this->params['merchant_id'];
			$mobile['merchant_order_id']= $this->params['merchant_order_id'];
			$mobile['terminal_id']		= $this->params['terminal_id'];
			$mobile['wallet_id']		= $this->params['bill_mobile'];
			$mobile['amount']			= $this->params['amount'];
			$mobile['description']		= $this->params['bill_desc'];
			$mobile['currency']			= $this->params['cur'];
			$mobile['method']			= $this->params['method'];
			$mobile['MsgID']			= $this->params['MsgID'];
			
			$data			= json_encode($mobile);
			$datetime 		= time();
			$checksum = SHA1( $data . md5($this->params['verify_key']) . $datetime);
			
			$postdataMobile				= array('params'=>json_encode($mobile),'checksum'=>$checksum,'appname'=>'MyCompany_Dev');
			
			$m 		= curl_init( $urlMobile );
			curl_setopt( $m, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt( $m, CURLOPT_RETURNTRANSFER, true);
			curl_setopt( $m, CURLOPT_HTTPHEADER, array( "Accept:application/json" ) );	
			curl_setopt( $m, CURLOPT_POSTFIELDS, $postdataMobile );

			$notif = curl_exec( $m );
			curl_close( $m );	
			
			return $notif;
		}
		
	}
	
	function MobilePay(){
		$this->params['method']		= 'MobilePay';
		$this->params['msgType']	= 'E9';
		$this->params['l_version']	= '2';
		$this->params['app_name']	= $this->params['merchant_id'];
		
		$postdata 				= json_encode($this->params);
		
		$ch 		= curl_init( $this->url );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Accept:application/json" ) );	
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postdata );

		$result = curl_exec( $ch );
		
		curl_close( $ch );		
		
		$results = json_decode($result, 1);
		
		if($results['msgType'] == 'E10'){
			$urlMobile = 'https://web.molwallet.com/MOLWallet-GTWs/APIs/index.php';
			
			$mobile['merchant_id']		= $this->params['merchant_id'];
			$mobile['merchant_order_id']= $this->params['merchant_order_id'];
			$mobile['terminal_id']		= $this->params['terminal_id'];
			$mobile['wallet_id']		= $this->params['bill_mobile'];
			$mobile['amount']			= $this->params['amount'];
			$mobile['description']		= $this->params['bill_desc'];
			$mobile['currency']			= $this->params['cur'];
			$mobile['method']			= $this->params['method'];
			$mobile['MsgID']			= $this->params['MsgID'];
			
			$data			= json_encode($mobile);
			$datetime 		= time();
			$checksum = SHA1( $data . md5($this->params['verify_key']) . $datetime);
			
			$postdataMobile				= array('params'=>json_encode($mobile),'checksum'=>$checksum);
			
			$m 		= curl_init( $urlMobile );
			curl_setopt( $m, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt( $m, CURLOPT_RETURNTRANSFER, true);
			curl_setopt( $m, CURLOPT_HTTPHEADER, array( "Accept:application/json" ) );	
			curl_setopt( $m, CURLOPT_POSTFIELDS, $postdataMobile );

			$notif = curl_exec( $m );
			curl_close( $m );	
			
			return $notif;
		}
	}
	
	function CheckInvoice($params){
		$urlMobile = 'https://web.molwallet.com/MOLWallet-GTWs/APIs/Payment/InvoiceStatus';
		
		$mobile['merchant_id']		= $params['merchant_id'];
		$mobile['merchant_order_id']= $params['merchant_order_id'];
		
		$data			= json_encode($mobile);
		$datetime 		= time();
		$checksum 		= SHA1( $data . md5($this->params['verify_key']) . $datetime);
		
		$postdataMobile	= $mobile;
		
		$m 		= curl_init( $urlMobile );
		curl_setopt( $m, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt( $m, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $m, CURLOPT_POSTFIELDS, $postdataMobile );

		$notif = curl_exec( $m );
		curl_close( $m );	
		return $notif;
	}
	
}

?>
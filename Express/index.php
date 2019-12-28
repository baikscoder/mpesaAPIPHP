<?php

require('../functions.php');
$BusinessShortCode = "174379";
$Password = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$Amount = 10;
$MSISDN = "254719733620";
$Timestamp = date("Ymdhis");
$pass_key = base64_encode($BusinessShortCode . $Password . $Timestamp);
$InitiatorName = "testapi113";
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$token = generateToken();

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $token));

$curl_post_data = array(
//Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $pass_key,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $MSISDN,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $MSISDN,
    'CallBackURL' => 'https://pesacash.com/safdaraja/Express/callback/',
    'AccountReference' => 'trans1',
    'InitiatorName' => $InitiatorName,
    'TransactionDesc' => 'Test'
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
echo $curl_response;
?>
<?php

require_once '../Functions.php';
$func = new Functions();

//STK Push configurations
$BusinessShortCode = "174379";
$Password = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$Amount = 10;
$MSISDN = "254724017787";
$InitiatorName = "testapi113";
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$AccountReference = "test";
$TransactionDesc = "test";

//Token Generation configurations
$consumer_key = 'rdw9g5DzW6mfVSQ8GfruAPDGMY0TLc2f'; //Fill with your app Consumer Key
$consumer_secret = '7koLaFmBusW2IOdi'; // Fill with your app Secret
$authurl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$response = $func->STKPush($BusinessShortCode, $Password, $Amount, $MSISDN, $InitiatorName,
        $url, $authurl, $consumer_key, $consumer_secret, $AccountReference, $TransactionDesc);
echo $response;
?>
<?php

require_once '../Functions.php';
include('../connect.php');
$func = new Functions();

//STK Push configurations
$BusinessShortCode = "174379";
$Password = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

//Remember subscription should only be for users who have not paid
// NB: Phone number should be unique in table user. Now its not
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
//$CallBackURL = 'https://pesacash.com/safdaraja/stkpush/callback/';
$CallBackURL = 'https://c3e00ced.ngrok.io/DarajaIntegration/stkpush/callback/';
$response = $func->STKPush($BusinessShortCode, $Password, $Amount, $MSISDN, $InitiatorName, $url, $authurl, $consumer_key, $consumer_secret, $AccountReference, $TransactionDesc, $CallBackURL);
$finalresponse = json_decode($response);

if (isset($finalresponse->ResponseCode)) {
    $sql = "INSERT INTO mpesa_transactions (checkout_request_id,amount,phone_number,result_code,result_description,created_at,transaction_type) "
            . "VALUES (:checkout_request_id,:amount,:phone_number,:result_code,:result_description,:created_at,:transaction_type)";
    $q = $db->prepare($sql);
    $q->execute(array(':checkout_request_id' => $finalresponse->CheckoutRequestID, ':amount' => $Amount, ':phone_number' => $MSISDN,
        ':result_code' => $finalresponse->ResponseCode, ':result_description' => $finalresponse->ResponseDescription,
        ':created_at' => date('Y-m-d h:i:s'), ':transaction_type' => 'STKPUSH'));
} else {
    echo "I don't think we need to log failed transactions whereby i.e phone is off, user cancelled the transaction coz its not helpful";
}
?>
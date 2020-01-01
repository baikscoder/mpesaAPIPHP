<?php

require_once '../Functions.php';
include('../connect.php');
$func = new Functions();

//Reg configurations
$regurl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
$confirmationUrl = 'https://c3e00ced.ngrok.io/DarajaIntegration/c2b/confirmation/';
$validationUrl = 'https://c3e00ced.ngrok.io/DarajaIntegration/c2b/validation/';
$shortcode = 602942;
//Auth configurations
$consumer_key = 'rdw9g5DzW6mfVSQ8GfruAPDGMY0TLc2f'; //Fill with your app Consumer Key
$consumer_secret = '7koLaFmBusW2IOdi'; // Fill with your app Secret
$authurl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

//C2B Simulate configurations..NB: On live this will not be required since transactions will originate from phone
$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
//C2B Simulate paramters..NB: On live this will not be required since transactions will originate from phone
$amount = 100;
$msisdn = 25470837449;
$BillRefNumber = 'test'; //This will be used to identify the bet to purchase i.e bet ID: 23456 is arsenal vs man u tonight
$authresponse = $func->registerURL($regurl, $confirmationUrl, $validationUrl, $shortcode, $authurl, $consumer_key, $consumer_secret);
$response = $func->simulateC2B($url, $amount, $msisdn, $shortcode, $authurl, $consumer_key, $consumer_secret, $BillRefNumber);
echo $response;
?>
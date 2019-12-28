<?php

function generateToken() {
    $consumer_key = 'rdw9g5DzW6mfVSQ8GfruAPDGMY0TLc2f'; //Fill with your app Consumer Key
    $consumer_secret = '7koLaFmBusW2IOdi'; // Fill with your app Secret
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    $credentials = base64_encode($consumer_key . ':' . $consumer_secret);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $curl_response = curl_exec($curl);
    return json_decode($curl_response)->access_token;
}

function registerURL() {

    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
    $access_token = ''; // check the mpesa_accesstoken.php file for this. No need to writing a new file here, just combine the code as in the tutorial.
    $shortCode = '600147'; // provide the short code obtained from your test credentials
    /* This two files are provided in the project. */
    $confirmationUrl = 'https://pesacash.com/safdaraja/confirmation/'; // path to your confirmation url. can be IP address that is publicly accessible or a url
    $validationUrl = 'https://pesacash.com/safdaraja/validation/'; // path to your validation url. can be IP address that is publicly accessible or a url
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . generateToken())); //setting custom header	
    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'ShortCode' => $shortCode,
        'ResponseType' => 'Confirmed',
        'ConfirmationURL' => $confirmationUrl,
        'ValidationURL' => $validationUrl
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    //print_r($curl_response);

    return $curl_response;
}

function simulateC2B($amount, $phone, $shortcode) {
    $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . generateToken())); //setting custom header


    $curl_post_data = array(
        //Fill in the request parameters with valid values
        'ShortCode' => $shortcode,
        'CommandID' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'Msisdn' => $phone,
        'BillRefNumber' => 'Test On Payment'
    );

    $data_string = json_encode($curl_post_data);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

    $curl_response = curl_exec($curl);
    //print_r($curl_response);

    return $curl_response;
}

?>
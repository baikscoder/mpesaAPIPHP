<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Functions {

    public function generateToken($consumer_key, $consumer_secret, $url) {
//        $consumer_key = 'rdw9g5DzW6mfVSQ8GfruAPDGMY0TLc2f'; //Fill with your app Consumer Key
//        $consumer_secret = '7koLaFmBusW2IOdi'; // Fill with your app Secret
//        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

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

    public function STKPush($BusinessShortCode, $Password, $Amount, $MSISDN, $InitiatorName, $url, $authurl, $consumer_key, $consumer_secret, $AccountReference, $TransactionDesc) {
//        $BusinessShortCode = "174379";
//        $Password = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
//        $Amount = 10;
//        $MSISDN = "254724017787";
//        $InitiatorName = "testapi113";
//        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $Timestamp = date("Ymdhis");
        $pass_key = base64_encode($BusinessShortCode . $Password . $Timestamp);
        $token = $this->generateToken($consumer_key, $consumer_secret, $authurl);
        $dir = "\\logs\\stkpush\\";
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
            'CallBackURL' => 'https://pesacash.com/safdaraja/stkpush/callback/',
            'AccountReference' => $AccountReference,
            'InitiatorName' => $InitiatorName,
            'TransactionDesc' => $TransactionDesc
        );

        $data_string = json_encode($curl_post_data);
        $this->file_force_contents($dir, $data_string, "Request.log");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);
        //file_put_contents(date("Y-m-d") . ".log", date("Y-m-d h:i:s") . "::" . $curl_response . "\n", FILE_APPEND | LOCK_EX);
        $this->file_force_contents($dir, $curl_response, "Response.log");
        return $curl_response;
    }

    public function file_force_contents($dir, $contents, $file) {
        $dir = dirname(__FILE__) . $dir . date("Ymd");
        if (!is_dir($dir))
            mkdir($dir);
        file_put_contents("$dir\\$file", date("Y-m-d h:i:s") . "::" . $contents . "\n", FILE_APPEND | LOCK_EX);
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user = "NOTAFRIC";
$password = "Jat3s@2018123!";
$sender = "NOTIAFRICA";
$GSM = "254724017787";
$SMStext = urlencode("Sample sms");
$url = "http://193.105.74.159/api/sendsms/plain";

function SendSMS($user, $password, $sender, $GSM, $SMStext, $url) {
    $url .= "?user=$user&password=$password&sender=$sender&GSM=$GSM&SMStext=$SMStext";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $curl_response = curl_exec($curl);
    echo $curl_response;
}

SendSMS($user, $password, $sender, $GSM, $SMStext, $url);

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$user=
$url="http://193.105.74.159/api/sendsms/plain?user=NOTAFRIC&password=Jat3s@2018123!&sender=NOTIAFRICA&GSM=254719733620&SMStext=tTesting";
//http://193.105.74.159/api/command?username=NOTAFRIC&password=Jat3s@2018123!&cmd=CREDITS
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$curl_response = curl_exec($curl);
echo $curl_response;

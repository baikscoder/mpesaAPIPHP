<?php
require_once '../../Functions.php';
include('../../connect.php');
$func = new Functions();

$ResultCode = 0;
$ResultDesc = "Confirmation Received Successfully";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);
$mpesarequest = json_decode(file_get_contents('php://input'), true);
$dir = "\\logs\\c2b\\";
//log request from mpesa
$func->file_force_contents($dir, json_encode($mpesarequest), "Confirmationrequest.log");


//log request to mpesa
$func->file_force_contents($dir, json_encode($arrayresponse), "Confirmationresponse.log");
echo json_encode($arrayresponse);
?>

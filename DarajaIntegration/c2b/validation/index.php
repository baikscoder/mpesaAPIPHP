<?php
require_once '../../Functions.php';
include('../../connect.php');
$func = new Functions();

$ResultCode = 0;
$ResultDesc = "Transaction validated successfully";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);
$mpesarequest = json_decode(file_get_contents('php://input'), true);
$dir = "\\logs\\c2b\\";
//log request from mpesa
$func->file_force_contents($dir, json_encode($mpesarequest), "Validationrequest.log");


//if (isset($finalresponse->ResponseCode)) {
//    $sql = "INSERT INTO mpesa_transactions (checkout_request_id,amount,phone_number,result_code,result_description,created_at,transaction_type) "
//            . "VALUES (:checkout_request_id,:amount,:phone_number,:result_code,:result_description,:created_at,:transaction_type)";
//    $q = $db->prepare($sql);
//    $q->execute(array(':checkout_request_id' => $finalresponse->CheckoutRequestID, ':amount' => $Amount, ':phone_number' => $MSISDN,
//        ':result_code' => $finalresponse->ResponseCode, ':result_description' => $finalresponse->ResponseDescription,
//        ':created_at' => date('Y-m-d h:i:s'), ':transaction_type' => 'STKPUSH'));
//} else {
//    echo "I don't think we need to log failed transactions whereby i.e phone is off, user cancelled the transaction coz its not helpful";
//}

//log response to mpesa
$func->file_force_contents($dir, json_encode($arrayresponse), "Validationresponse.log");
echo json_encode($arrayresponse);
?>

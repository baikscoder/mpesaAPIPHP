<?php

$ResultCode = 0;
$ResultDesc = "Process successful";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);
$mpesarequest = json_decode(file_get_contents('php://input'), true);

file_put_contents(date("Y-m-d").".log", date("Y-m-d h:i:s") . "::" . json_encode($mpesarequest) . "\n", FILE_APPEND | LOCK_EX);
echo json_encode($arrayresponse);

$res = json_decode($arrayresponse);
echo "ResultCode: " . $res->Body->stkCallback->ResultCode . "<br>";
echo "ResultDesc: " . $res->Body->stkCallback->ResultDesc . "<br>";
echo "CheckoutRequestID: " . $res->Body->stkCallback->CheckoutRequestID . "<br>";
if ($res->Body->stkCallback->ResultCode === 0) {
    echo "Amount: " . $res->Body->stkCallback->CallbackMetadata->Item[0]->Value . "<br>";
    echo "MpesaReceiptNumber: " . $res->Body->stkCallback->CallbackMetadata->Item[1]->Value . "<br>";
    echo "PhoneNumber: " . $res->Body->stkCallback->CallbackMetadata->Item[4]->Value . "<br>";
}
?>

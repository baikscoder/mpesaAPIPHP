<?php

include('../../connect.php');
include('../../Functions.php');

$func = new Functions();
$ResultCode = 0;
$ResultDesc = "Process successful";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);

$mpesarequest = file_get_contents('php://input');
$res = json_decode($mpesarequest, true);
$dir = "\\logs\\stkpush\\";
//log request from mpesa
$func->file_force_contents($dir, json_encode($mpesarequest), "Callbackrequest.log");

//log respons to mpesa
$func->file_force_contents($dir, json_encode($arrayresponse), "Callbackresponse.log");
$ResCode = $res['Body']['stkCallback']['ResultCode'];
$ResDesc = $res['Body']['stkCallback']['ResultDesc'];
$CheckoutRequestID = $res['Body']['stkCallback']['CheckoutRequestID'];
$MpesaReceiptNumber = '';
if ($ResCode === 0) {
    $Amount = $res['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
    $MpesaReceiptNumber = $res['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
    $PhoneNumber = $res['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
}

$sql = "UPDATE mpesa_transactions SET result_code=?, result_description=?, mpesa_receipt_no=?,updated_at=? WHERE checkout_request_id=?";
$q = $db->prepare($sql);
$q->execute(array($ResCode, $ResDesc, $MpesaReceiptNumber, date("Y-m-d h:i:s"), $CheckoutRequestID));



$sqlsms = "UPDATE users SET has_paid=? WHERE phone_number=?";
$qsms = $db->prepare($sqlsms);
$qsms->execute(array(true, $PhoneNumber));


/* Start send SMS */
if ($ResCode === 0) { //We only send sms for a successful transaction
//Parametize SMS configs
    $user = "NOTAFRIC";
    $password = "Jat3s@2018123!";
    $sender = "NOTIAFRICA";
    $GSM = $PhoneNumber;
    $url = "http://193.105.74.159/api/sendsms/plain";
//Compose SMS here by pulling user info from users table
    $qry = "SELECT * FROM users WHERE phone_number='$GSM'";
    $result = $db->prepare($qry);
    $result->execute();
    $SMStext = '';
    for ($i = 0; $row = $result->fetch(); $i++) {
        $sms = "Congratulations " . $row['name'] . "," . "your subscription to Khelo betting has been done successfully. You can now purchase single bet.";
        $SMStext = urlencode($sms);
    }

//Once subscription is made successfully send SMS
    $func->SendSMS($user, $password, $sender, $GSM, $SMStext, $url);
}
/* End send SMS */

echo json_encode($arrayresponse);
?>
<?php

//Array response should be parametrized coz can be failure or success
$ResultCode = 0;
$ResultDesc = "Transaction validated successfully";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);
// Save the M-PESA input stream. 
$mpesarequest = json_decode(file_get_contents('php://input'), true);

// log the response
$logFile = "validationRequest.txt";

// will be used when we want to save the response to database for our reference
// write the M-PESA Response to file
file_put_contents($logFile, date("Y-m-d h:i:s") . "::" . json_encode($mpesarequest) . "\n", FILE_APPEND | LOCK_EX);
echo json_encode($arrayresponse);
?>

<?php

//Array response should be parametrized coz can be failure or success
$ResultCode = 0;
$ResultDesc = "Process successful";
$arrayresponse = array("ResultCode" => $ResultCode, "ResultDesc" => $ResultDesc);
// Save the M-PESA input stream. 
$mpesarequest = json_decode(file_get_contents('php://input'), true);

/* If we have any validation, we will do it here then change the $response if we reject the transaction */
// Your Validation
// $response = '{  "ResultCode": 1, "ResultDesc": "Transaction Rejected."  }';
/* Ofcourse we will be checking for amount, account number(incase of paybill), invoice number and inventory.
  But we reserve this for future tutorials */

// log the response
$logFile = "ExpressResponse.txt";

// will be used when we want to save the response to database for our reference
// write the M-PESA Response to file
file_put_contents($logFile, date("Y-m-d h:i:s") . "::" . json_encode($mpesarequest) . "\n", FILE_APPEND | LOCK_EX);
echo json_encode($arrayresponse);
?>

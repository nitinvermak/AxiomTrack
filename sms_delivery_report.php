<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
$request = $_REQUEST["data"];
$jsonData = json_decode($request,true);
/*$link = mysqli_connect("myhost", "myuser", "mypassw", "mybd") or die("Error " . mysqli_error($link));*/
foreach($jsonData as $key => $value)
{
     // request id 
    $requestID = $value['requestId'];
    $userId = $value['userId'];
    $senderId = $value['senderId'];
    foreach($value['report'] as $key1 => $value1)
    {
        //detail description of report
        $desc = $value1['desc'];
        // status of each number
        $status = $value1['status'];
        // destination number
        $receiver = $value1['number'];
        //delivery report time
        $date = $value1['date'];
        $query = "INSERT INTO smsReport (request_id,user_id,sender_id,date,receiver,status,description) VALUES ('" . $requestID . "','" . $userId . "','" . $senderId . "','" . $date . "','" . $receiver . "','" . $status . "','" . $desc . "')";
		echo $query.'khg';
        mysqli_query($query);
    }
}
   /* Further you can use above parameters and either update your database or just display it  
    as per your need .*/
?>


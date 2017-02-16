<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
//include("../includes/payment_master.php"); 
set_time_limit(0); 
error_reporting(E_ALL);
$jsonData = $_POST['postdata'];
$decode_Json_Data = json_decode($jsonData);

foreach($decode_Json_Data as $array){
	foreach($array as $key => $val){
		$break_an_array = explode("=",$val);
		$sql = "UPDATE `tbl_gps_vehicle_payment_master` SET `next_due_date`='$break_an_array[1]' 
				WHERE `Vehicle_id`='$break_an_array[0]'
				AND `PlanactiveFlag` = 'Y'";
		$result = mysql_query($sql);
	}
}
//echo "<p style='color:green; font-weight:bold; padding-top:20px'>Due Date Generated !</p>";
echo '<div class="alert alert-success alert-dismissible small-alert" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Due Date Generated !</strong> 
	  </div>';
?>
<?php
include("../includes/config.inc.php"); 
$csv_export = '';
$date = $_GET['date'];
$dateto = $_GET['dateto'];
$company = $_GET['company'];
$reffered = $_GET['reffered'];
$technician = $_GET['technician'];
// query to get data from database
$sql = "SELECT A.customer_Id as CustId, C.Company_Name as C_name, B.callingdata_id, A.vehicle_no as V_no, A.mobile_no as Mob, A.device_id as D_id, A.model_name as model, A.installation_date as I_date, B.telecaller_id as TelecallerName, A.techinician_name as T_id 
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customer_Id = B.cust_id
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id";
if ( ($company != 0) or ( $date !='' and $dateto !='') or ($reffered != 0) or ($technician != 0) )
	{
		$sql  = $sql." WHERE ";	
	}
$counter = 0;
if($company != 0)
	{
		if ($counter > 0 )
	 	$sql =$sql.' AND ';
		$sql  =$sql." B.callingdata_id = '$company'" ;
		$counter+=1;
		/*echo $sql;*/
	}
if ( $date !='' and $dateto !='') {
	if ($counter > 0 )
	 	$sql =$sql.' AND ';
	$sql =$sql."  DATE(A.installation_date) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	/*echo $sql;*/
}
if($reffered != 0)
	{
		if ($counter > 0 )
	 	$sql =$sql.' AND ';
		$sql  =$sql." B.telecaller_id = '$reffered'" ;
		$counter+=1;
		/*echo $sql;*/
	}
if($technician != 0)
	{
		if ($counter > 0 )
	 	$sql =$sql.' AND ';
		$sql  =$sql." A.techinician_name = '$technician'" ;
		$counter+=1;
		/*echo $sql;*/
	}
$rows = mysql_fetch_assoc($select_table);
if($rows)
	{
	getcsv(array_keys($rows));
	}
	while($rows)
	{
	getcsv($rows);
	$rows = mysql_fetch_assoc($select_table);
	}

// get total number of fields present in the database
function getcsv($no_of_field_names)
{
$separate = '';


// do the action for all field names as field name
foreach ($no_of_field_names as $field_name)
{
if (preg_match('/\\r|\\n|,|"/', $field_name))
{
$field_name = '' . str_replace('', $field_name) . '';
}
echo $separate . $field_name;

//sepearte with the comma
$separate = ',';
}

//make new row and line
echo "\r\n";
}
?>
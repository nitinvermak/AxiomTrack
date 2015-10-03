<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");
header("Content-Type: text/csv");
header("Content-Disposition:attachment;filename=vehicle_report.csv");
$select_table = mysql_query("SELECT A.customer_Id as CustId, C.Company_Name as C_name, B.callingdata_id, A.vehicle_no as V_no, A.mobile_no as Mob, A.device_id as D_id, A.model_name as model, A.installation_date as I_date, B.telecaller_id as TelecallerName, A.techinician_name as T_id 
							FROM tbl_gps_vehicle_master as A 
							INNER JOIN tbl_customer_master as B 
							ON A.customer_Id = B.cust_id
							INNER JOIN tblcallingdata as C 
							ON B.callingdata_id = C.id");
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
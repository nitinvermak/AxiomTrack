<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");
header("Content-Type: text/csv");
header("Content-Disposition:attachment;filename=exported-data.csv");
$select_table = mysql_query("SELECT  A.id as DeviceId,A.imei_no as IMEI, A.company_id as CompId, B.branch_id as Branch_name, A.status as status, A.assignstatus as branch_asgn_status, B.branch_id as Branch_name , D.CompanyName as branch, B.technician_assign_status as technician_asgn_status, C.technician_id as TechnicianId, E.First_Name as fname, E.Last_Name as lname

	                    FROM tbl_device_master as A 
						LEFT OUTER JOIN tbl_device_assign_branch as B
						ON A.id = B.device_id
						LEFT OUTER JOIN tbl_device_assign_technician as C
						ON B.device_id = C.device_id
						LEFT OUTER JOIN tblbranch as D 
						ON B.branch_id = D.id
						LEFT OUTER JOIN tbluser as E 
						ON C.technician_id = E.id ORDER BY A.id");
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
<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");
header("Content-Type: text/csv");
header("Content-Disposition:attachment;filename=tickrts.csv");
$select_table = mysql_query("SELECT A.ticket_id as Ticket_Id, A.organization_id as Orgranization_Id, A.createddate as Create_Date, A.close_date as Close_date, A.product as Product_Id, A.rqst_type as Request_Type, A.ticket_status as Ticket_Status, A.appointment_date as Appointment_Date, C.technician_id as Technician_Name, B.branch_id as Branch_Name
			FROM tblticket as A 
			LEFT OUTER JOIN tbl_ticket_assign_branch as B 
			ON A.ticket_id = B.ticket_id
			LEFT OUTER JOIN tbl_ticket_assign_technician as C 
			ON B.ticket_id = C.ticket_id
			LEFT OUTER JOIN tbluser as D 
			ON C.technician_id = D.id");
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
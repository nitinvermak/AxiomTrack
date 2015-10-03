<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");
header("Content-Type: text/csv");
header("Content-Disposition:attachment;filename=exported-data.csv");
$select_table = mysql_query("SELECT * FROM tblsim as A 
							 LEFT OUTER JOIN tbl_sim_branch_assign as B
							 ON A.id = B.sim_id
							 LEFT OUTER JOIN tbl_sim_technician_assign as C
							 ON B.sim_id = C.sim_id
							 LEFT OUTER JOIN tblbranch as D 
							 ON B.branch_id = D.id
							 LEFT OUTER JOIN tbluser as E 
							 ON C.technician_id = E.id");
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
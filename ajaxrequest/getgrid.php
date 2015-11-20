<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$where='';
if($state=$_REQUEST['state']!="")
	{
		$where.=" and tblcallingdata.State='".$_REQUEST['state']."'";
	}
if($state=$_REQUEST['city']!="")
	{
		$where.=" and tblcallingdata.City='".$_REQUEST['city']."'";
	}
if($state=$_REQUEST['callingcat']!="")
	{
		$where.= "and tblcallingdata.id NOT IN (select callingdata_id 
				  from tblassign where callingcategory_id='".$_REQUEST['callingcat']."') and calling_status=0 ";
	}
	$linkSQL="";	
	$linkSQL = "select * from tblcallingdata where 1=1 $where ";
	$oRS = mysql_query($linkSQL); 
?>
<table class="table table-bordered table-hover">  
<tr>
<th><small>S. No.</small></th>     
<th><small>Name</small></th> 
<th><small>Company Name</small></th>   
<th><small>Phone</small></th> 
<th><small>Mobile</small></th> 
<th><small>State</small></th> 
<th><small>City</small></th> 
<th><small>Area</small></th> 
<th><small>Actions              
<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
&nbsp;&nbsp;
<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
</small>
</th>     
</tr>    
<?php
$kolor=1;
	if(mysql_num_rows($oRS)>0)
		{
  			while ($row = mysql_fetch_array($oRS))
  		{ 
  			if($kolor%2==0)
				$class="bgcolor='#ffffff'";
			else
				$class="bgcolor='#fff'";
 ?>
<tr <?php print $class?>>
<td><small><?php print $kolor++;?>.</small></td>
<td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></small></td>
<td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
<td><small><?php echo stripslashes($row["Phone"]);?></small></td>
<td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
<td><small><?php echo getstate(stripslashes($row["State"]));?></small></td>
<td><small><?php echo getcities(stripslashes($row["City"]));?></small></td>
<td><small><?php echo getarea(stripslashes($row["Area"]));?></small></td>
<td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
</tr>
<?php 
}
	echo $pagerstring;
}
else
    echo "<h3 style='color:red;'>No records found!</h3><br>";
?> 
<table>
<tr>
<td height="50"><input type="submit" onClick="return val();" value="Submit" class="btn btn-primary btn-sm" id="submit" /></td>
</tr>
</table><br />
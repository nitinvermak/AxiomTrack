<?php
include("../includes/config.inc.php"); 

							$where='';
							
							if($state_id=$_REQUEST['state_id']!="")
							{
							$where.=" and tblcallingdata.State='".$_REQUEST['state_id']."'";
							}
							if($state_id=$_REQUEST['city']!="")
							{
							$where.=" and tblcallingdata.City='".$_REQUEST['city']."'";
							}
							if($state_id=$_REQUEST['callcat']!="")
							{
							$where.=" and tblcallingdata.id NOT IN (select callingdata_id from tblassign where 	callingcategory_id='".$_REQUEST['callcat']."') and calling_status=0 ";
							}
$linkSQL="";	
$linkSQL = "select * from tblcallingdata where 1=1 $where ";
$oRS = mysql_query($linkSQL); 
?>
<table class="table table-bordered table-hover">  
<tr>
<th>S. No.</th>     
<th>Name</th> 
<th>Company Name</th>   
<th>Phone</th> 
<th>Mobile</th> 
<th>State</th> 
<th>City</th> 
<th>Area</th> 
<th>Actions              
<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
&nbsp;&nbsp;
<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></th>     </tr>    
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
<td><?php print $kolor++;?>.</td>
<td><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></td>
<td><?php echo stripslashes($row["Company_Name"]);?></td>
<td><?php echo stripslashes($row["Phone"]);?></td>
<td><?php echo stripslashes($row["Mobile"]);?></td>
<td><?php echo stripslashes($row["State"]);?></td>
<td><?php echo stripslashes($row["City"]);?></td>
<td><?php echo stripslashes($row["Area"]);?></td>
<td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
</tr>
<?php 
}
	echo $pagerstring;
}
else
    echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 
						  <table>
						  <tr>
                          <td></td>
                          <td> </td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td height="50"><input type="submit" onClick="return val();" value="Submit" class="btn btn-primary" id="submit" /></td>
                          </tr>
                          </table><br />
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$UserCat = mysql_real_escape_string($_POST['UserCat']);
echo $UserCat;
$linkSQL =  "SELECT * FROM tblmodulename as A 
			 LEFT OUTER JOIN tblusercategorymodulemapping as B 
			 ON A.id = B.moduleId
			 LEFT OUTER JOIN tblusercategory as C 
			 ON B.usercategoryId = C.User_Category WHERE B.usercategoryId='$UserCat'";
echo $linkSQL;
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table class="table table-hover table-bordered">';
?>	
	<tr>
	<th>S. No.</th>                   
	<th>Module Name</th>  
	<th>User Category</th>
    <th>Action</th>	
    </tr>
    <?php
	$kolor =1;
	while ($row = mysql_fetch_array($stockArr))
  		{
		   if($row["technician_assign_status"]==1)
		   		{
					$stock ='Assigned';
				 }  
		   if($kolor%2==0)
					$class="bgcolor='#ffffff'";
		   else
					$class="bgcolor='#fff'";  	
 	?>
    <tr <?php print $class?>>
    <td><?php print $kolor++;?>.</td>
	<td><?php echo stripslashes($row["module_name"]);?></td>	
    <td><?php echo stripslashes($row["usercategoryId"]);?></td>	
    <td><input type="checkbox" name="check[]" id="check" disabled="disabled" /></td>
    </tr>
    <?php
		}
}
else
	echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
	?> 
    <!--<form method="post">
    <table>
    <tr>
    <td></td>
    <td colspan="3"><input type="button" name="enable" id="enable" onclick="Enable()" value="Edit" /></td>
    <td></td>
    </tr>
    </table><br />
    </form> -->  

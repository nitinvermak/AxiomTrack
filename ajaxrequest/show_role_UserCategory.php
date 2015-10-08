<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$UserCat = mysql_real_escape_string($_POST['UserCat']);
/*echo $UserCat;*/
$linkSQL =  "SELECT A.moduleName as Module, A.moduleCatId as moduleCatId, A.moduleId as MId FROM tblmodulename as A left outer join tblusercategorymodulemapping as B On A.moduleId = B.moduleId and B.usercategoryId ='$UserCat'";
/*echo $linkSQL;*/
$stockArr=mysql_query($linkSQL);
$planRateQuery= "Select * from tblmodulecategory";
	$planRateQueryArr = mysql_query($planRateQuery);
 
	$moduleCatNameDict = array();
	while ($rowA = mysql_fetch_array( $planRateQueryArr)){
	
			$moduleCatNameDict[$rowA["moduleCatId"] ] =$rowA["moduleCategory"];
		
		
	}
if(mysql_num_rows($stockArr)>0)
	{
?>	
    <?php
	$kolor =1;
	$moduleCat = 0;
	$temp = 0;
	while ($row = mysql_fetch_array($stockArr))
  		{
		   if(($moduleCat==0) or ($moduleCat != $row["moduleCatId"]))
		   {
		   		if($moduleCat==0)
				{
						echo "<h2 class='title'>".$moduleCatNameDict[$row["moduleCatId"]]."</h2>";
					 	echo "<table class='table table-hover table-bordered'>
							
							<tr>
							<th class='col-md-3'>S. No.</th>                   
							<th class='col-md-6'>Module Name</th>  
							
							<th class='col-md-3'><p>Action<small>
							<input type='checkbox' onclick=checkPermission(".$row["moduleCatId"].")  /> Check/Uncheck All				
							</small></p>
							</th>	
							</tr>";
				}
				else
				{
						echo '</table>';
						echo "<h2 class='title'>".$moduleCatNameDict[$row["moduleCatId"]]."</h2>";
					 	echo "<table class='table table-hover table-bordered'>
							
							<tr>
							<th class='col-md-3'>S. No.</th>                   
							<th class='col-md-6'>Module Name</th>  
							
							<th class='col-md-3'><p>Action<small>
							<input type='checkbox' onclick=checkPermission(".$row["moduleCatId"].")  /> Check/Uncheck All
							</th>	
							</tr>";
				}
		   }
		   $moduleCat = $row["moduleCatId"];
		   if($kolor%2==0)
					$class="bgcolor='#ffffff'";
		   else
					$class="bgcolor='#fff'"; 
					 	
 	?>
 
    <tr <?php print $class?>>
    <td><?php print $kolor++;?>.</td>
	<td><?php echo stripslashes($row["Module"]);?></td>	
    <td>
    <input type="checkbox" class="perCheck<?php echo $row["moduleCatId"]; ?>" value="<?php echo $row["MId"];?>" name="list[]" id="list" />
    </td>
    </tr>
    <?php
		}
}
else
	echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
	?> 
    <form method="post">
    <table>
    <tr>
    <td></td>
    <td colspan="3"><input type="submit" name="save" id="save"  value="Submit" class="btn btn-primary btn-sm" /></td>
    <td></td>
    </tr>
    </table><br />
    </form>   

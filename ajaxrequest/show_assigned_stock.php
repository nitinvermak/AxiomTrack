<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']);
$model = mysql_real_escape_string($_POST['modelname']);
error_reporting(0);

$linkSQL = "select * from tbl_device_master as A 
			inner join tbl_device_assign_branch as B 
			on  A.id = B.device_id 
			where A.status='0' 
			and technician_assign_status = '0'";
/*echo $linkSQL;*/
if ( ($branch_id != 0) or ( $model != 0) )
{
	$linkSQL  = $linkSQL." And ";	
	/*echo $linkSQL;*/	
}
$counter = 0;
if ( $branch_id != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." B.branch_id = '$branch_id' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $model != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." A.device_name = '$model' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table id="example1" class="table table-striped table-bordered" cellspacing="0" width="100%">  ';
?>		
				  <thead>
                  <tr>
	              <th><small>S. No.</small></th>                        
	              <th><small>Device Model</small></th>  
	              <th><small>Device Id</small></th>
	              <th><small>IMEI NO</small></th>  
	              <th><small>Status</small></th>
                  <th><small>Assign Branch</small></th>
                  <th><small>Date of Assign </small></th>
				  <th><small>Branch Assign by</small></th>
	              <th><small>Actions</small>                 
	              <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                  &nbsp;&nbsp;
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>      
                  </th>   
                  </tr>  
                  </thead> 
				  <?php
	  		       $kolor = 1;
	  				while ($row = mysql_fetch_array($stockArr))
  					{
 		   				if($row["assignstatus"]==0)
							{
								$stock ='In Stock';
							}
						if($row["assignstatus"]==1)
							{
								$stock = 'Assigned';
							}
 						if($kolor%2==0)
							$class="bgcolor='#ffffff'";
						else
							$class="bgcolor='#fff'";
  				 ?>
                 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
				 <td><small><?php echo getdevicename(stripslashes($row["device_name"]));?></small>
                 <input type="hidden" name="devic_model_id" value="<?php echo stripslashes($row["device_name"]);?>" /></td>
                 <td><small><?php echo stripslashes($row["id"]);?></small></td>	
				 <td><small><?php echo stripslashes($row["imei_no"]);?></small></td>                           	
				 <td><small><span class="label label-success"><?php echo stripslashes($stock);?></span></small></td>	
                 <td><small><?php echo getBranch(stripslashes($row["branch_id"]));?></small></td> 
                 <td><small><?php echo stripslashes($row["assigned_date"]);?></small></td>  
				 <td><small><?php echo gettelecallername(stripslashes($row["assign_by"]));?></small></td>  
                 <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                 </tr>
				 <?php }
				}
    			else
   		 			echo "<h3 style='color:red;'>No records found!</h3><br><br>";
				?> 
                </table> 
                <form method="post">
                <table>
                <tr>
              
                <td colspan="3"><input type="submit" name="remove" class="btn btn-danger btn-sm" value="Remove" onClick="return val();" id="submit" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>   
                
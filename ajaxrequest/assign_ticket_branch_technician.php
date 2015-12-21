<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
/*echo $branch_id;*/
if ($branch_id == 0)
{
	$linkSQL = "SELECT A.ticket_id as tId, C.Company_Name as CompanyName, A.description as description, 
				C.Mobile as mobile, F.category as product, 
				E.rqsttype as requestType, A.createddate as cDate, 
				B.assign_by as assignBy, A.appointment_date as appiontmentDate 
				FROM tblticket as A 
				INNER JOIN tbl_ticket_assign_branch as B 
				ON A.ticket_id = B.ticket_id 
				INNER JOIN tblcallingdata as C 
				On A.organization_id = C.id 
				INNER JOIN tblrqsttype as E 
				ON A.rqst_type = E.id 
				INNER JOIN tblcallingcategory as F 
				ON A.product = F.id
				Where B.branch_confirmation_status = '1' 
				and B.technician_assign_status = '0'";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
		if ( $authorized_branches != '0'){
			$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
		}
//echo $linkSQL;
}
else
	$linkSQL = "SELECT A.ticket_id as tId, C.Company_Name as CompanyName, A.description as description,
				C.Mobile as mobile, F.category as product, 
				E.rqsttype as requestType, A.createddate as cDate, 
				B.assign_by as assignBy, A.appointment_date as appiontmentDate 
				FROM tblticket as A 
				INNER JOIN tbl_ticket_assign_branch as B 
				ON A.ticket_id = B.ticket_id 
				INNER JOIN tblcallingdata as C 
				On A.organization_id = C.id 
				INNER JOIN tblrqsttype as E 
				ON A.rqst_type = E.id 
				INNER JOIN tblcallingcategory as F 
				ON A.product = F.id
				WHERE B.branch_confirmation_status = '1' 
				and B.technician_assign_status = '0' 
				and B.branch_id = '{$branch_id}'";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
		if ( $authorized_branches != '0'){
			$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
		}
 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-hover table-bordered ">  ';
?>		
                 
    	          <tr>
                  <th><small>S. No.</small></th>    
                  <th><small>Ticket Id</small></th> 
                  <th><small>Organization Name</small></th> 
                  <th><small>Product</small></th>
                  <th><small>Request Type</small></th> 
                  <th><small>Created</small></th> 
                  <th><small>Appointment Date Time</small></th>              
                  <th><small>Actions
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>             </th>   
                  </tr>    
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 		   if($kolor%2==0)
				$class="bgcolor='#ffffff'";
		   else
				$class="bgcolor='#fff'";
  	
 	?>
       			 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small>
                 <?php echo stripslashes($row["tId"]);?>
                 <input type="hidden" name="ticketId" id="ticketId" value="<?php echo stripslashes($row["tId"]);?>">
                 </small></td>
				 <td><small>
				 <?php echo stripslashes($row["CompanyName"]);?>
				 <input type="hidden" name="companyName" id="companyName" value="<?php echo stripslashes($row["CompanyName"]);?>">
				 </small></td>
				 <td><small><?php echo stripslashes($row["product"]);?></small></td>
                 <td><small>
                 <?php echo stripslashes($row["requestType"]);?>
                 <input type="hidden" name="requestType" id="requestType" value="<?php echo stripslashes($row["requestType"]);?>">
                 <input type="hidden" name="organizationContact" id="organizationContact" value="<?php echo stripslashes($row["mobile"]);?>">
                  <input type="hidden" name="description" id="description" value="<?php echo stripslashes($row["description"]);?>">
                 </small></td>
				 <td><small><?php echo stripslashes($row["cDate"]);?></small></td>
                 <td><small><?php echo stripslashes($row["appiontmentDate"]);?></small></td>
                 <td><small><input type='checkbox' name='linkID[]' value='<?php echo $row["tId"]; ?>'></small> </td>
                 </tr>
	<?php 
	      }

 

	}
    else
   		 echo "<h3 style='color:red'>No records found!</h3><br><br>";
?> 
          				<form method="post">
                          <table>
                          <tr>
                          <td colspan="3"><input type="submit" name="submit" class="btn btn-primary btn-sm" onClick="return val();" value="Submit" id="submit" /> </td>
                          <td></td>
                          </tr>
                          </table>
                   	    </form>   
                
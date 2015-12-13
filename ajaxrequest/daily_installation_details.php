<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$depositDate = mysql_real_escape_string($_POST['depositDateFrom']);
$depositDateTo = mysql_real_escape_string($_POST['depositDateTo']);
$branch = mysql_real_escape_string($_POST['branch']);
$executive = mysql_real_escape_string($_POST['executive']);
error_reporting(0);
$linkSQL = "SELECT A.techinician_name as technician, A.id as id, A.ticketId as ticketId, A.mobile_no as mobile, 
			A.device_id as deviceId, A.imei_no as IMEI, A.model_name as model, A.vehicle_no as vehicle_no, 
			A.installation_date as installdate, C.Company_Name as CompanyName 
			FROM tempvehicledata as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customer_Id = B.cust_id
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id
			INNER JOIN tbluser as D 
			ON A.techinician_name = D.id where A.configStatus = 'N'";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $depositDate != 0) or ( $depositDateTo != 0) or ($branch != 0) )
{
	$linkSQL  = $linkSQL." And";		
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.techinician_name = '$executive'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $depositDate !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." DATE(A.installation_date) BETWEEN '$depositDate' AND '$depositDateTo' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." D.branch_id ='$branch'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}					 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th><small>S. No.</small></th>     
              	<th><small>Ticket Id</small></th>
              	<th><small>Company</small></th> 
                <th><small>Vehicle No</small></th> 
                <th><small>Mobile No</small></th> 
              	<th><small>Device Id</small></th>   
                <th><small>Model</small></th> 
                <th><small>Tehnician</small></th>
                 <th><small>Installation Date</small></th> 
                <th><small>Action <br />             
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                Check All</a>
      			&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">
                Uncheck All</a></small>
                </th>                 
              	</tr>    
	
				  	<?php
					$kolor=1;
					if(isset($_GET['page']) and is_null($_GET['page']))
					{ 
					$kolor = 1;
					}
					elseif(isset($_GET['page']) and $_GET['page']==1)
					{ 
					$kolor = 1;
					}
					elseif(isset($_GET['page']) and $_GET['page']>1)
					{
					$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
					}
					
						if(mysql_num_rows($stockArr)>0)
						{
					  while ($row = mysql_fetch_array($stockArr))
					  {
					 
					  if($kolor%2==0)
						$class="bgcolor='#ffffff'";
						else
						$class="bgcolor='#fff'";
						
					 ?>
               <tr <?php print $class?>>
	 			<td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["ticketId"]);?></small></td>
	 			<td><small><?php echo stripcslashes($row['CompanyName']);?></small></td>
                <td><small><?php echo stripcslashes($row['vehicle_no']);?></small></td>
                <td><small><?php echo stripcslashes($row['mobile']);?></small></td>
                <td><small><?php echo stripcslashes($row['deviceId']); ?></small></td>
                <td><small><?php echo stripcslashes($row['model']); ?></small></td>
                <td><small><?php echo stripcslashes($row['technician']); ?></small></td>
                <td><small><?php echo stripcslashes($row['installdate']); ?></small></td>
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<h3><font color=red>No records found !</font></h3><br><br>";
			}
?>
 <form method="post">
                <table>
                <tr>
                <td colspan="3"><input type="submit" name="depositBank" value="Deposit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>  
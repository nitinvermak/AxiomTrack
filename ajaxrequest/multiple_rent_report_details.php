<?php
include("../includes/config.inc.php"); 
/*include("includes/crosssite.inc.php"); */
$company = mysql_real_escape_string($_POST['company1']);
$customerType = mysql_real_escape_string($_POST['customerType1']);
$frq = mysql_real_escape_string($_POST['frq1']);
error_reporting(0);
$linkSQL = "SELECT C.cust_id as custId, C.customer_type as customerType, C.confirmation_date as cnfirmationDate, 
			C.callingdata_id as callingDataId, B.RentalFrequencyId as freq,count(*) as novehicle, Sum(D.plan_rate) as deviceRentAmt
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_gps_vehicle_payment_master as B 
			ON A.id = B.Vehicle_id
			INNER JOIN tbl_customer_master as C 
			ON B.cust_id = C.cust_id
			INNER JOIN tblplan as D
			ON B.device_rent_amt = D.id
			WHERE A.activeStatus = 'Y'
			GROUP BY C.callingdata_id";
		echo $linkSQ;
if ( ($company != 0) or ($customerType != 0) or ($frq != 0) ){
	$linkSQL  = $linkSQL." And ";	
}

$counter = 0;

if ( $company != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." C.cust_id = '$company' ";
	$counter+=1;
	echo $linkSQ;
}	
if ( $customerType != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." C.customer_type  = '$customerType' ";
	$counter+=1;
	echo $linkSQ;
}
if ( $frq != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  = $linkSQL." B.RentalFrequencyId  = '$frq' ";
	$counter+=1;
	echo $linkSQ;
}		
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<div class="col-md-12">
			  	<div class="download pull-right">
					<a href="#" id ="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
				</div>
			  </div>
			
			  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Cust Id.</small></th> 
                <th><small>Customer Type.</small></th>  
                <th><small>Customer Activation Date</small></th> 
              	<th><small>Company</small></th> 
                <th><small>Frq.</small></th>
                <th><small>No. of Vehicle</small></th> 
                <th><small>Amount</small></th>                 
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
                <td><small><?php echo $row["custId"];?></small></td>
                <td><small><?php echo getCustomerType($row["customerType"]); ?></small></td>
                <td><small><?php echo $row["cnfirmationDate"]; ?></small></td>
                <td><small><?php echo getOraganization($row["callingDataId"]); ?></small></td>
                <td><small><?php echo getFrequency($row["freq"]); ?></small></td>
                <td><small><?php echo $row["novehicle"]; ?></small></td>
                <td><small><?php echo $row["deviceRentAmt"]; ?></small></td>
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
			}
?>

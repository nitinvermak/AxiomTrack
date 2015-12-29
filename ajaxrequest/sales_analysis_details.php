<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$dateFrom = mysql_real_escape_string($_POST['dateFrom']);
$dateTo = mysql_real_escape_string($_POST['dateTo']);
$customerType = mysql_real_escape_string($_POST['customerType']);
$leadGenBy = mysql_real_escape_string($_POST['leadGenBy']);
$installedBy = mysql_real_escape_string($_POST['installedBy']);
error_reporting(0);

	$linkSQL = "SELECT A.callingdata_id as companyId, C.vehicle_no as vehicleNo, 
				A.customer_type as custType, C.installation_date as installationDate, 
				B.service_branchId as serviceBranchId, A.LeadGenBranchId as leadGenId, 
				C.techinician_name as installedBy, A.np_device_amt as saleAmt, 
				D.price as devicePrice, D.company_id as dCompany 
				FROM tbl_customer_master as A 
				INNER JOIN tbl_assign_customer_branch as B 
				ON A.cust_id = B.cust_id
				INNER JOIN tbl_gps_vehicle_master as C 
				ON B.cust_id = C.customer_Id
				INNER JOIN tbl_device_master as D 
				ON C.device_id = D.id
				INNER JOIN tbldevicecompany as E 
				ON D.company_id = E.id";
if( ($dateFrom != 0) or ( $dateTo != 0) or ( $customerType != 0) or ( $leadGenBy != 0) or ( $installedBy != 0) )
{
	$linkSQL  = $linkSQL." WHERE ";
}
$counter = 0;
if( $dateFrom != 0 and $dateTo != 0 )
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL =$linkSQL."  DATE(C.installation_date) BETWEEN '$dateFrom' AND '$dateTo' ";
		$counter+=1;
	/*	echo $linkSQL; */
	}
if($customerType != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.customer_type = '$customerType' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($leadGenBy != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.LeadGenBranchId = '$leadGenBy' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($installedBy != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." C.techinician_name = '$installedBy' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<div class="col-md-12">
			  	<div class="download pull-right">
					<a href="#" id ="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
				</div>
			  </div>
			  <table border="0" id="tblExport" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Company Name</small></th> 
                <th><small>Vehicle No.</small></th>  
              	<th><small>Customer Type</small></th> 
              	<th><small>Installation Date</small></th>  
                <th><small>Device Company </small></th>  
              	<th><small>Service Branch</small></th>
              	<th><small>Lead Gen. By</small></th>   
              	<th><small>Installed By</small></th>    
              	<th><small>Purchase Amt.</small></th> 
              	<th><small>Sale Amt</small></th>                           
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
                        <td><small><?php echo getOraganization(stripslashes($row["companyId"]));?></small></td>
                        <td><small><?php echo stripcslashes($row["vehicleNo"]);?></small></td>
                        <td><small><?php echo getCustomerType(stripslashes($row["custType"]));?></small></td>
                        <td><small><?php echo stripslashes($row["installationDate"]);?></small></td>
                        <td><small><?php echo getdcompany(stripslashes($row["dCompany"]));?></small></td>
                        <td><small><?php echo getBranch(stripcslashes($row["serviceBranchId"]));?></small></td>
                        <td><small><?php echo gettelecallername(stripcslashes($row["leadGenId"]));?></small></td>
                        <td><small><?php echo gettelecallername(stripcslashes($row["installedBy"]));?></small></td>
                        <td><small><?php echo stripcslashes($row["devicePrice"]); ?></small></td>
                        <td><small><?php echo getPlanAmt(stripcslashes($row["saleAmt"])); ?></small></td>
                        </tr> 

                    <?php 
                    }
                    echo $pagerstring;
                
                }
                else
                    echo "<h3><font color=red>No records found !</h3></font>";
			}
?>
              
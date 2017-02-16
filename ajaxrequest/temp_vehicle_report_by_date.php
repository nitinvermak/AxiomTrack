<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$date = $_GET['date'];
$dateto = $_GET['dateto'];
$company = $_GET['company'];
$reffered = $_GET['reffered'];
$technician = $_GET['technician'];
/*echo $company;*/
error_reporting(0);
	$linkSQL = "SELECT A.customer_Id as CustId, C.Company_Name as C_name, B.callingdata_id, A.vehicle_no as V_no, 
				A.mobile_no as Mob,A.device_id as D_id, A.model_name as model, A.installation_date as I_date, 
				B.telecaller_id as TelecallerName, A.techinician_name as T_id, A.ticketId as ticketId, A.imei_no as Imei,
				A.id as Id, A.battery as battery, A.ignition as ignition, A.location as location
				FROM tempVehicleData as A 
				INNER JOIN tbl_customer_master as B 
				ON A.customer_Id = B.cust_id
				INNER JOIN tblcallingdata as C 
				ON B.callingdata_id = C.id";
echo $linkSQL;
if ( ($company != 0) or ( $date !='' and $dateto !='') or ($reffered != 0) or ($technician != 0) )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($company != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.callingdata_id = '$company'" ;
		$counter+=1;
		echo $linkSQL;
	}
if ( $date !='' and $dateto !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(A.installation_date) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	echo $linkSQL;
}
if($reffered != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.telecaller_id = '$reffered'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($technician != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.techinician_name = '$technician'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th ><small>S.&nbsp;No.</small></th>   
				<th><small>Ticket Id </small></th>
	  			<th><small>Customer&nbsp;ID</small></th>  
              	<th><small>Company Name</small></th>
                <th><small>Vehicle No</small></th>   
              	<th><small>Mobile No</small></th>  
              	<th><small>Device ID</small></th>
				<th><small>IMEI&nbsp;No.</small></th>
              	<th><small>Model</small></th>   
              	<th><small>Date&nbsp;of&nbsp;Installation</small></th> 
				<th><small>Battery</small></th>
				<th><small>Ignition</small></th>
				<th><small>Location</small></th>
              	<th><small>Installed By</small></th> 
				<th><small>Acction</small></th>
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
				<td><small><?php echo stripcslashes($row["ticketId"]);?></small></td>
                <td><small><?php echo stripslashes($row["CustId"]);?></small></td>
                <td><small><?php echo stripslashes($row["C_name"]);?></small></td>
                <td><small><?php echo stripslashes($row["V_no"]);?></small></td>
                <td><small><?php echo getMobile(stripslashes($row["Mob"]));?></small></td>
                <td><small><?php echo stripslashes($row["D_id"]);?></small></td>
				<td><small><?php echo stripcslashes($row["Imei"]);?></small></td>
                <td><small><?php echo stripslashes($row["model"]);?></small></td>
                <td><small><?php echo stripslashes($row["I_date"]);?></small></td>
				<td><small>
				<?php 
				if($row["battery"] == N)
				{
					echo "<center><span class = 'glyphicon glyphicon-flash' style ='color:red; font-size:16px; font-weight:bold;'></span></center>";
				}
				else if($row["battery"] == Y)
				{
					echo "<center><span class = 'glyphicon glyphicon-flash' style ='color:green; font-size:16px; font-weight:bold;'></span></center>";
				}
				?>
				</small></td>
				<td><small>
				<?php 
				if($row["ignition"] == N)
				{
					echo "<center><span class = 'glyphicon glyphicon-off' style ='color:red; font-size:16px; font-weight:bold;'></span></center>";
				}
				else if($row["ignition"] == Y)
				{
					echo "<center><span class = 'glyphicon glyphicon-off' style ='color:green; font-size:16px; font-weight:bold;'></span></center>";
				}
				?>				
				</small></td>
				<td><small>
				<?php 
				if($row["location"] == N)
				{
					echo "<center><span class = 'glyphicon glyphicon-map-marker' style ='color:red; font-size:16px; font-weight:bold;'></span></center>";
				}
				else if($row["location"] == Y)
				{
					echo "<center><span class = 'glyphicon glyphicon-map-marker' style ='color:green; font-size:16px; font-weight:bold;'></span></center>";
				}
				?>
				</small></td>
                <td><small><?php echo gettelecallername(stripcslashes($row["T_id"]));?></small></td>
				<td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" onclick="getModal(<?php echo stripcslashes($row["Id"]);?>);" 
				data-target=".bs-example-modal-sm">
					  Configure  
					</button></td>
                </tr> 
                <?php 
                		}
                echo $pagerstring;
                
                  }
                   
			}
			else
                   echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
                ?>
              
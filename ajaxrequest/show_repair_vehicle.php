<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$company_name = $_GET['company'];
/*$vehicle_no = $_GET['vehicle_no'];
echo $vehicle_no.'<br>'; 
echo $company_name;*/
error_reporting(0);
$linkSQL = "SELECT A.id, A.mobile_no, A.device_id, A.imei_no, A.techinician_name, B.callingdata_id, C.Company_Name as C_name, A.vehicle_no as V_no, A.vehicle_odometer as v_odometer FROM tbl_gps_vehicle_master as A INNER JOIN tbl_customer_master as B ON A.customer_Id = B.cust_id INNER JOIN tblcallingdata as C ON B.callingdata_id = C.id";
if ( ($company_name != 0) )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($company_name != '')
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.callingdata_id = '$company_name'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}

$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th>S. No.</th>     
              	<th>Organization Name</th>
              	<th>Vehicle No</th>
                <th>Mobile</th>
                <th>Device Id</th>
                <th>IMEI</th> 
              	<th>Technician</th>    
              	<th>Action              
              	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
              	&nbsp;&nbsp;
              	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>           </th>   
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
      			 <td><?php print $kolor++;?>.</td>
	  			 <td><?php echo stripslashes($row["C_name"]);?></td>
      			 <td><?php echo stripslashes($row["V_no"]);?></td>
                 <td><button type="button" class="btn btn-primary btn-sm open" data-toggle="modal" data-target="#myModal"><?php echo stripslashes($row["mobile_no"]);?></button></td>
                 <td><?php echo stripslashes($row["device_id"]);?></td>
                 <td><?php echo stripslashes($row["imei_no"]);?></td>
      			 <td><?php echo stripslashes($row["techinician_name"]);?></td>
	  			 <td><?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="add_gps_vehicle.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="change_password.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?>		</td>
      			</tr>
                <?php 
                		}
                echo $pagerstring;
                
                  }
                   
			}
			else
                   echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
                ?>
              
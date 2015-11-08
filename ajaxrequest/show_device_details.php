<?php
include("../includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
error_reporting(0);
$dateFrom = mysql_real_escape_string($_POST['dateFrom']);
$dateTo = mysql_real_escape_string($_POST['dateTo']);
$statusDevice = mysql_real_escape_string($_POST['statusDevice']);
if($statusDevice == "")
	{
		$linkSQL = "SELECT assignstatus, status, date_of_purchase, COUNT(id) as noofdevice FROM tbl_device_master WHERE 	        			Date(date_of_purchase) BETWEEN '$dateFrom' and '$dateTo' GROUP BY date_of_purchase";
	}
else
	{
		$linkSQL = "SELECT assignstatus, status, date_of_purchase, COUNT(id) as noofdevice FROM tbl_device_master WHERE 	        			status='$statusDevice' and Date(date_of_purchase) BETWEEN '$dateFrom' and '$dateTo' GROUP BY date_of_purchase";
	}
/*echo $linkSQL;*/
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>
				<tr>
	  			<th class="col-xs-1"><small>S.&nbsp;No.</small></th>     
	  			<th class="col-xs-1"><small>Date</small></th>  
              	<th class="col-xs-2"><small>No of Vehicle</small></th>
                <th class="col-xs-1"><small>Stock</small></th>   
              	<th class="col-xs-1"><small>Instaled</small></th>                            
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
                <td><small><?php echo stripslashes($row["date_of_purchase"]);?></small></td>
                <td><small><?php echo stripslashes($row["noofdevice"]);?></small></td>
                <td><small><?php if($row["assignstatus"] == 1){ echo "Assigned"; } else { echo "Head Office";}?></small></td>
                <td><small><?php if($row["status"] == 1) { echo "Installed"; } else { echo "InStock"; }?></small></td>
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
              
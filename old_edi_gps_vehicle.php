<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if(isset($_POST['submit']))
	{
		$company = mysql_real_escape_string($_POST['company']);
	}
//change mobile allocation
if(isset($_POST['save']))
	{
		$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
		$branch = mysql_real_escape_string($_POST['branch']);
		$technician = mysql_real_escape_string($_POST['technician']);
		/*echo $mobileNo.'<br>'.$branch ;*/
		$updateSimMaster = "Update tblsim set status_id='0' where id ='$mobileNo'";
		$result = mysql_query($updateSimMaster);
		/*echo $updateSimMaster;*/
		$updateBranch = "Update tbl_sim_branch_assign set branch_id = '$branch'  where sim_id ='$mobileNo'";
		$result = mysql_query($updateBranch);
		/*echo $updateBranch;*/
		$updateAssignTechnician = "Update tbl_sim_technician_assign set technician_id = '$technician' where sim_id = '$mobileNo'";
		$result = mysql_query($updateAssignTechnician);
		/*echo $updateAssignTechnician;*/
		$removeMobile = "UPDATE `tbl_gps_vehicle_master` SET mobile_no='0'  WHERE mobile_no='$mobileNo'";
		$result = mysql_query($removeMobile);
	}
//end
//change device allocation
if(isset($_POST['savedevice']))
	{
		$deviceId = mysql_real_escape_string($_POST['deviceId']);
		$branch = mysql_real_escape_string($_POST['branch']);
		$technician = mysql_real_escape_string($_POST['technician']);
		$UpdateDevice = "Update tbl_device_master set status='0' where id ='$deviceId'";
		$result = mysql_query($UpdateDevice);
		/*echo $updateSimMaster;*/
		$updateBranch = "Update tbl_device_assign_branch set branch_id = '$branch'  where device_id ='$deviceId'";
		$result = mysql_query($updateBranch);
		/*echo $updateBranch;*/
		$updateAssignTechnician = "Update tbl_device_assign_technician set technician_id = '$technician' where device_id = '$deviceId'";
		$result = mysql_query($updateAssignTechnician);
		/*echo $updateAssignTechnician;*/
		$removeMobile = "UPDATE `tbl_gps_vehicle_master` SET device_id='0'  WHERE device_id='$deviceId'";
		$result = mysql_query($removeMobile);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
	<?php include_once('includes/header.php');?>
	<!--end-->
    <!--open of the content-->
	<div class="row" id="content">
        <div class="col-md-12 demo">
            <h3>Edit/Repair Vehicle Details</h3>
            <hr>
        </div>
   
        <form name='fullform' class="form-horizontal"  method='post' >
        <div class="col-md-12 table-responsive">
         <table class="form-field" width="100%">
         <tr>
         <td width="11%">Company Name</td>
         <td width="17%">
             <select name="company" id="company" class="form-control drop_down-sm">
               <option value="0">Select Company</option>
                    <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
                                                 FROM tbl_customer_master as A 
                                                 INNER JOIN tblcallingdata as B
                                                 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                           while($resultCountry=mysql_fetch_assoc($Country))
                            {
                     ?>
               <option value="<?php echo $resultCountry['id']; ?>"> <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                        <?php } ?>
             </select>
            
         </td>
         <td width="8%"><input type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary btn-sm"/>
         </td>
         <td width="19%"></td>
         <td width="39%">&nbsp;</td>
         <td width="2%">&nbsp;</td>
         <td width="2%">&nbsp;</td>
         <td width="2%"></td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         </tr>
         </table>
         </div>
	
  
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
		<?php
        $where='';
        $linkSQL="";			
        if(!isset($linkSQL) or $linkSQL =='')		
        	$linkSQL = "SELECT A.id, A.mobile_no, A.device_id, A.imei_no, A.techinician_name, B.callingdata_id, C.Company_Name as C_name, A.vehicle_no as V_no, A.vehicle_odometer as v_odometer 
						FROM tbl_gps_vehicle_master as A 
						INNER JOIN tbl_customer_master as B 
						ON A.customer_Id = B.cust_id 
						INNER JOIN tblcallingdata as C 
						ON B.callingdata_id = C.id WHERE B.callingdata_id = '$company'";
            $oRS = mysql_query($linkSQL); 
         ?>
         <form name='fullform' method='post' onSubmit="return confirmdelete()">
         <input type="hidden" name="token" value="<?php echo $token; ?>" />
         <input type='hidden' name='pagename' value='users'>            	        
         <?php if($_SESSION['sess_msg']!=''){?>
         	<center>
            	<div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></div>
            </center>
         <?php } ?>
         <table class="table table-hover table-bordered " >
         <tr>
         <th><small>S. No.</small></th>     
         <th><small>Organization Name</small></th>
         <th><small>Vehicle No</small></th>
         <th><small>Mobile</small></th>
         <th><small>Device Id</small></th>
         <th><small>IMEI</small></th> 
         <th><small>Technician</small></th>    
         <th><small>Action              
         <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
         &nbsp;&nbsp;
         <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>   </th>   
         </tr>   
         <?php
		 $kolor=1;
		 if(mysql_num_rows($oRS)>0)
		 	{
				while ($row = mysql_fetch_array($oRS))
					{
						if($kolor%2==0)
							$class="bgcolor='#ffffff'";
						else
							$class="bgcolor='#fff'";
		?> 
        <tr <?php print $class?>>
      	<td><small><?php print $kolor++;?>.</small></td>
	  	<td><small><?php echo stripslashes($row["C_name"]);?></small></td>
      	<td><small><?php echo stripslashes($row["V_no"]);?></small></td>
        <td><small>
        	<a class="open" id="mobile_no" data-toggle="modal" data-target="<?php echo '#a'.$row["mobile_no"];?>" >
			<?php echo getMobile(stripslashes($row["mobile_no"]));?> 
            <input type="hidden" name="mobile_no"  id="mobile_no" value="<?php echo getMobile(stripslashes($row["mobile_no"]));?>">			 			</a>
            </small> 
            <!--Start modal popup-->
            <div class="modal fade bs-example-modal-sm"  id="<?php echo 'a'.$row["mobile_no"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            	<div class="modal-dialog" role="document">
                	<div class="modal-content">
                    	<div class="modal-header">
                            <button type="button" id="modelhide" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        	<h5 class="modal-title" id="myModalLabel">Re-Allocate Mobile Number</h5>
                      	</div>
                      <form method="post">
                      <div class="modal-body">
                      	<p>Mobile*<br>
                        	<select name="mobileNo" id="mobileNo" class="form-control drop_down">
                            	<option value="<?php echo $row["mobile_no"];?>" readonly><?php echo getMobile($row["mobile_no"]);?></option>
                            </select>
                        </p>
                        <p>Branch<br>
                        	<select name="branch" id="branch" class="form-control drop_down">
                                  <option label="" value="" selected="selected">Select Branch</option>
                                  <?php $Country=mysql_query("select * from tblbranch");
                                        while($resultCountry=mysql_fetch_assoc($Country)){
                                  ?>
                                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                                  <?php } ?>
                  			</select>
                        </p>
						<p>Technician<br>
                          <select name="technician" id="technician" class="form-control drop_down">
                                                     <option value="">Select Techician</option>
                                                     <?php $Country=mysql_query("select * from tbluser where User_Category=5 or User_Category=8");
                                                           while($resultCountry=mysql_fetch_assoc($Country)){
                                                     ?>
                                                     <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                                                     <?php } ?>
                          </select>
						</p>
                      </div>
                      <div class="modal-footer">
                        <input type="submit" name="save" id="save" value="Save" class="btn btn-danger btn-sm"/>
                         <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                      </div>
                      </form>
                    </div>
                  </div>
        	 </div>
              <!--end modal popup-->
              
        </td>
        <td><small>
        	<a class="open"  id="deviceId" data-toggle="modal" data-target="<?php echo '#b'.$row["device_id"];?>">
			<?php echo stripslashes($row["device_id"]);?></a>
            <input type="hidden" name="deviceId"  id="deviceId" value="<?php echo stripslashes($row["device_id"]);?>"></small>
            <!--Start modal popup-->
            <div class="modal fade bs-example-modal-sm"  id="<?php echo 'b'.$row["device_id"];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            	<div class="modal-dialog" role="document">
                	<div class="modal-content">
                    	<div class="modal-header">
                            <button type="button" id="modelhide" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        	<h5 class="modal-title" id="myModalLabel">Re-Allocate Mobile Number</h5>
                      	</div>
                      <form method="post">
                      <div class="modal-body">
                      	<p>Device Id*<br>
                            <input type="text" name="deviceId" id="deviceId" class="form-control text_box" value="<?php echo $row["device_id"];?>" readonly></p>
                        <p>Branch<br>
                        	<select name="branch" id="branch" class="form-control drop_down">
                                  <option label="" value="" selected="selected">Select Branch</option>
                                  <?php $Country=mysql_query("select * from tblbranch");
                                        while($resultCountry=mysql_fetch_assoc($Country)){
                                  ?>
                                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                                  <?php } ?>
                  			</select>
                        </p>
						<p>Technician<br>
                          <select name="technician" id="technician" class="form-control drop_down">
                                                     <option value="">Select Techician</option>
                                                     <?php $Country=mysql_query("select * from tbluser where User_Category=5 or User_Category=8");
                                                           while($resultCountry=mysql_fetch_assoc($Country)){
                                                     ?>
                                                     <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                                                     <?php } ?>
                          </select>
						</p>
                      </div>
                          <div class="modal-footer">
                            <input type="submit" name="savedevice" id="savedevice" value="Save" class="btn btn-danger btn-sm"/>
                             <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                          </div>
                      </form>
                    </div>
                  </div>
        	 </div>
              <!--end modal popup-->
      	</td>
        <td><small><?php echo stripslashes($row["imei_no"]);?></small></td>
      	<td><small><?php echo stripslashes($row["techinician_name"]);?></small></td>
	  	<td><small><?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="1_old_29_15_add_gps_vehicle.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="change_password.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></small></td>
      	</tr>
        <?php }
		}
    else
    	echo "<tr><td colspan=8 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
		?> 
         </form>
          </table>
      </div>

</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
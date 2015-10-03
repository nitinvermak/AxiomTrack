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

 /*foreach ($_POST as $key => $value) {
      
        echo $key."<br />";
		}*/

  if (!empty($_POST))
	{
	
	$userid=$_SESSION['user_id'];
		if ($_REQUEST['sim']!="")
		{
	//	echo $_REQUEST['first_name'];
	//	die;
		$provider_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['provider']));
		$sim_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['sim']));
		$mobile_no=htmlspecialchars(mysql_real_escape_string($_REQUEST['mobile']));
		$date_of_purchase=htmlspecialchars(mysql_real_escape_string($_REQUEST['date']));
		$state_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['state1']));
		$plan=htmlspecialchars(mysql_real_escape_string($_REQUEST['plan1']));
		$sql="insert into tblsim set company_id='$provider_name', sim_no='$sim_name', mobile_no='$mobile_no', date_of_purchase='$date_of_purchase', state_id='$state_name', plan_categoryid='$plan'";
		echo $sql;
		//die;
		insertcontact($sql);
		?>
                <script language="javascript">
				alert("Data Added Successfully!");
				</script>
                <?php
				header("location: manage_sim.php?token=".$token);
				
		}
		else
		{
		$provider_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['provider2']));
		$date_of_purchase =htmlspecialchars(mysql_real_escape_string($_REQUEST['date2']));		
		$state_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['state3']));
		$plan=htmlspecialchars(mysql_real_escape_string($_REQUEST['plan2']));
		$filename=upload_file("contactfile",SITE_FS_PATH."/upload/","");
		

		
		require_once 'excelreader/excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader(SITE_FS_PATH."/upload/".$filename);
		
		//echo $data->sheets[0]['numRows'];
		//die;
		 $chkdata=0;
		 $msgvalue="";
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) 
			{
				
				
					
					if($j==1)
					{
				
						$first_name=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
						if (trim($first_name)=="" )
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Sim No. Missing<br />";
						 }
						
					}
					if($j==2)
					{
					//echo $data->sheets[0]['cells'][$i][$j];
					//die;
						$last_name=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
						if (trim($last_name)=="")
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Mobile No. Missing<br />";
						 }
					}
					
			}
		$datasource=htmlspecialchars(mysql_real_escape_string($_REQUEST['datasource1']));
		if($chkdata==0)
		{
					$sql="insert into tblsim set company_id='$provider_name', sim_no='$first_name', mobile_no='$last_name', date_of_purchase='$date_of_purchase', state_id='$state_name', plan_categoryid='$plan'";
			
		//	echo $sql;
		//	die;
			insertcontact($sql);	
			}
			$chkdata=0;
		}
			if($msgvalue!="")
			{
				$_SESSION["ERROR_MESSAGE"]=$msgvalue;
				header("location: simupload_message.php?token=".$token);
			
			}
			else
			{
				?>
                <script language="javascript">
				alert("Data Uploaded Successfully!");
				</script>
                <?php
				header("location: manage_sim.php?token=".$token);
			}
		}
 	}
	  	function insertcontact($sql)
		{
	$query=mysql_query($sql);
		}
//$name=htmlspecialchars(mysql_real_escape_string($_REQUEST['name']));
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

<script  src="js/ajax.js"></script>
<script language="javascript" src="js/manage_import_sim.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h1>Import Sim</h1>
        <hr>
    </div>
    <div class="col-md-12">
    <div class="col-md-12 select_form">
    
    	<div class="radio-inline">
              <label>
                <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="singlecontact()" /> Single Sim
              </label>
		</div>
         <div class="radio-inline">
        <label>
                <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="multiplecontact()"/>
                Multiple Sim
              </label>
        </div>
     
    </div>    
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
    	<div class="col-md-4">
        	<div class="form-group">
                <label for="Provider" class="col-sm-2 control-label">Provider*</label>
                <div class="col-sm-10">
                  <select name="provider" id="provider" class="form-control drop_down" onChange="ShowPlans()">
            	  <option value="">Select Provider</option>
            	  <?php $Country=mysql_query("select * from tblserviceprovider");
								 while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
            	  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['State_id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
            	  <?php } ?>
          		  </select>
               </div>
             </div>
        </div>
        
        <div class="col-md-8">
        	<div class="form-group">
                <label for="Plan" class="col-sm-2 control-label">Plan*</label>
                <div class="col-sm-10" id="showPlan">
                  <select name="plan1" id="plan1" class="form-control drop_down">
                  <option value="">Select Plan</option>
                  </select>
               </div>
             </div>
        </div>
        
       <div class="col-md-4">
       	<div class="form-group">
        	<label for="state" class="col-sm-2 control-label">State*</label>
            <div class="col-sm-10">
            	<select name="state1" id="state1" class="form-control drop_down">
                <option value="">Select State</option>
                <?php $Country=mysql_query("select * from tblstate");
					 		     while($resultCountry=mysql_fetch_assoc($Country)){
				?>
              	<option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
              	<?php } ?>
                </select>
            </div>
        </div>
       </div>
       <div class="col-md-8">
       	<div class="form-group">
        	<label for="purchasedate" class="col-sm-2 control-label">Purchase&nbsp;Date*</label>
           	<div class="col-sm-10">
            	<input name="date" id="date" class="form-control text_box" type="text" />
            </div>
        </div>
       </div>
       <div class="col-md-4">
       	<div class="form-group">
        	<label for="simno" class="col-sm-2 control-label">Sim&nbsp;No.*</label>
           	<div class="col-sm-10">
            	<input type="text" name="sim" id="sim" class="form-control text_box" />
            </div>
        </div>
       </div>
        <div class="col-md-8">
       	<div class="form-group">
        	<label for="Mobile" class="col-sm-2 control-label">Mobile&nbsp;No.*</label>
           	<div class="col-sm-10">
            	<input name="mobile" id="mobile" class="form-control text_box" type="text" />
            </div>
        </div>
       </div>
       <div class="col-md-4">
       		<div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Submit" id="submit" class="btn btn-primary" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'" />
                </div>
  			</div> 
       </div>
    </form>
    </div> 
    <!--end single sim  form--> 
    
    <div id="contactUpload"  style="display:none;" class="col-md-12"> <!--open of the multiple sim form-->
    <form name="contact1" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return chkupload(this)">
    	<div class="col-md-5">
         	<div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Provider</label>
                <div class="col-sm-10">
                  <select name="provider2" id="provider2" class="form-control drop_down" onChange="ShowPlans2()">
            	  <option value="">Select Provider</option>
            	  <?php $Country=mysql_query("select * from tblserviceprovider");
						 while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
            	  <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['State_id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
            	  <?php } ?>
          		  </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dateofpurchase" class="col-sm-2 control-label">Purchase<br>Date</label>
                <div class="col-sm-10">
                  <input name="date2" id="date2" class="form-control text_box" type="text" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Upload</label>
                <div class="col-sm-10">
                  <input type="file" id="contactfile" name="contactfile"/>
                </div>
            </div>
       
        </div>
        <div class="col-md-5">
       		
            <div class="form-group">
                <label for="Plan" class="col-sm-2 control-label">Plan</label>
                <div class="col-sm-10" id="showPlan2">
                  <select name="plan2" id="plan2" class="form-control drop_down">
                  <option value="">Select Plan</option>
                  </select>
                </div>
            </div>
            
            
            
             
            
             <div class="form-group">
                <label for="Plan" class="col-sm-2 control-label">State</label>
                <div class="col-sm-10">
                  <select name="state3" id="state3" class="form-control drop_down">
          		  <option value="">Select State</option>
          		  <?php $Country=mysql_query("select * from tblstate");
						 while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($result['state_id']) && $resultCountry['State_id']==$result['state_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
          		  <?php } ?>
        		   </select>
                </div>
            </div> 
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Submit" id="submit" class="btn btn-primary" />
                  <input type="button" value="Download Format" name="download" class="btn btn-primary" onClick="window.location='Samples/sim_import_format.xls'" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='manage_sim.php?token=<?php echo $token ?>'" />
                </div>
  			</div> 
        </div>	
       </form>
    </div> <!--end multiple sim-->
	
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<script src="js/jquery.js"></script>
<script src="js/jquery.datetimepicker.js"></script>
<script>
$('#date').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
$('#date2').datetimepicker({
	/*mask:'9999/19/39 29:59'*/
});
</script>
</html>
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
		if ($_REQUEST['first_name']!="")
		{
	//	echo $_REQUEST['first_name'];
	//	die;
		$first_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['first_name']));
		$last_name=htmlspecialchars(mysql_real_escape_string($_REQUEST['last_name']));
		$company=htmlspecialchars(mysql_real_escape_string($_REQUEST['company']));
		$phone=htmlspecialchars(mysql_real_escape_string($_REQUEST['phone']));
		$mobile=htmlspecialchars(mysql_real_escape_string($_REQUEST['mobile']));
		$email=htmlspecialchars(mysql_real_escape_string($_REQUEST['email']));
		$address=htmlspecialchars(mysql_real_escape_string($_REQUEST['address']));
		$area=htmlspecialchars(mysql_real_escape_string($_REQUEST['area']));
		$city=htmlspecialchars(mysql_real_escape_string($_REQUEST['city']));
		$state=htmlspecialchars(mysql_real_escape_string($_REQUEST['state']));
		$district=htmlspecialchars(mysql_real_escape_string($_REQUEST['district']));
		$country=htmlspecialchars(mysql_real_escape_string($_REQUEST['country']));
		$pincode=htmlspecialchars(mysql_real_escape_string($_REQUEST['pin_code']));
		$datasource=htmlspecialchars(mysql_real_escape_string($_REQUEST['datasource']));
		$sql="insert into tblcallingdata set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company',Phone='$phone',Mobile='$mobile',email='$email',Address='$address',Area='$area',City='$city',State='$state', District_id = '$district',  Country='$country',Pin_code='$pincode',data_source='$datasource',status='A',created=CURDATE(),createdby='$userid'";
		//echo $sql;
		//die;
		insertcontact($sql);
		?>
                <script language="javascript">
				alert("Data Added Successfully!");
				</script>
                <?php
				header("location: managecontacts.php?token=".$token);
				
		}
		else
		{
	//	echo SITE_FS_PATH;
	//	die;
	//	echo $_FILES['contactfile']['name'];
	//die;
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
						if (trim($first_name)=="")
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Fisrt Name Missing<br />";
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
						  $msgvalue=$msgvalue." Row No. ".$i." Last Name Missing<br />";
						 }
					}
					if($j==3)
					{
						$company=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
						if (trim($company)=="")
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Company Name Missing<br />";
						 }
					}
					if($j==4)
					{
						$address=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
						if($j==5)
					{
						$area=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
						if($j==6)
					{
						$city=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
						if($j==7)
					{
						$state=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
						if($j==8)
					{
						$country=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
						if($j==9)
					{
						$pincode=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
					if($j==10)
					{
						$phone=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
						if (trim($phone)=="")
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Phone no. Missing<br />";
						 }
					}
					if($j==11)
					{
						$mobile=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
						if (trim($mobile)=="")
						{
						  $chkdata=1;
						  $msgvalue=$msgvalue." Row No. ".$i." Mobile no. Missing<br />";
						 }
					}
					if($j==12)
					{
						$email=htmlspecialchars(mysql_real_escape_string($data->sheets[0]['cells'][$i][$j]));
					}
					
				//	$data->sheets[0]['cells'][$i][$j]."\",";
			}
		$datasource=htmlspecialchars(mysql_real_escape_string($_REQUEST['datasource1']));
		if($chkdata==0)
		{
					$sql="insert into tblcallingdata set First_Name='$first_name',Last_Name='$last_name',Company_Name='$company',Phone='$phone',Mobile='$mobile',email='$email',Address='$address',Area='$area',City='$city',State='$state', District_id = '$district',Country='$country',Pin_code='$pincode',data_source='$datasource',status='A',created=CURDATE(),createdby='$userid'";
			
		//	echo $sql;
		//	die;
			insertcontact($sql);	
			}
			$chkdata=0;
		}
			if($msgvalue!="")
			{
				$_SESSION["ERROR_MESSAGE"]=$msgvalue;
				header("location: Contactuploadmessage.php?token=".$token);
			
			}
			else
			{
				?>
                <script language="javascript">
				alert("Data Uploaded Successfully!");
				</script>
                <?php
				header("location: managecontacts.php?token=".$token);
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
<script language="javascript" src="js/manage_contacts.js"></script>
<!--Ajax request Call-->
<script  src="js/ajax.js"></script>
<script>
function CallState()
	{ 
		country = document.getElementById("country").value;
		url="ajaxrequest/getstate.php?country="+country+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,country,"GetState");
	}
	function GetState(str)
	{
		/*alert(str);*/
		document.getElementById('Divstate').innerHTML=str;
	}
function CallDistrict()
	{
		state = document.getElementById("state").value;
		url="ajaxrequest/get_district.php?state="+state+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,state,"GetDistrict");
	}	
	function GetDistrict(str)
	{
		/*alert(str);*/
		document.getElementById('divdistrict').innerHTML=str;
	}
function CallCity()
	{
		district = document.getElementById("district").value;
		url="ajaxrequest/get_city.php?district="+district+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,state,"GetCity");
	}
	function GetCity(str)
	{
		/*alert(str);*/
		document.getElementById('divcity').innerHTML=str;
	}
	
function CallArea()
	{
		city = document.getElementById("city").value;
		url="ajaxrequest/get_area.php?city="+city+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,city,"GetArea");
	}
	function GetArea(str)
	{
		/*alert(str);*/
		document.getElementById('divarea').innerHTML=str;
	}	

function CallPincode()
	{
		area = document.getElementById("area").value;
		url="ajaxrequest/get_pincode.php?area="+area+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,city,"GetPincode");
	}
	function GetPincode(str)
	{
		/*alert(str);*/
		document.getElementById('divpincode').innerHTML=str;
	}
	
</script>
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
    	<h1>Import Contact</h1>
        <hr>
    </div>
    <div class="col-md-12">
    <div class="col-md-12 select_form">
    
    	<div class="radio-inline">
              <label>
                <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="singlecontact()" /> 
                Single </label>
    	</div>
         <div class="radio-inline">
        <label>
                <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="multiplecontact()"/>
              Multiple</label>
         </div>
     
    </div>    
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <form name='myform' action="" class="form-horizontal" method="post" onSubmit="return chkcontactform(this)">
       	<input type="hidden" name="submitForm" value="yes" />
        <input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">First&nbsp;Name</label>
                <div class="col-sm-10">
                  <input name="first_name" id="first_name" placeholder="First Name*" class="form-control text_box" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Last&nbsp;Name</label>
                <div class="col-sm-10">
                  <input name="last_name" id="last_name" class="form-control text_box" Placeholder = "Last Name*" type="text" />
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Company*</label>
                <div class="col-sm-10">
                  <input name="company" id="company" class="form-control text_box" Placeholder="Company Name*" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Phone*</label>
                <div class="col-sm-10">
                  <input name="phone" id="phone" class="form-control text_box" Placeholder="Phone*" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Mobile*</label>
                <div class="col-sm-10">
                  <input name="mobile" id="mobile" class="form-control text_box" Placeholder="Mobile*" type="text" />
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Email*</label>
                <div class="col-sm-10">
                 	<input name="email" id="email" class="form-control text_box" placeholder="Email*" type="text" />
                </div>
            </div>              
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Address*</label>
                <div class="col-sm-10">
                  <textarea name="address" id="address" cols="6" class="form-control txt_area"></textarea>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Country*</label>
                <div class="col-sm-10">
                 	<select name="country" id="country" class="form-control drop_down" onChange="return CallState(this.value)">
                    <option value="">Select Country</option>
                    <?php $Country=mysql_query("select * from tblcountry");						  
                          while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
                    <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                    <?php } ?>
                  </select>
                </div>
            </div>              
        </div>
        <div class="clearfix"></div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">State*</label>
                <div class="col-sm-10" id="Divstate">
                 	<select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control drop_down">
                      <option value="">Select State</option>
                   </select>
                </div>
            </div>
        </div>
        
         <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">District*</label>
                <div class="col-sm-10" id="divdistrict">
                 	  <select name="district" id="district"  class="form-control drop_down" onChange="return CallCity(this.value)">
                            <option value="">Select District</option>
                     </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">City*</label>
                <div class="col-sm-10" id="divcity">
                 	 <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control drop_down" >
                        <option value="">Select City</option>
                     </select>
                </div>
            </div>              
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Area*</label>
                <div class="col-sm-10" id="divarea">
                 	<select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control drop_down">
                        <option value="">Select Area</option>
                   </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Pincode*</label>
                <div class="col-sm-10" id="divpincode">
                 	<input name="pin_code" id="pin_code" class="form-control text_box"  value="<?php if(isset($result['id'])) echo $result['Pin_code']; ?>" type="text" />
                </div>
            </div>              
        </div>
        
        
        <div class="col-md-6 form">
            <div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Datasource*</label>
                <div class="col-sm-10">
                  <select name="datasource" id="datasource" class="form-control drop_down">
            	<option label="" value="" selected="selected">Data Source</option>
            	<?php $Country=mysql_query("select * from tbldatasource");
									  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['datasource']; ?>" <?php if(isset($datasource) && $resultCountry['datasource']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['datasource'])); ?></option>
                <?php } ?>
          		</select>
                </div>
            </div>
            
        </div>
        <div class="col-md-6 form">
          <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Submit" class="btn btn-primary" id="submit"  />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='managecontacts.php?token=<?php echo $token ?>'" />
                </div>
  			</div> 
        </div>
      
        
        </form>
    </div> 
    <!--end single sim  form--> 
    
    <div id="contactUpload"  style="display:none;" class="col-md-12"> <!--open of the multiple sim form-->
    <form name="contact1" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return chkupload(this)">
    	<div class="col-md-6">
         	<div class="form-group">
                <label for="Datasource" class="col-sm-2 control-label">Datasource</label>
                <div class="col-sm-10">
                  <select name="datasource1" id="datasource1" class="form-control drop_down">
            	  <option label="" value="" selected="selected">Data Source</option>
                  <?php $Country1=mysql_query("select * from tbldatasource");				  
						while($resultCountry1=mysql_fetch_assoc($Country1)){
				  ?>
                  <option value="<?php echo $resultCountry1['datasource']; ?>" <?php if(isset($datasource) && $resultCountry1['datasource']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry1['datasource'])); ?></option>
                  <?php } ?>
          		 </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
         <div class="form-group">
                <label for="simno" class="col-sm-2 control-label">Upload</label>
                <div class="col-sm-10">
                  <input type="file" id="contactfile" name="contactfile"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" value="Submit" id="submit" class="btn btn-primary" />
                  <input type="button" value="Download Format" name="download" class="btn btn-primary" onClick="window.location='Samples/Contacts_Import_format.xls'" />
                  <input type="button" value="Back" id="Back" class="btn btn-primary" onClick="window.location='managecontacts.php?token=<?php echo $token ?>'" />
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
</html>
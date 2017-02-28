<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if (!empty($_POST)){
	$userid=$_SESSION['user_id'];
	if ($_REQUEST['first_name']!=""){
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
		$leadtype=htmlspecialchars(mysql_real_escape_string($_REQUEST['leadtype']));
		$queryArr = mysql_query("select * from tblcallingdata where Mobile = '$mobile'");
		if(mysql_num_rows($queryArr)<=0){
			$sql="insert into tblcallingdata set First_Name='$first_name',Last_Name='$last_name',
				  Company_Name='$company',Phone='$phone',Mobile='$mobile',email='$email',Address='$address',
				  Area='$area',City='$city',State='$state', District_id = '$district',  
				  Country='$country',Pin_code='$pincode',data_source='$datasource', leadCategoryId = '$leadtype', 
				  status='A', created=CURDATE(),createdby='$userid'";
				// Call User Activity Log function
				/*UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);*/
				// End Activity Log Function
			insertcontact($sql);
			$_SESSION['sess_msg'] = "Contact Added Successfully!";
			header("location: managecontacts.php?token=".$token);
		}
		else{
				$msgDanger = "Contact already exists";
		}	
	}
	else{
		$filename=upload_file("contactfile",SITE_FS_PATH."/upload/","");
		require_once 'excelreader/excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader(SITE_FS_PATH."/upload/".$filename);
		//echo $data->sheets[0]['numRows'];
		//die;
		$chkdata=0;
		$msgvalue="";
		for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) 
		{
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
					$sql="insert into tblcallingdata set First_Name='$first_name',Last_Name='$last_name',
						  Company_Name='$company',Phone='$phone',Mobile='$mobile',email='$email',
						  Address='$address',Area='$area',City='$city',State='$state', 
						  District_id ='$district',Country='$country',Pin_code='$pincode',
						  data_source='$datasource',status='A',created=CURDATE(),createdby='$userid'";
					// Call User Activity Log function
					/*UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);*/
					// End Activity Log Function
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
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- daterange picker -->
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="assets/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script  src="js/ajax.js"></script>
<script language="javascript" src="js/manage_contacts.js"></script>
<script>
 $(function() {
    $( "date" ).datepicker({dateFormat: 'yy-mm-dd'});
    
  });
function CallState()
	{ 
		country = document.getElementById("country").value;
		url="ajaxrequest/getstate.php?country="+country+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,country,"GetState");
	}
	function GetState(str)
	{
		// alert(str);
		document.getElementById('Divstate').innerHTML=str;
		$(".select2").select2();
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
		$(".select2").select2();
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
		$(".select2").select2();
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
		$(".select2").select2();
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
		$(".select2").select2();
	}

function checkcompany(){
	$.post("ajaxrequest/check_company_name.php?token=<?php echo $token;?>",
	{
		mobile : $('#mobile').val()
	},
	function(data){
		/*alert(data);*/
		$("#dv_alert").html(data);
	});	
}
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onLoad="checkDefault()">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Contact
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Contact</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row"> <!-- row -->
    		<div class="col-md-12"><!-- col-md-12 -->
    			<label>
	                <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="singlecontact()" /> 
	                <strong>Single </strong>
	                <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="multiplecontact()"/>
             		<strong>Multiple</strong>
                </label>
    		</div>	<!-- col-md-12 -->
    	</div> <!-- end row -->
      	<div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Import Contact</h3>
            </div>
            <div class="box-body">
            <?php if(isset($id) && $id !="") {?>
            <div class="alert alert-success alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $id; ?>
            </div>
            <?php 
            }
            ?>
            <?php if(isset($msgDanger) && $msgDanger !="") {?>
            <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgDanger;?>
            </div>
            <?php 
            }
            ?>
            <span id="dv_alert"></span>
            <div class="col-md-12" id="contactform"> <!--open of the single form-->
		    	<form name='myform' action="" class="form-horizontal" enctype="multipart/form-data" method="post" onSubmit="return chkcontactform(this)">
		       		<input type="hidden" name="submitForm" value="yes" />
		        	<input type='hidden' name='cid' id='cid'	value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
		          		<div class="form-group form_custom"><!-- form_custom -->
		            		<div class="row"><!-- row -->
		              			<div class="col-md-6 col-sm-6 custom_field">
		                			<span id="name" for="name"><strong>First Name</strong> <i>*</i></span>
		                            <input name="first_name" id="first_name" placeholder="First Name*" class="form-control" type="text" />                        
		           			  </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                        	<span><strong>Last Name</strong> <i>*</i></span>
		                            <input name="last_name" id="last_name" class="form-control" Placeholder = "Last Name*" type="text" />                           
		                        </div>
		                        <div class="col-md-6 col-sm-6 custom_field">
		                        	<span><strong>Company</strong> <i>*</i></span>
		                            <input name="company" id="company" class="form-control" Placeholder="Company Name*" type="text"  />

		                        </div>
		                        <div class="col-md-6 col-sm-6 custom_field">
		                            <span><strong>Phone</strong> <i>*</i></span>
		                            <input name="phone" id="phone" class="form-control" Placeholder="Phone*" type="text" />
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                        	<span><strong>Mobile No.</strong> <i>*</i></span>
		                    		<input name="mobile" id="mobile" class="form-control" Placeholder="Mobile*" type="text" onkeyup="checkcompany()" />
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                       	<span><strong>Email<i>*</i></strong></span>
		                    	<input name="email" id="email" class="form-control" placeholder="Email*" type="email" />
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                       	<span><strong>Address</strong> <i>*</i></span>
		                    	<textarea name="address" id="address" cols="8" rows="3" class="form-control"></textarea>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>Country</strong> <i>*</i></span>
		                    	<select name="country" id="country" class="form-control select2" onChange="return CallState(this.value)">
		                            <option value="">Select Country</option>
		                            <?php $Country=mysql_query("select * from tblcountry");						  
		                                  while($resultCountry=mysql_fetch_assoc($Country)){
		                            ?>
		                            <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['id']) && $resultCountry['Country_id']==$result['Country']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
		                            <?php } ?>
		                        </select>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                        <span><strong>State</strong> <i>*</i></span>
		                    	<span id="Divstate">
		                            <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control select2">
		                              <option value="">Select State</option>
		                           </select>
		                        </span>
		                      </div>
		                      <div class="clearfix"></div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>District</strong> <i>*</i></span>
		                    	<span id="divdistrict">
		                              <select name="district" id="district"  class="form-control select2" onChange="return CallCity(this.value)">
		                                    <option value="">Select District</option>
		                             </select>
		                        </span>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>City</strong> <i>*</i></span>
		                    	<span id="divcity">
		                             <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control select2" >
		                                <option value="">Select City</option>
		                             </select>
		                        </span>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>Area</strong> <i>*</i></span>
		                    	<span id="divarea">
		                            <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control select2">
		                                <option value="">Select Area</option>
		                           </select>
		                        </span>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>Pincode</strong> <i>*</i></span>
		                    	<span id="divpincode">
		                            <input name="pin_code" id="pin_code" class="form-control"  value="<?php if(isset($result['id'])) echo $result['Pin_code']; ?>" type="text" />
		                        </span>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>Category</strong> <i>*</i></span>
		                    	 <select name="leadtype" id="leadtype" class="form-control select2">
			                        <option label="" value="" selected="selected">Category</option>
			                        <?php $Country=mysql_query("SELECT * FROM `leadCategory`");
			                                              while($resultCountry=mysql_fetch_assoc($Country)){
			                        ?>
			                        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($datasource) && $resultCountry['id']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['leadCategory'])); ?></option>
			                        <?php } ?>
		                        </select>
		                      </div>
		                      <div class="col-md-6 col-sm-6 custom_field">
		                      	<span><strong>Datasource</strong> <i>*</i></span>
		                    	<select name="datasource" id="datasource" class="form-control select2">
		                            <option label="" value="" selected="selected">Data Source</option>
		                            <?php $Country=mysql_query("select * from tbldatasource");
		                                                  while($resultCountry=mysql_fetch_assoc($Country)){
		            
		                            ?>
		                            <option value="<?php echo $resultCountry['datasource']; ?>" <?php if(isset($datasource) && $resultCountry['datasource']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['datasource'])); ?></option>
		                            <?php } ?>
		                        </select>
		                      </div>
		                    </div><!-- End row --> 
		                  </div><!--End form_custom -->
		                  <div class="form-group form_custom"><!-- form_custom -->
		                    <div class="row">
		                        <div class="col-md-6 col-sm-6 custom_field">
		                           <input type="submit" value="Submit" class="btn btn-primary btn-sm" id="submit"  />
		                  			<input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='managecontacts.php?token=<?php echo $token ?>'" />
		                        </div>
		                    </div>
		                 </div>
		        </form>
		    </div> 
		    <!--end single sim  form--> 
		    <div id="contactUpload"  style="display:none;" class="row"> <!--open of the multiple sim form-->
			    <form name="contact1" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return chkupload(this)">
			    	<div class="col-md-6">
			         	<div class="form-group">
			                <label for="Datasource" class="col-sm-2 control-label">Datasource</label>
			                <div class="col-sm-10">
			                  <select name="datasource1" id="datasource1" class="form-control select2">
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
			                  <input type="submit" value="Submit" id="submit" class="btn btn-primary btn-sm" />
			                  <input type="button" value="Download Format" name="download" class="btn btn-primary btn-sm" onClick="window.location='Samples/Contacts_Import_format.xls'" />
			                  <input type="button" value="Back" id="Back" class="btn btn-primary btn-sm" onClick="window.location='managecontacts.php?token=<?php echo $token ?>'" />
			                </div>
			  			</div> 
			        </div>	
			    </form>
		    </div> <!--end multiple sim-->
            </div>
            <!-- /.box-body -->
          </div>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<script src="js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>
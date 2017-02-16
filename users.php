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

 
  $error =0;
  $userid=$_SESSION['user_id'];
  if(isset($_REQUEST['empId']))
    {
      $emp_id = htmlspecialchars(mysql_real_escape_string($_REQUEST['empId']));
      $first_name = htmlspecialchars(mysql_real_escape_string($_REQUEST['first_name']));
      $last_name = htmlspecialchars(mysql_real_escape_string($_REQUEST['last_name']));
      $emp_dob = htmlspecialchars(mysql_real_escape_string($_REQUEST['dob']));
      $contact = htmlspecialchars(mysql_real_escape_string($_REQUEST['contact_no']));
      $email_id = htmlspecialchars(mysql_real_escape_string($_REQUEST['email']));
      $date_of_j = htmlspecialchars(mysql_real_escape_string($_REQUEST['doj']));
      $address = htmlspecialchars(mysql_real_escape_string($_REQUEST['address']));
      $country = htmlspecialchars(mysql_real_escape_string($_REQUEST['country']));
      $state = htmlspecialchars(mysql_real_escape_string($_REQUEST['state']));
      $district = htmlspecialchars(mysql_real_escape_string($_REQUEST['district']));
      $city = htmlspecialchars(mysql_real_escape_string($_REQUEST['city']));
      $area = htmlspecialchars(mysql_real_escape_string($_REQUEST['area']));
      $pincode = htmlspecialchars(mysql_real_escape_string($_REQUEST['pin_code']));
      $imeiNo = htmlspecialchars(mysql_real_escape_string($_REQUEST['imeiNo']));
      $user_type = htmlspecialchars(mysql_real_escape_string($_REQUEST['user_type']));
      $branch = htmlspecialchars(mysql_real_escape_string($_REQUEST['branch_id']));
      $user_name = htmlspecialchars(mysql_real_escape_string($_REQUEST['user_name']));
      $password = htmlspecialchars(mysql_real_escape_string($_REQUEST['Password']));
      $createdby = $_SESSION['user_id'];
    }
  if(isset($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
    {
      if(isset($_REQUEST['cid']) && $_REQUEST['cid']!='')
      {
        $update_record ="Update tbluser set emp_id = '$emp_id', First_Name = '$first_name', 
                   Last_Name = '$last_name', DOB = '$emp_dob', Contact_No = '$contact', 
                   emailid = '$email_id', DOJ = '$date_of_j', Address = '$address', 
                   areaId = '$area', cityId = '$city', stateId = '$state', 
                   districtId = '$district', countryId = '$country', Pin_code = '$pincode',
                   userImeiNo='$imeiNo', User_ID = '$user_name', Password = '$password',
                   User_Status = 'A', Modified_date = Now(), ModifiedBY = '$createdby',
                   User_Category = '$user_type', branch_id = '$branch' 
                   where id=".$_REQUEST['id'];
        // echo $update_record;
        // exit();
        // Call User Activity Log function
        UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $update_record);
        // End Activity Log Function
        $sqlquery=mysql_query($update_record);    
        $_SESSION['sess_msg'] = "<span style='color:#006600;'>User Updated Successfully!";
        header("location: manage_users.php?token=".$token);
      }
      else
      {
        $queryArr=mysql_query("select * from tbluser where User_ID='$user_name'");
        //$result=mysql_fetch_assoc($queryArr);
        if(mysql_num_rows($queryArr)<=0)
        {
          $sql="INSERT INTO  tbluser set emp_id = '$emp_id', First_Name = '$first_name', 
              Last_Name = '$last_name', DOB = '$emp_dob', Contact_No = '$contact', 
              emailid = '$email_id', DOJ = '$date_of_j', Address = '$address',
              areaId = '$area', cityId = '$city', stateId = '$state', 
              districtId = '$district', countryId = '$country', Pin_code = '$pincode', 
              userImeiNo='$imeiNo', User_ID = '$user_name', 
              Password = '$password', User_Status = 'A', Created_date = Now(),  
              CreatedBY = '$createdby', User_Category = '$user_type', branch_id = '$branch'";
          
          // Call User Activity Log function
          UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
          // End Activity Log Function
          /*echo $sql;*/
          $query=mysql_query($sql);
          $usedId =  mysql_insert_id();
          if ($user_type == 1){
            $branchAuth_sql = "insert into userbranchmapping set userId ='$usedId', branchId='0' "; 
            // Call User Activity Log function
            UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $branchAuth_sql);
            // End Activity Log Function              
          }
          else {
            $branchAuth_sql = "insert into userbranchmapping set userId ='$usedId', branchId='$branch'";
            // Call User Activity Log function
            /*UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $branchAuth_sql);*/
            // End Activity Log Function              
          } 
          $addUserMapping = mysql_query($branchAuth_sql);
            
          $_SESSION['sess_msg'] = "<span style='color:#006600;'>User Created Successfully</span>";
          header("location: manage_users.php?token=".$token);
          exit();
        }
        else
        {
          $msgdanger="User already exists";
        }
  
      }
    }

if(isset($_REQUEST['id']) && $_REQUEST['id'])
  {
    $queryArr=mysql_query("select * from tbluser where id =".$_REQUEST['id']);
    $result=mysql_fetch_assoc($queryArr);
  } 
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
<script src="js/manage_users.js"></script>
<!--Datepicker-->
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
<!--end-->
<script>
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
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
  
  
  function hidediv(usercat)
  {
  //alert(usercat);
  if(usercat=="1")
  {
  document.getElementById('notadmin').style.display="none";
  }
  else
  {
  document.getElementById('notadmin').style.display="";
  }
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
        Users
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
          <div class="box-header">
            <!-- <h3 class="box-title">Import</h3> -->
          </div>
          
          <div class="box-body">
          <?php if(isset($msgdanger)){
          ?>
            <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msgdanger; ?>
            </div>
          <?php  
          }
          ?>
            <div class="col-md-12" id="contactform">
              <form name='myform' action="" method="post" onSubmit="return chkcontactform(this)">
                <input type="hidden" name="submitForm" value="yes" />
                <input type='hidden' name='cid' id='cid' value="<?php if(isset($_GET['id']) and $_GET['id']>0){ echo $_GET['id']; }?>"/>
                <div class="form-group form_custom col-md-12"><!-- form_custom -->
                  <div class="row"> <!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Employee Id <i>*</i></span>
                      <input name="empId" id="empId" class="form-control" type="text" value="<?php if(isset($result['id'])) echo $result['emp_id'];?>" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Date Of Joining <i>*</i></span>
                      <input name="doj" id="doj" class="form-control date" value="<?php if(isset($result['id'])) echo $result['DOJ'];?>" tabindex="0"  type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>First Name <i>*</i></span>
                      <input name="first_name" id="first_name" class="form-control" value="<?php if(isset($result['id'])) echo $result['First_Name'];?>" type="text" />
                    </div><!-- end custom_field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Last Name<i>*</i></span>
                      <input name="last_name" id="last_name" type="text" class="form-control" value="<?php if(isset($result['id'])) echo $result['Last_Name'];?>" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Date of Birth<i>*</i></span>
                      <input name="dob" id="dob" size="25" class="form-control date" value="<?php if(isset($result['id'])) echo $result['DOB'];?>" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Contact No.<i>*</i></span>
                      <input name="contact_no" id="contact_no" class="form-control" value="<?php if(isset($result['id'])) echo $result['Contact_No'];?>" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Email<i>*</i></span>
                      <input name="email" id="email" class="form-control" value="<?php if(isset($result['id'])) echo $result['emailid'];?>" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Country<i>*</i></span>
                      <select name="country" id="country" class="form-control select2" style="width: 100%" onChange="return CallState(this.value)">
                        <option value="">Select Country</option>
                        <?php $Country=mysql_query("select * from tblcountry");             
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['Country_id']; ?>" <?php if(isset($result['countryId']) && $resultCountry['Country_id']==$result['countryId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['Country_name'])); ?>            </option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>State<i>*</i></span>
                      <span id="Divstate">
                        <select name="state" id="state" onChange="return CallDistrict(this.value)" class="form-control select2" style="width: 100%">
                          <option value="<?php if(isset($result['id'])) echo $result['stateId'];?>" selected>
                          <?php if(isset($result['id'])) 
                          {
                            echo getstate($result['stateId']);
                          }
                          else
                          {
                            echo "Select State";
                          }
                          ?>
                          </option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>District<i>*</i></span>
                      <span  id="divdistrict">
                        <select name="district" id="district"  class="form-control select2" style="width: 100%" onChange="return CallCity(this.value)">
                          <option value="<?php if(isset($result['id'])) echo $result['districtId'];?>" selected>
                          <?php if(isset($result['id'])) 
                          {
                            echo getdistrict($result['districtId']);
                          }
                          else
                          {
                            echo "Select District";
                          }
                          ?>
                          </option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>City<i>*</i></span>
                      <span id="divcity">
                        <select name="city" id="city" onChange="return CallArea(this.value)" class="form-control select2" style="width: 100%">
                          <option value="<?php if(isset($result['id'])) echo $result['cityId'];?>" selected>
                          <?php if(isset($result['id'])) 
                          {
                            echo getcities($result['cityId']);
                          }
                          else
                          {
                            echo "Select  City";
                          }
                          ?>
                          </option>
                        </select>
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Area<i>*</i></span>
                      <span id="divarea">
                      <select name="area" id="area" onChange="return CallPincode(this.value)" class="form-control select2" style="width: 100%">
                        <option value="<?php if(isset($result['id'])) echo $result['areaId'];?>" selected>
                        <?php if(isset($result['id'])) 
                        {
                          echo getarea($result['areaId']);
                        }
                        else
                        {
                          echo "Select Area";
                        }
                        ?>
                        </option>
                      </select>
                    </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Pincode<i>*</i></span>
                      <span id="divpincode">
                        <input name="pin_code" id="pin_code" class="form-control"  value="<?php if(isset($result['id'])) echo getpincode($result['Pin_code']); ?>" type="text" />
                      </span>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Address<i>*</i></span>
                      <textarea id="address" name="address" class="form-control" ><?php if(isset($result['id'])) echo $result['Address'];?></textarea>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>User Type<i>*</i></span>
                      <select name="user_type" class="form-control select2" style="width: 100%" id="user_type" onChange="hidediv(this.value)">
                        <option label="" value="" selected="selected">Select User </option>
                        <?php $Country=mysql_query("select * from tblusercategory");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" 
                        <?php if(isset($result['User_Category']) && $resultCountry['id']==$result['User_Category']){ ?>selected<?php } ?>>
                        <?php echo stripslashes(ucfirst($resultCountry['User_Category'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Branch<i>*</i></span>
                      <select name="branch_id" id="branch_id" class="form-control select2" style="width: 100%">
                        <option label="" value="" selected="selected">Select Branch</option>
                        <?php $Country=mysql_query("select * from tblbranch");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                        ?>
                        <option value="<?php echo $resultCountry['id']; ?>" 
                        <?php if(isset($result['branch_id']) && $resultCountry['id']==$result['branch_id']){ ?>selected<?php } ?>>
                        <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                        <?php } ?>
                      </select>
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Username<i>*</i></span>
                      <input name="user_name" id="user_name" class="form-control" value="<?php if(isset($result['id'])) echo $result['User_ID'];?>"type="text" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>Password<i>*</i></span>
                      <input name="Password" id="Password" value="<?php if(isset($result['id'])) echo $result['Password'];?>" tabindex="0" class="form-control" type="password" />
                    </div> <!-- end custom_form -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- custom_field -->
                      <span>User IMEI No.<i>*</i></span>
                      <input name="imeiNo" id="imeiNo" class="form-control" value="<?php if(isset($result['id'])) echo $result['userImeiNo'];?>" type="text" />
                    </div> <!-- end custom_form -->
                    <div class="clearfix"></div>
                    <div class="col-lg-6 col-sm-6 custom_field">
                      <input type="submit" value="Submit" id="submit"  class="btn btn-primary btn-sm" />
                      <input type="reset" id="reset" class="btn btn-primary btn-sm"  value="Reset"/>
                      <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Back" onClick="window.location.replace('manage_users.php?token=<?php echo $token ?>')"/>
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end form_custom -->
              </form>
            </div> <!-- end contacform -->
          </div><!-- /.box-body -->
      </div>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Loader -->
<div class="loader">
    <img src="images/loader.gif" alt="loader">
</div>
<!-- End Loader -->
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
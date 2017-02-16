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


if(count($_POST['linkID'])>0)
{
  $dsl="";
  for($dsl=0;$dsl<count($_POST['linkID']);$dsl++)
  {
      $callingdata_id = $_POST['linkID'][$dsl];
    $callingcategory_id = $_POST['callingcat'];
    $status_id = "1";
    $branch_id = $_POST['branch'];
    $createdby = $_SESSION['user_id'];
    $checkDuplicate = mysql_query("SELECT * FROM tblassign WHERE callingdata_id='$chckvalue'"); 
                if(mysql_num_rows($checkDuplicate) <= 0)
        {
          $sql = "insert into tblassign set callingdata_id='$callingdata_id', assign_by = '$createdby',
              callingcategory_id='$callingcategory_id', status_id='$status_id',
              branch_id='$branch_id',createdby='$createdby',created=CURDATE()";
          $results = mysql_query($sql); 
          // Call User Activity Log function
          UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
          // End Activity Log Function
          $msg = "Lead Assign Successfully";
        }
        else{
          $msgDanger = "Lead already Assign";
        }
  }
    $id="";  
  }

//Remove Assign Contact
if(isset($_POST['remove'])){         
    $dsl="";
    if(isset($_POST['linkID'])){
      foreach($_POST['linkID'] as $chckvalue){
        $sql = "delete from tblassign where id=".$chckvalue;
        // Call User Activity Log function
        UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
        // End Activity Log Function
        $results = mysql_query($sql) or die(mysql_error()); 
        $msgDanger = "Lead Remove Successfully";
      }
    }  
    $id="";
}
//End
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<!-- Jquery -->
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript">
//call ajax when select category
$(document).ready(function(){
  $('#callingcat').change(function(){
    $('.loader').show();
    $.post("ajaxrequest/getgrid.php?token=<?php echo $token;?>",
        {
          callingcat : $('#callingcat').val(),
          state : $('#state').val(),
          city : $('#city').val()
        },
          function(data){
            /*alert(data);*/
            $("#divassign").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
//end
//call ajax when select State
$(document).ready(function(){
  $('#state').change(function(){
    $('.loader').show();
    $.post("ajaxrequest/getCity1.php?token=<?php echo $token;?>",
        {
          state : $('#state').val(),
          city : $('#city').val()
        },
          function(data){
            /*alert(data);*/
            $("#divcity").html(data);
            $(".select2").select2();
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
//end
//call ajax when click View Assigned Contacts
$(document).ready(function(){
  $('#view').click(function(){
    $('.loader').show();
    $.post("ajaxrequest/show_assigned_contact.php?token=<?php echo $token;?>",
        {
          branch : $('#branch').val()
        },
          function(data){
            /*alert(data);*/
            $("#divassign").html(data);
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        }); 
  });
});
//end
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <?php include_once("includes/header.php") ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Lead Assign Branch
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Lead Assign Branch</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
          <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Category <i class="red">*</i></span>
                        <select name="callingcat" id="callingcat" class="form-control select2" style="width: 100%">
                          <option label="" value="" selected="selected">Select Category</option>
                          <?php $Country=mysql_query("select * from tblcallingcategory");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['category'])); ?></option>
                          <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                          <option label="" value="" selected="selected">Select Branch</option>
                          <?php 
                          $branch_sql= "select * from tblbranch ";
                          $authorized_branches = BranchLogin($_SESSION['user_id']);
                          //echo $authorized_branches;
                          if ( $authorized_branches != '0'){
                            $branch_sql = $branch_sql.' where id in '.$authorized_branches;   
                          }
                          if($authorized_branches == '0'){
                            echo'<option value="0">All Branch</option>';  
                          }
                          //echo $branch_sql;
                          $Country = mysql_query($branch_sql);                                          
                          while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                          <?php 
                          } 
                          ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>State <i class="red">*</i></span>
                        <select name="state" id="state"  class="form-control select2" style="width: 100%" >
                          <option label="" value="" selected="selected">Select State</option>
                          <?php $Country=mysql_query("select * from tblstate order by State_name");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['State_id']; ?>" <?php if(isset($State_name) && $resultCountry['State_name']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['State_name'])); ?></option>
                          <?php 
                          } 
                          ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>City <i class="red">*</i></span>
                        <span id="divcity">
                          <select name="city" id="city" class="form-control select2" style="width: 100%">
                            <option label="" value="" selected="selected">Select City</option>
                            <?php $Country=mysql_query("select distinct city_name from tblcity order by city_name");    while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['city_name']; ?>" <?php if(isset($city_name) && $resultCountry['city_name']==$City){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['city_name'])); ?></option>
                            <?php } ?>
                          </select>
                        </span>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                        <input type="button" name="view" id="view" class="btn btn-primary btn-sm" value="View Assigned Contact"/> 
                    </div>
                </div><!-- end row -->                
            </div><!-- End From Custom -->
          </div>
          <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                  <!-- Show alert  message-->
                  <?php if(isset($msg)) {?>
                  <div class="alert alert-success alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
                <?= $msg; ?>
            </div>
            <?php } ?>
            <?php if(isset($msgDanger)) {?>
                  <div class="alert alert-danger alert-dismissible small-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong><i class="fa fa-check-circle-o" aria-hidden="true"></i></strong> 
                <?= $msgDanger; ?>
            </div>
            <?php } ?>
            <!-- end alert message -->
                  <form name='fullform' method='post' onSubmit="return confirmdelete()">
                 <input type="hidden" name="token" value="<?php echo $token; ?>" />
                 <input type='hidden' name='pagename' value='users'> 
                 <div id="divassign">
                  <?php
                  $where='';
                  $linkSQL="";  
                  if(!isset($linkSQL) or $linkSQL =='')   
                  $linkSQL = "select * from tblcallingdata where 1=1 $where order by id desc";
                  $oRS = mysql_query($linkSQL); 
                  ?>
                  <table class="table table-bordered table-hover">
                    <tr>
                      <th><small>S. No.</small></th>     
                      <th><small>Name</small></th> 
                      <th><small>Company Name</small></th>
                      <th><small>Phone</small></th>
                      <th><small>Mobile</small></th>
                      <th><small>State</small></th>
                      <th><small>City</small></th>
                      <th><small>Area</small></th>
                      <th><small>Actions<br>
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>          </small>
                      </th>   
                    </tr>
                  <?php
                  $kolor=1;
                  if(mysql_num_rows($oRS)>0)
                  {
                    while ($row = mysql_fetch_array($oRS))
                    {
                  ?>
                      <tr>
                        <td><small><?php print $kolor++;?>.</small></td>
                        <td><small><?php echo stripslashes($row["First_Name"]." ".$row["Last_Name"]);?></small></td>
                        <td><small><?php echo stripslashes($row["Company_Name"]);?></small></td>
                        <td><small><?php echo stripslashes($row["Phone"]);?></small></td>
                        <td><small><?php echo stripslashes($row["Mobile"]);?></small></td>
                        <td><small><?php echo getstate(stripslashes($row["State"]));?></small></td>
                        <td><small><?php echo getcities(stripslashes($row["City"]));?></small></td>
                        <td><small><?php echo getarea(stripslashes($row["Area"]));?></small></td>
                        <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                      </tr> 
                  <?php 
                    }
                  }
                else{
                  echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
                }
                  ?> 
                    </table>
                    <div class="col-md-12">
                      <input type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Do you really to want to assign this records');" value="Submit" id="submit" />
                    </div>
                 </div>
              </form>
                </div><!-- /.box-body -->
            </div> <!-- end box-info -->
        </form>
      </section><!-- End Main content -->
  </div> <!-- end content Wrapper-->
  <?php include_once("includes/footer.php") ?>
  <!-- Loader -->
  <div class="loader">
    <img src="images/loader.gif" alt="loader">
  </div>
  <!-- End Loader -->
</div> <!-- End site wrapper -->
<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
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
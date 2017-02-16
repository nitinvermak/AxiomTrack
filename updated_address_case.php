<?php
session_start();
include "../affconfig.php";
include "./lang/$language";
include "include/general_function.php";
if(!aff_check_security()){
  aff_redirect('index.php');
  exit;
}
mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error (line 16)"); 
$result = mysql_db_query($database, "select * from clientmaster order by clnt_id") or die(mysql_error); //query1
//Delete single record
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$deleteQry = "DELETE FROM `branchmaster` WHERE `branchId` = '$id'";
	$resultSql = mysql_query($deleteQry);
	echo "<script> alert('Case Delete Successfully'); </script>";
	header("location:manage_branch.php");
}
//End
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verification Panel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Custom CSS -->
	<link rel="stylesheet" href="css/custom.css">
    <!-- Jquery Latest CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Checkbox Checked All -->
    <script type="text/javascript" src="js/checkbox_checked.js"></script>
    
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php 
	  // header
	  include_once('include/header1.php');
	  // navbar 
	  include_once('include/navbar.php') 
	  ?>
      <!-- Left side column. contains the logo and sidebar -->
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!--<section class="content-header">
          <h1>
            Pending Cases 
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pending Cases </li>
          </ol>
        </section>-->

        <!-- Main content -->
        <section class="content">
        <div class="row">
        	<!--<div class="col-md-12 action_field">
            	<button type="button" name="addNew" id="addNew" class="btn btn-success btn-sm" onClick="window.location.href='branch.php'"> 
                <i class="fa fa-pencil-square"></i> <strong>Add New</strong></button>
                <button type="submit" name="deleteRec" id="deleteRec" class="btn btn-danger btn-sm">
                 <i class="fa fa-trash"></i> <strong>Delete</strong>
                 </button>
            </div>-->
            <div class="col-md-12">
            	<?php if($_SESSION['sess_Msg']!=''){
						echo $_SESSION['sess_Msg']; $_SESSION['sess_Msg'] = "";
					  }
				?>	 		
            </div>
        </div>
        	<div class="box">
                <div class="box-body" >
                	<form action="" method="post" onSubmit="return formValidate(this);">
                		<input type="hidden" name="addressCaseId" id="addressCaseId" value="<?= $addressCaseId; ?>" />
                		<input type="hidden" name="lat" id="lat" required value="">
						<input type="hidden" name="lang" id="lang" required value="">
                    	<div>
                        	<ul class="nav nav-tabs" role="tablist">
    							<li role="presentation" class="active"><a href="#form" aria-controls="form" role="tab" data-toggle="tab">Form</a></li>
    							<li role="presentation"><a href="#signature" aria-controls="signature" role="tab" data-toggle="tab">Signature</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="form">
                                	<div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 custom_field">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" id="status">
                                                <option value="">-- Select --</option>
                                                <option value="Verified">Verified</option>
                                                <option value="Insuff">Insuff</option>
                                                <option value="Utv">Utv</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvcontactPersonName">
                                            <label>Contact Person Name</label>
                                            <input type="text" class="form-control" name="contactPersonName" id="contactPersonName">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvRelation">
                                            <label>Relation</label>
                                            <input type="text" class="form-control" name="relation" id="relation" placeholder="">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvcontactNo">
                                            <label>Contact No.</label>
                                            <input type="text" class="form-control" name="contactNo" id="contactNo">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvnoOfYearPresentAdd">
                                            <label>No. of Year Present Address</label>
                                            <input type="text" class="form-control" name="noOfYearPresentAdd" id="noOfYearPresentAdd" placeholder="">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvhouseStatus">
                                            <label>House Status</label>
                                            <select class="form-control" name="houseStatus" id="houseStatus">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Owned">Owned</option>
                                                <option value="Rented">Rented</option>
                                                <option value="PG">PG</option>
                                                <option value="Relative House ">Relative House </option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvtypeOfAddress">
                                            <label>Type of Address</label>
                                            <select class="form-control" name="typeOfAddress" id="typeOfAddress">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Present">Present</option>
                                                <option value="Permanent">Permanent</option>
                                                <option value="Previous">Previous</option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvlandmark">
                                            <label>Landmark</label>
                                            <input type="text" name="landmark" id="landmark" class="form-control">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvphotoStatus">
                                            <label>Photo Status</label>
                                            <select name="photoStatus" id="photoStatus" class="form-control select2" style="width:100%">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Provided">Provided</option>
                                                <option value="Not Provided">Not Provided</option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvsignatureStatus">
                                            <label>Signature Status</label>
                                            <select name="signatureStatus" id="signatureStatus" class="form-control select2" style="width:100%">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Signed">Signed</option>
                                                <option value="Refused to Signed">Refused to Signed</option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvpolitical">
                                            <label>Has any political connection/ Union/ social activist </label>
                                            <select name="political" id="political" class="form-control select2" style="width:100%">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="Not Disclosed">Not Disclosed</option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvvisitDate">
                                            <label>Visit Date </label>
                                            <input type="text" class="form-control datepicker" name="visitDate" id="visitDate">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvvisittime">
                                            <label>Visit Time </label>
                                            <input type="text" class="form-control" name="visittime" id="visittime">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvcandidateLive">
                                            <label>Did the Candidate live Here</label>
                                            <select name="candidateLive" id="candidateLive" class="form-control select2" style="width:100%">
                                                <option value="">--Select--</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvReason">
                                            <label>Reason</label>
                                            <input type="text" class="form-control" name="reason" id="reason" placeholder="">
                                        </div><!--custom_field-->
                                        <div class="col-lg-6 col-sm-6 custom_field" id="dvremarks">
                                            <label>Remarks</label>
                                            <textarea name="remarks" class="form-control" id="remarks" rows="1"></textarea>
                                        </div><!--custom_field-->
                                   </div> <!--end row-->
                                </div> <!--end form-->
                                <div role="tabpanel" class="tab-pane" id="signature">
                                	<div class="row">
                                    	<div class="col-lg-6 col-sm-6 custom_field">
                                            <label>Signature</label>
                                            <div class="tools">
                                                <a href="#colors_sketch" title="Marker" data-tool="marker" class="btn btn-warning btn-sm">
                                                	<!--<i class="fa fa-pencil" aria-hidden="true"></i>-->Marker
                    							</a> 
                                                <a href="#colors_sketch" data-tool="eraser" class="btn btn-warning btn-sm" title="Eraser">
                                                   Eraser
                                                </a>
                                             </div>
                                            <canvas id="colors_sketch" style="height:400px;">
                                            </canvas>
                                        </div>
                                    </div> <!--end row-->
                                    <button type="button" name="updateAddressCase" class="btn btn-success btn-sm" id="updateAddressCase" onclick="getAddressUpdateData();">Submit</button>
                                    <a href="executive_dashboard.php" class="btn btn-success btn-sm">Back</a>
                              </div> <!--end signature-->
                        </div>
                    </form>
                </div><!-- /.box-body -->
              </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php 
	  // footer
	  include_once('include/footer1.php');
	  // side control
	/*  include_once('include/control_sidebar.php');*/
	  ?>
    </div><!-- ./wrapper -->
 
	<!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <!--<script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>-->
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script src="http://intridea.github.io/sketch.js/lib/sketch.min.js" type="text/javascript"></script>
	<script type="text/javascript">
        $(function (){
            $('#colors_sketch').sketch();
            $(".tools a").eq(0).attr("style", "color:#000");
            $(".tools a").click(function () {
                $(".tools a").removeAttr("style");
                $(this).attr("style", "color:#000");
            });
            $("#status").change(function () {
                if ($(this).val() == "Insuff") {
                    $("#dvcontactPersonName").hide();
                    $("#dvcontactNo").hide();
                    $("#dvnoOfYearPresentAdd").hide();
                    $("#dvtypeOfAddress").hide();
                    $("#dvlandmark").hide();
                    $("#dvphotoStatus").hide();
                    $("#dvsignatureStatus").hide();
                    $("#dvcandidateLive").hide();
                    $("#dvhouseStatus").hide();
                    $("#dvpolitical").hide();
                    $("#dvRelation").hide();
                    // alert('Insuff');
                } else {
                   $("#dvReason").show();
                   $("#dvvisitDate").show();
                   $("#dvvisittime").show();
                   $("#dvremarks").show();                    
                }
                if($(this).val() == "Utv"){
                    $("#dvcontactPersonName").hide();
                    $("#dvcontactNo").hide();
                    $("#dvnoOfYearPresentAdd").hide();
                    $("#dvtypeOfAddress").hide();
                    $("#dvlandmark").hide();
                    $("#dvphotoStatus").hide();
                    $("#dvsignatureStatus").hide();
                    $("#dvcandidateLive").hide();
                    $("#dvhouseStatus").hide();
                    $("#dvpolitical").hide();
                    $("#dvRelation").hide();
                }
                else{
                    $("#dvReason").show();
                    $("#dvvisitDate").show();
                    $("#dvvisittime").show();
                    $("#dvremarks").show();
                }
                if($(this).val() == "Verified"){
                    $("#dvcontactPersonName").show();
                    $("#dvcontactNo").show();
                    $("#dvnoOfYearPresentAdd").show();
                    $("#dvtypeOfAddress").show();
                    $("#dvlandmark").show();
                    $("#dvphotoStatus").show();
                    $("#dvsignatureStatus").show();
                    $("#dvcandidateLive").show();
                    $("#dvhouseStatus").show();
                    $("#dvpolitical").show();
                    $("#dvRelation").show();
                    $("#dvvisitDate").show();
                    $("#dvvisittime").show();
                    $("#dvremarks").show();
                    $("#dvReason").show();
                }
                else{
                    // $("#dvcontactPersonName").show();
                    // $("#dvcontactNo").show();
                    // $("#dvnoOfYearPresentAdd").show();
                    // $("#dvtypeOfAddress").show();
                    // $("#dvlandmark").show();
                    // $("#dvphotoStatus").show();
                    // $("#dvsignatureStatus").show();
                    // $("#dvcandidateLive").show();
                    // $("#dvhouseStatus").show();
                    // $("#dvpolitical").show();
                    // $("#dvRelation").show();
                    // $("#dvvisitDate").show();
                    // $("#dvvisittime").show();
                    // $("#dvremarks").show();
                }
            });
        });
        // function getAddressUpdateData(){
        //    if($("#status").val() == ""){
        //         alert("Please Select Status");
        //         $("#status").focus();
        //    }
        // }
        // function Showfields() {
        //     alert('saddsda');
        //        if($("#status").val() == "Insuff"){
        //             $("#dvRelation").show();
        //             $("#dvvisitDate").show();
        //             $("#dvvisittime").show();
        //             $("#dvremarks").show();
        //        }
        //        else{
        //             $("#dvcontactPersonName").hide();
        //        }
        // }
    </script>
  </body>
</html>

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
                <div class="box-body table-responsive" >
                	<form action="" >
                  		<table id="example1" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                
                                    <th width="10%"><small>S. No.</small></th>
                                    <th width="80%"><small>Detils</small></th>
                                    
                                    <th width="10%"><small>Action</small></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							               /* AND B.executiveId = '$executiveId'*/
                            $sNo = 1;	
							              $executiveId = $_SESSION['userId'];
                            $sqlQuery = "SELECT A.id as id, A.clientId as clientId,  
                                         A.candidateName as candidateName, A.contactNo as contactNo, 
                                         A.completeAddress as completeAddress, A.jobAppliedCmp company,
                                         B.branchId as branchId, A.caseRecievedDate as caseRecievedDate
                                         FROM addressverification as A 
                                         INNER JOIN addressverificationcaseassign as B 
                                         ON A.id = B.adVeriCaseId
                                         WHERE B.executiveAssign = 'Y'
                                         AND A.caseStatus = 'Pending' 
                                         ORDER BY A.candidateName";
                            $resultQuery = mysql_query($sqlQuery); 
                            if(mysql_num_rows($resultQuery)>0)
                                {
                                    while ($qry = mysql_fetch_array($resultQuery))
                                        {
                            ?>           	        
                                              <tr>
                                                <td><small><?php echo $sNo++; ?></small></td>
                                                <td><small><?php echo getClient($qry['clientId']); ?>,  
                                                           <?php echo $qry['candidateName']; ?>, 
                                                           <?php echo $qry['completeAddress']; ?>, 
                                                           <?php echo $qry['contactNo']; ?>
                                                </small></td>
                                                
                                                <td><a href="updated_address_case.php?add_id=<?= $qry['id']?>" class="btn btn-success btn-sm">
                                                      <i class="fa fa-pencil-square"></i> Update
                                                    </a>
                                                </td>
                                              </tr>
                        <?php
                                        }
                                }
                        ?>
                        </tbody>
                        </table>
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
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <!--<script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>-->
  </body>
</html>

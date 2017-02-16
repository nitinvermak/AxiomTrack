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
if(count($_POST['linkID'])>0){         
  $dsl="";
  if(isset($_POST['linkID']) && (isset($_POST['submit']))){
    foreach($_POST['linkID'] as $chckvalue){
      $technician_id=$_POST['technician_id'];
      $status_id="1";
      $createdby=$_SESSION['user_id'];
      
      $sql = "insert into tbl_ticket_assign_technician set ticket_id='$chckvalue', technician_id ='$technician_id', assigned_date =Now()";
      $results = mysql_query($sql);
      $assign_technician = "update tbl_ticket_assign_branch set technician_assign_status='$status_id' where ticket_id='$chckvalue'";
      /*echo $assign_technician;*/
      $confirm = mysql_query($assign_technician);
    }
  }  
  $id="";
}
  
if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) ){         
    $dsl="";
    if(isset($_POST['linkID']))
        {
        foreach($_POST['linkID'] as $chckvalue)
              {
            $technician_id=$_POST['technician_id'];
          $status_id="0";
          $createdby=$_SESSION['user_id'];
        $sql = "delete from tbl_ticket_assign_technician where ticket_id='$chckvalue'";
        $results = mysql_query($sql);   
        $assign = "update tbl_ticket_assign_branch set  technician_assign_status='$status_id' where ticket_id='$chckvalue'";
        
        $query = mysql_query($assign);
           }
       }  
      $id="";
  
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
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript">
  $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
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
        Update Ticket
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Ticket</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (From) <i class="red">*</i></span>
                        <input type="text" name="dateform" id="dateform" class="form-control date">
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Date (To) <i class="red">*</i></span>
                        <input type="text" name="dateto" id="dateto" class="form-control date"/>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                          <option value="0">All Branch</option>
                          <?php $Country=mysql_query("select * from tblbranch");                   
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                          <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Executive <i class="red">*</i></span>
                        <select name="users" id="users" class="form-control drop_down-sm select2" style="width: 100%">
                          <option value="0">All Executive</option>
                          <?php $Country=mysql_query("select * from tbluser ORDER BY First_Name,Last_Name ASC");
                                while($resultCountry=mysql_fetch_assoc($Country)){
                          ?>
                          <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
                          <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                        <span>&nbsp;</span><br>
                        <input type="button" name="search" id="search" value="Submit" class="btn btn-primary btn-sm" onClick="return ShowRecords()"/>
                    </div>
                </div><!-- end row -->                
            </div><!-- End From Custom -->
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Ticket Id  <i class="red">*</i></span>
                        <input type="text" name="ticket_id" id="ticket_id" class="form-control">
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>&nbsp;</span><br>
                        <input type="button" name="searchById" id="searchById" class="btn btn-primary btn-sm" value="Search">
                    </div> <!-- end custom field -->
                </div>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <?php 
                if( isset($_SESSION['msgTkt']))
                {
                ?>
                  <div class="alert alert-success small-alert alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><?= $_SESSION['msgTkt']; ?></strong>
                  </div>
                <?php 
                }?>
                <div id="divassign" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
            </div>
            <!-- /.box-body -->
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
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
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
// filter Records
function ShowRecords(){
    $('.loader').show();
    $.post("ajaxrequest/update_assign_ticket_branch.php?token=<?php echo $token;?>",
        {
          dateform : $('#dateform').val(),
          branch  : $('#branch').val(),
          users : $('#users').val(),
          dateto  : $('#dateto').val()
        },
          function( data){
            /*alert(data);*/
            $("#divassign").html(data);
            $('#example').DataTable( {
                          dom: 'Bfrtip',
                          "bPaginate": false,
                          buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                           ]
            });
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        });  
}
// filter by ticketId
$(document).ready(function(){
  $("#searchById").click(function(){
    $('.loader').show();
    $.post("ajaxrequest/update_assign_ticket_techician.php?token=<?php echo $token;?>",
        {
          ticket_id : $('#ticket_id').val()
        },
          function( data){
            /*alert(data);*/
            $("#divassign").html(data);
             $('#example').DataTable( {
                          dom: 'Bfrtip',
                          "bPaginate": false,
                          buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                           ]
            });
            $(".loader").removeAttr("disabled");
            $('.loader').fadeOut(1000);
        });  
  });
});
//End
</script>
</body>
</html>
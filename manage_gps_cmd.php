<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
  session_destroy();
  header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']==''){
  session_destroy();
  header("location: index.php?token=".$token);
}

//Delete single record
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $delete_single_row = "DELETE FROM `tbldevicecommand` WHERE `id` = '$id'";
    $delete = mysql_query($delete_single_row);
    if($delete){
      $msgDanger = "Command Deleted Successfully";
    }
}
//End
//Delete multiple records
if(isset($_POST['delete_selected'])){
  foreach($_POST['linkID'] as $chckvalue){
    $sql = "DELETE FROM `tbldevicecommand` WHERE `id` = '$chckvalue'";
    $result = mysql_query($sql);
  }
  if($result){
      $msgDanger = "Device Deleted Successfully";
  }
}
//end
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
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<!-- DataTable CSS -->
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
<!-- Jquery -->
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<!-- DataTable JS -->
<script type="text/javascript" src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/js/buttons.print.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('#example').DataTable( {
                dom: 'Bfrtip',
                "bPaginate": false,
                buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                         ]
    });
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
          GPS Device Command Details
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">GPS Device Command Details</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="box box-info">
              <div class="box-header">
                <!-- <h3 class="box-title">Details</h3> -->
              </div>
              <div class="box-body">
              <form name='fullform' method='post' onSubmit="return confirmdelete()">
                <input type="hidden" name="token" value="<?php echo $token; ?>" />
                <input type='hidden' name='pagename' value='users'>   
               <div class="table-responsive"> <!-- table-responsive -->
                <div class="search_grid" style="margin-bottom: 20px">
                  <div class="col-md-3">
                    <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('add_gps_cmd.php?token=<?php echo $token ?>')"/>
                    <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
                  </div> <!-- end col-md-6 -->
                  <div class="col-md-9">
                  <?php if(isset($msgDanger)){?>
                    <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msgDanger; ?>
                    </div>
                  <?php 
                  }
                  ?>
                  </div> <!-- end col-md-6 -->
                </div> <!-- end search_grid -->
                <table id="example" class="table table-hover table-bordered ">
                  <?php
                  $where='';
                  $linkSQL="";      
                  if(!isset($linkSQL) or $linkSQL =='')   
                  $linkSQL = "select * from tbldevicecommand where 1=1 $where order by modelId";
                  $pagerstring = Pages($linkSQL,PER_PAGE_ROWS,'manage_gps_cmd.php?',$token);
                  if(isset($_SESSION['linkSQL']))
                  $mSQL=$_SESSION['linkSQL']." ".$_SESSION['limit'];
                  $oRS = mysql_query($mSQL); 
                  ?>
                  <thead>
                    <tr>
                      <th><small>S. No.</small></th>     
                      <th><small>Model</small></th>
                      <th><small>IP</small></th> 
                      <th><small>Apn</small></th> 
                      <th><small>Time Zone</small></th> 
                      <th><small>Data Intervel</small></th> 
                      <th><small>Device Info</small></th>  
                      <th><small>Device Status</small></th> 
                      <th><small>Config</small></th>    
                      <th><small>Action &nbsp;             
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
                      &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>
                      </th>   
                    </tr> 
                  </thead> 
                  <tbody>  
                    <?php
                    $kolor=1;
                    if(mysql_num_rows($oRS)>0){
                      while ($row = mysql_fetch_array($oRS)){
                    ?>
                    <tr>
                      <td><small><?php print $kolor++;?>.</small></td>
                      <td><small><?php echo getdevicename(stripslashes($row["modelId"]));?></small></td>
                      <td><small><?php echo stripslashes($row["ipCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["apnCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["timeZoneCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["dataIntervelCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["deviceInfoCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["deviceStatusCmd"]);?></small></td>
                      <td><small><?php echo stripslashes($row["configCmd"]);?></small></td>
                      <td>
                        <a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_gps_cmd.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " >
                          <img src="images/drop.png" title="Delete" border="0" />
                        </a>
                        <a href="add_gps_cmd.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>">
                          <img src='images/edit.png' title='Edit' border='0' />
                        </a>
                        &nbsp;&nbsp;
                        <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                    </tr>
                    <?php 
                      }
                    }
                    ?>
                  </tbody>
                </table>
               </div> <!-- end table-responsive -->
          </form>
              </div><!-- /.box-body -->
          </div> <!-- end box-info -->
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
<!-- <script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script> -->
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
</body>
</html>
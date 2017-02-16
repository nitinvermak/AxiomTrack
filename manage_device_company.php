<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']==''){
    session_destroy();
    header("location: index.php?token=".$token);
}
if(isset($_POST['delete_selected'])){
    foreach($_POST['linkID'] as $chckvalue){
        $sql = "DELETE FROM tbldevicecompany WHERE id='$chckvalue'";
        $result = mysql_query($sql);
    }
    if($result){
        $msgDanger = "Records Deleted Successfully";
    }
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
        Device Company  Details
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Device Company  Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form name='fullform' method='post' onSubmit="return confirmdelete()">
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                       <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('device_company.php?token=<?php echo $token ?>')"/>
                       &nbsp;&nbsp;&nbsp;
                       <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <div id="dvData" class="table-responsive">
                    <?php if(isset($msgDanger) && $msgDanger !="") {?>
                    <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <?= $msgDanger;?>
                    </div>
                    <?php 
                    }
                    ?>
                    <?php if(isset($_SESSION['sess_msg']) && $_SESSION['sess_msg'] !="") {?>
                    <div class="alert alert-success alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <?= $_SESSION['sess_msg'];?>
                    </div>
                    <?php 
                    }
                    ?>
                    <table class="table table-hover table-bordered ">
                    <?php
                    $where='';
                    $linkSQL="";  
                    if(!isset($linkSQL) or $linkSQL =='')     
                    $linkSQL = "select * from tbldevicecompany where 1=1 $where order by name"; 
                    $pagerstring = Pages($linkSQL,PER_PAGE_ROWS,'manage_device_company.php?',$token);
                    if(isset($_SESSION['linkSQL']))
                    $mSQL=$_SESSION['linkSQL']." ".$_SESSION['limit'];
                    $oRS = mysql_query($mSQL); 
                    ?>
                    <tr>
                        <th><small>S. No.</small></th>     
                        <th><small>Company Name</small></th>    
                        <th><small>Action              
                            <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
                            &nbsp;&nbsp;
                            <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small></th>   
                    </tr>    
                    <?php
                    $kolor=1;
                    if(isset($_GET['page']) and is_null($_GET['page'])){ 
                        $kolor = 1;
                    }
                    elseif(isset($_GET['page']) and $_GET['page']==1){ 
                        $kolor = 1;
                    }
                    elseif(isset($_GET['page']) and $_GET['page']>1){
                        $kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
                    }
                    if(mysql_num_rows($oRS)>0){
                    while ($row = mysql_fetch_array($oRS)){
                    ?>
                    <tr>
                        <td><small><?php print $kolor++;?>.</small></td>
                        <td><small><?php echo stripslashes($row["name"]);?></small></td>
                        <td><?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='transusers_del.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="device_company.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="change_password.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
                    </tr>
                <?php }
                    echo $pagerstring;
                    }
                    else
                        echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
                ?> 
                </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </form>
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
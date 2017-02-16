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
    $delete_single_row = "DELETE FROM tblbranch WHERE id='$id'";
    $delete = mysql_query($delete_single_row);
}
if($delete){
    $msgDanger = "Record Delted Successfully";
}
//End
//Delete multiple records
if(isset($_POST['delete_selected'])){
        foreach($_POST['linkID'] as $chckvalue){
            $sql = "DELETE FROM tblbranch WHERE id='$chckvalue'";
            $result = mysql_query($sql);
        }
        if($result){
           $msgDanger = "Records Deleted Successfully";
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
        Branch Details
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Branch Details</li>
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
                       <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('add_branch.php?token=<?php echo $token ?>')"/>
                       &nbsp;
                       <input type="submit" name="delete_selected" onClick="return val();" class="btn btn-primary btn-sm" value="Delete Selected">
                    </div> <!-- end custom field -->
                   
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
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
                    <table id="example" class="table table-hover table-bordered ">
                        <thead>
                        <?php    
                        $linkSQL = "select * from tblbranch  order by id desc";
                        $oRS = mysql_query($linkSQL); 
                        ?>                      
                            <tr>
                                <th><small>S. No.</small></th>     
                                <th><small>Company Name</small></th>  
                                <th><small>Address</small></th>  
                                <th><small>City</small></th>
                                <th><small>State</small></th>
                                <th><small>Pincode</small></th>
                                <th><small>Contact Person</small></th>
                                <th><small>Phone</small></th>
                                <th><small>Category</small></th>
                                <th><small>Action<br>             
                                    <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
                                    &nbsp;&nbsp;
                                    <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small></th>   
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
                                <td><small><?php echo stripslashes($row["CompanyName"]);?></small></td>
                                <td><small><?php echo stripslashes($row["Address"]);?></small></td>
                                <td><small>
                                <?php 
                                if($row["city"] ==0){
                                    echo "N/A";
                                }
                                else{
                                    echo getcities(stripslashes($row["city"]));
                                }
                                ?>
                                </small></td>
                                <td><small>
                                <?php 
                                if($row["State"] == 0){
                                    echo "N/A";
                                }
                                else{
                                    echo getstate(stripslashes($row["State"]));
                                }
                                ?>
                                </small></td>
                                <td>
                                <small>
                                <?php if($row["pincode"] == 0){
                                    echo "N/A";
                                }
                                else{
                                    echo getpincode(stripslashes($row["pincode"]));
                                }
                                ?>
                                </small></td>
                                <td><small><?php echo stripslashes($row["contact_Person"]);?></small></td>
                                <td><small><?php echo stripslashes($row["contact_no"]);?></small></td>
                                <td><small><?php echo stripslashes($row["branchtype"]);?></small></td>
                                <td> <?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_branch.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="add_branch.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?> <a href="add_branch.php?cid=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
                            </tr>
                        </tbody>
                            <?php }
                            // echo $pagerstring;
                            }
                            ?> 
                        </tbody>
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
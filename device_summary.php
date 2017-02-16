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
$sql = "select * from tbl_device_master where status=0";
$result = mysql_query($sql);
$inStock = mysql_num_rows($result);
$totalInstock = $inStock;

$sql = "select * from tbl_device_master where status=1";
$result = mysql_query($sql);
$installed = mysql_num_rows($result);
$totalInstalled = $installed;

$sql = "select * from tbl_device_master where status=2";
$result = mysql_query($sql);
$reIssue = mysql_num_rows($result);
$totalreIssue = $reIssue;


$sql = "select * from tbl_device_master where status=3";
$result = mysql_query($sql);
$Close = mysql_num_rows($result);
$totalClose = $Close;

$sql = "select * from tbl_device_master";
$result = mysql_query($sql);
$total = mysql_num_rows($result);
$totaldevice = $total;

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
function SearchRecords(){   
      search_box = document.getElementById("search_box").value;
    /*alert(search_box);*/
    url="ajaxrequest/sim_report.php?search_box="+search_box+"&token=<?php echo $token;?>";
    /*alert(url);*/
    xmlhttpPost(url,search_box,"GetRecords");
}
function GetRecords(str){
  document.getElementById('divassign').innerHTML=str;
}
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
          Device Summary
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Device Summary</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
          <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                  <table class="table table-hover table-bordered">
                    <tr>
                    <th><center>S. No.</center></th>
                    <th><center>Instock</center></th>
                    <th><center>Installed</center></th>
                    <th><center>Reissue</center></th>
                    <th><center>Permanatly Closed</center></th>
                    <th><center>Total</center></th>
                    </tr>
                    <tr>
                    <td>1.</td>
                    <td><center><a data-toggle="modal" data-target=".<?php echo "inStock".$totalInstock;?>"><strong><?php echo $totalInstock;?></strong></a></center>
                        <div class="modal fade <?php echo "inStock".$totalInstock;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <h4 class="modal-title" id="exampleModalLabel">InStock Devices</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                       
                                        <tr>
                                        <th><center>S. No.</center></th>
                                        <th><center>Device Id</center></th>
                                        <th><center>Assign Status</center></th>
                                        <th><center>Branch</center></th>
                                        </tr>
                                        <?php 
                            $query = mysql_query("select * from tbl_device_master where status=0");
                            while ($row = mysql_fetch_array($query)) {
                            ?>
                                        <tr>
                                        <td><small></small></td>
                                        <td><?php echo stripslashes($row["id"]);?></td>
                                        <td></td>
                                        <td></td>
                                </tr>
                                        <?php } ?>
                                        </table>
                                     </div>
                                  </div>
                              </div>
                            </div>
                         </div>
                    </td>
                    <td><center><?php echo $totalInstalled;?></center></td>
                    <td><center><?php echo $totalreIssue;?></center></td>
                    <td><center><?php echo $totalClose?></center></td>
                    <td><center><?php echo $totaldevice; ?></center></td>
                    </tr>
                    </table>
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
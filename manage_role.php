<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ){
    session_destroy();
    header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') {
    session_destroy();
    header("location: index.php?token=".$token);
}
if(isset($_POST['save'])){
    $Usercategory = mysql_real_escape_string($_POST['Usercategory']);
    $checkUserCat = mysql_query("SELECT * FROM tblusercategorymodulemapping 
                                 WHERE usercategoryId='$Usercategory'");
    if(mysql_num_rows($Usercategory) >= 0){
        $sqlDel = "DELETE FROM tblusercategorymodulemapping WHERE usercategoryId =".$Usercategory;
        //echo $sqlDel.'asfasf';
        mysql_query($sqlDel);
        foreach($_POST['list'] as $checkvalue){
            $sql = "Insert into tblusercategorymodulemapping set moduleId = '$checkvalue', 
                    usercategoryId = '$Usercategory', created = Now()";
            /*echo $sql.'<br>';*/
            $result = mysql_query($sql);
            if($result){
                    $msg = "Setting Saved !";
            }
        }
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
<script src="js/checkbox_validation.js"></script>
<script type="text/javascript">
/* Send ajax request*/
$(document).ready(function(){
    $("#Usercategory").change(function(){
        $.post("ajaxrequest/show_role_UserCategory.php?token=<?php echo $token;?>",
        {
            UserCat : $('#Usercategory').val(),
        },
        function( data){
            /*alert(data);*/
            $("#divassign").html(data);
        });  
    });
});
$(document).on('click','#chkAll',function(){
    $(".perCheck1").prop("checked",$("#chkAll").prop("checked"))
     
});
function checkPermission(classA){
 
    ClassB= ".perCheck"+classA;

    //$(ClassB).prop("checked",true)
    
    if($(ClassB).is(':checked'))
        $(ClassB).prop("checked",false)
    else
        $(ClassB).prop("checked",true)
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
        User Category
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Category</li>
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
                        <label for="exampleInputEmail2">User Category</label>
                        <select name="Usercategory" class="form-control select2" style="width: 100%" 
                            id="Usercategory">
                            <option label="" value="">Select User Category</option>
                            <?php $Country=mysql_query("SELECT * FROM tblusercategory ORDER BY User_Category ASC ");
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['User_Category'])); ?></option>
                            <?php } ?> 
                        </select>
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <div id="divassign" class="table-responsive">
                    <?php if(isset($msg) && $msg !="") {?>
                    <div class="alert alert-danger alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <?= $msg;?>
                    </div>
                    <?php 
                    }
                    ?>
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
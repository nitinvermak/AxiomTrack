<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
}
if(isset($_POST['send']))
{
    //Your authentication key
    $authKey = "2763A765rdm1CXD561227a2";
    
    //Multiple mobiles numbers separated by comma
    $mobileNumber = $_POST['mobileno'];
    $messageText = $_POST['message'];
    //Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = "Indtrk";
    
    //Your message to send, Add URL encoding here.
    $message = urlencode($messageText);
    
    //Define route 
    $route = "4";
    //Prepare you post parameters
    $postData = array(
        'authkey' => $authKey,
        'mobiles' => $mobileNumber,
        'message' => $message,
        'sender' => $senderId,
        'route' => $route
    );
    
    //API URL
    $url="http://sms.bulk24sms.com/sendhttp.php";
    
    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));
    
    
    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    
    
    //get response
    $output = curl_exec($ch);
    
    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    
    curl_close($ch);
    $result = $output;
    // echo $result;
    if($result)
    {
        $msg = "Message Sent !";
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
<script type="text/javascript" src="js/checkbox_validation_confirmation_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
function chkcontactform(obj)
{
    if(obj.mobileno.value == "")
        {
            alert("Please Provide Mobile No.");
            obj.mobileno.focus();
            return false;
        }
    if(obj.message.value == "")
        {
            alert("Please Provide Message");
            obj.message.focus();
            return false;
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
        Send SMS
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Send SMS</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
<!--               <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <div class="small-form">
                    <?php if(isset($msg)){?>
                    <div class="alert alert-success alert-dismissible small-alert" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                    </div>
                    <?php 
                    }
                    ?>
                    <form method="post" name="smsform" action="" onSubmit="return chkcontactform(this)">
                        <div class="form-group">
                            <label for="To">Mobile No.</label>
                            <input type="text" name="mobileno" id="mobileno" class="form-control text_box" />
                        </div>
                        <div class="form-group">
                            <label for="Message">Message</label>
                            <textarea cols="16" rows="3" name="message" id="message" class="form-control txt_area"></textarea>
                        </div>
                        <input type="submit" name="send" id="send" value="Send SMS" class="btn btn-primary btn-sm" />
                    </form>
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
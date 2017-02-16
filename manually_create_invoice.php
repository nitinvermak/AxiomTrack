<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    header("location: index.php?token=".$token);
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
<script  src="js/ajax.js"></script>
<script>
/* Send ajax request*/
$(document).ready(function(){
    $("#company").change(function(){
        $.post("ajaxrequest/manually_invoice.php?token=<?php echo $token;?>",
        {
            cust_id : $('#company').val(),
        },
        function( data){
            /*alert(data);*/
            $("#divassign").html(data);
            // $('#example').DataTable({ "bPaginate": false });
            $('body').on('focus',".next_due_date", function(){
            $( '.next_due_date' ).datepicker({dateFormat: 'yy-mm-dd'});
        });
    });  
    });
});
/* End */

// Send Data via ajax request
function getData(){
    $('.loader').show();
    jsonArr = []
    $(".next_due_date").each(function(){
        jsonArr.push({"id":$(this).attr('id')+'='+$(this).val()});
    });
    console.log(jsonArr);
    url="ajaxrequest/manually_invoice_next_due_date.php?token=<?php echo $token;?>";
    postData = {'PostData': jsonArr };
    xmlhttpPost(url,JSON.stringify(jsonArr),"GetResponseA");
}
function GetResponseA(str){
          document.getElementById('dvShow').innerHTML=str;
          $(".loader").removeAttr("disabled");
          $('.loader').fadeOut(1000);
} 
// end
// Copy textbox value 
function makeAllDateSame()
{
    //alert("Check box changed");
    var firstTextBoxValue="";
    var i=0;
    $('#example').find('input.next_due_date').each(function(){
        if(i==0)
        {
            firstTextBoxValue=$(this).val();
        }
        else
        {
            $(this).val(firstTextBoxValue);
        }
        $(this).id;
        i++;
        //console.log($(this).val()+"ID="+$(this).ID);
    });
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
        Manually Create Invoice
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manually Create Invoice</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Company <i class="red">*</i></span>
                        <select name="company" id="company" class="form-control select2" style="width: 100%">
                            <option value="">Select Company</option>
                            <?php $Country=mysql_query("SELECT DISTINCT A.cust_id as cust_id, 
                                                        C.Company_Name as Company_Name, A.callingdata_id
                                                        FROM tbl_customer_master as A
                                                        INNER JOIN tblcallingdata as C 
                                                        ON A.callingdata_id = C.id ORDER BY C.Company_Name");
                            
                                  while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['cust_id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <!-- <h3 class="box-title">Details</h3> -->
            </div>
            <div class="box-body">
                <?php if(isset($msg)){?>
                <div class="alert alert-success alert-dismissible small-alert" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-check-circle" aria-hidden="true"></i></strong> <?= $msg; ?>
                </div>
                <?php 
                }
                ?>
                <div id="dvShow" class="table-responsive">
                    <!-- Show Content from ajax page -->
                </div>
                <div id="divassign" class="table-responsive">
                  <!-- this division shows the Data of devices from Ajax request -->
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
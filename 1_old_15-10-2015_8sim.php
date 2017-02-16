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
<script type="text/javascript" src="js/checkbox.js"></script>
<script>
 $(function() {
    $( "#date_of_purchase" ).datepicker({dateFormat: 'yy-mm-dd'});
    //Initialize Select2 Elements
});
 // send ajax request when select branch
$(document).ready(function(){
    $("#branch").change(function(){
        $('.loader').show();
        $.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
                {
                    branch : $('#branch').val()
                },
                    function(data){
                        /*alert(data);*/
                        $("#showTechnician").html(data);
                        $(".select2").select2();
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });
    });
});
// End
$(document).ready(function(){
    $('#deviceId').click(function(){
        $('.loader').show();
        $.post("ajaxrequest/device_report.php?token=<?php echo $token;?>",
                {
                    search_box : $('#search_box').val()
                },
                    function(data){
                        /*alert(data);*/
                        $("#dvData").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                }); 
    });
});
// send ajax request when click submit
function getReport()
{
    $('.loader').show();
    $.post("ajaxrequest/device_report_details.php?token=<?php echo $token;?>",
                {
                    branch : $('#branch').val(),
                    installedStatus : $('#installedStatus').val(),
                    executive : $('#executive').val()
                    /*assignStatus : $('#assignStatus').val(),*/
                },
                    function(data){
                        /*alert(data);*/
                        $("#dvData").html(data);
                        $(".loader").removeAttr("disabled");
                        $('.loader').fadeOut(1000);
                });
}
// end
// export CSV
$(document).ready(function () {
     console.log("HELLO")
            function exportTableToCSV($table, filename) {
                console.log("HELLO")
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
          $(document).on("click","#export", function(){
                // var outputFile = 'export'
                var outputFile = window.prompt("Please Enter the name your output file.") || 'deviceReport';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData > table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
         })
//end
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
        Device Report
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Device Report</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="form-group form_custom col-md-12"> <!-- form Custom -->
                <div class="row"><!-- row -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Branch <i class="red">*</i></span>
                        <select name="branch" id="branch" class="form-control select2" style="width: 100%">
                            <?php 
                            $branch_sql= "select * from tblbranch ";
                            $authorized_branches = BranchLogin($_SESSION['user_id']);
                            //echo $authorized_branches;
                            if ( $authorized_branches != '0'){
                                $branch_sql = $branch_sql.' where id in '.$authorized_branches;     
                            }
                            if($authorized_branches == '0'){
                                echo'<option value="0">All</option>';   
                            }
                            else{
                                echo'<option value="">--Select--</option>';
                            }
                            //echo $branch_sql;
                            $Country = mysql_query($branch_sql);                    
                            while($resultCountry=mysql_fetch_assoc($Country)){
                            ?>
                            <option value="<?php echo $resultCountry['id']; ?>" >
                                <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Status <i class="red">*</i></span>
                        <select name="installedStatus" id="installedStatus" class="form-control select2" style="width: 100%">
                           <option value="" selected>All</option>
                           <option value="0">Instock</option>
                           <option value="1">Installed</option>
                        </select> 
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
                        <span>Executive <i class="red">*</i></span>
                        <span id="showTechnician">
                            <select name="executive" id="executive" class="form-control select2" style="width: 100%">
                                <option value="">Select Executive</option>
                            </select>
                        </span>
                    </div> <!-- end custom field -->
                    <div class="col-lg-6 col-sm-6 custom_field">
                        <span>&nbsp;</span><br>
                        <input type="button" name="submit" value="Submit" onClick="getReport();" class="btn btn-primary btn-sm"/> 
                    </div>
                </div><!-- end row -->                
            </div><!-- End From Custom -->
        </div>
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Details</h3>
            </div>
            <div class="box-body">
                <div id="dvData" class="table-responsive">
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
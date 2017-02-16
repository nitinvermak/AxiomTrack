<?php
session_start();
include "../affconfig.php";
include "./lang/$language";
include "include/general_function.php";
if(!aff_check_security())
	{
    	aff_redirect('index.php');
    	exit;
  	}
mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error (line 16)"); 
$result = mysql_db_query($database, "select * from clientmaster order by clnt_id") or die(mysql_error); //query1
$sql = "SELECT A.caseRefNo as caseRefNo, A.instructionId as instructionId, A.candidateName as candidateName,
		A.completeAddress as address, A.posFrom as periodFrom, A.posTo as periodTo, A.fatherName as fatherName,
		A.contactNo as candidateContactNo, C.houseStatus as ownershipStatus, C.typeOfAddress as typeOfAddress,
		C.Landmark as landmark, C.remarks as verifierCommnt, C.contactPersonName as verifierName, 
		C.contactNo as verifierContactNo, C.relation as verifierRelation, C.photoStatus as photoStatus, 
		C.signatureStatus as signature, B.executiveId as executiveId, C.status as executiveRemark, C.vistiDateTime as visitDate,
		C.visittime as visitTime
		FROM addressverification as A 
		INNER JOIN addressverificationcaseassign as B 
		ON A.id = B.adVeriCaseId
		INNER JOIN addressreport as C 
		ON A.id = C.addressCaseId
		WHERE A.id =".$_GET['id'];
$result = mysql_db_query($database, $sql);
while($row = mysql_fetch_assoc($result)){
	$caseRefNo = $row['caseRefNo'];
	$instructionId = $row['instructionId'];
	$candidateName = $row['candidateName'];
	$address = $row['address'];
	$periodFrom = $row['periodFrom'];
	$periodTo = $row['periodTo'];
	$fatherName = $row['fatherName'];
	$candidateContactNo = $row['candidateContactNo'];
	$ownershipStatus = $row['ownershipStatus'];
	$typeOfAddress = $row['typeOfAddress'];
	$landmark = $row['landmark'];
	$verifierCommnt = $row['verifierCommnt'];
	$verifierName = $row['verifierName'];
	$verifierContactNo = $row['verifierContactNo'];
	$verifierRelation = $row['verifierRelation'];
	$photoStatus = $row['photoStatus'];
	$signature = $row['signature'];
	$executiveId = $row['executiveId'];
	$executiveRemark = $row['executiveRemark'];
	$visitDate = $row['visitDate'];
	$visitTime = $row['visitTime'];
}

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">
    <!-- Jquery Latest CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
   
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
           <section class="invoice">
           <form method="post" action="">
            <div id="content">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-globe"></i> SPN
                    <small class="pull-right">Date: 2/10/2014</small>          </h2>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <!--<div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>-->
                <!-- /.col -->
                <!--<div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                  </address>
                </div>-->
                <!-- /.col -->
                <!--<div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
                </div>-->
                <!-- /.col -->
              </div>
              <!-- /.row -->
        
              <!-- Table row -->
              <div class="row">
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th colspan="5"><center>Employee Residental Address Verification</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><strong>Case Reference No.</strong></td>
                      <td colspan="2"><?= $caseRefNo; ?></td>
                      <td><strong>Instruction Id No.</strong></td>
                      <td><?= $instructionId; ?></td>
                      
                    </tr>
                    <tr>
                      <td><strong>Name Of Candidate</strong></td>
                      <td colspan="4"><?= $candidateName; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Address of the Candidate</strong></td>
                      <td colspan="4"><?= $address; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Period of Stay</strong></td>
                      <td><strong>From</strong></td>
                      <td><?= $periodFrom; ?></td>
                      <td><strong>To</strong></td>
                      <td><?= $periodTo; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Father's Name</strong></td>
                      <td colspan="4"><?= $fatherName; ?></td>
                    </tr>
                    <tr>
                      <td><strong>Candidate Contact No.</strong></td>
                      <td colspan="4"><?= $candidateContactNo; ?></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
                <div class="col-xs-12" style="padding:0">
                    <div class="col-sm-6 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th>Particulars</th>
                                  <th>Verifier Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span><strong>Ownership Status</strong> (Owned / Rented / Other)</span></td>
                                    <td><?= $ownershipStatus; ?></td>
                                </tr>
                                <tr>
                                    <td><span><strong>Type of Address</strong> (Present / Permanent / Previous)</span></td>
                                    <td><?= $typeOfAddress; ?></td>
                                </tr>
                                <tr>
                                    <td><span><strong>Nearest Landmark</strong> (100 Meteres of Address)</span></td>
                                    <td><?= $landmark; ?></td>
                                </tr>
                            </tbody>
                       </table>
                    </div>
                    <div class="col-sm-6 table-responsive">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                      <th colspan="4"><center>Period of Stay</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span><strong>From</strong></span></td>
                                        <td>1992</td>
                                        <td><span><strong>To</strong></span></td>
                                        <td>2006</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><strong>Additional Comments From Verifier</strong></td>
                                    </tr>
                                     <tr>
                                        <td colspan="4"><?= $verifierCommnt; ?></td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div><!-- End col -->
                <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="col-xs-6"><strong>Verifer Name</strong></td>
                            <td><?= $verifierName; ?></td>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><strong>Verifier Contact Details</strong></td>
                            <td><?= $verifierContactNo; ?></td>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><strong>Relationship with Candidate</strong></td>
                            <td><?= $verifierRelation; ?></td>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><strong>Photograph matches with the Candidate</strong> (Photo matched / Not Provided)</td>
                            <td><?= $photoStatus ; ?></td>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><span><strong><u>Verifier Signature</u></strong><br>In case the field executive asks for any money or other favors, request you not to entertain the same, contact us immediately on the number: 080-42529339 / 022-40697925 / 09738199205 / 09819223465. You can also contact us via email: venkatarama.raju@fadv.com</span></td>
                            <td><?= $signature; ?></td>
                        </tr>
                        <tr>
                            <td class="col-xs-6"><span><strong><u>Verifier's Address / Location</u></strong> (Information provided will be only used for confirming the authenticity of the verification)</span></td>
                            <td></td>
                        </tr>
                    </tbody>
                  </table>
               </div> <!-- end col -->
               <div class="col-xs-12 table-responsive">
                  <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Field Executive's Name</strong></td>
                            <td><?= getExecutive($executiveId); ?></td>
                            <td><strong>Date of Visit</strong></td>
                            <td><?= $visitDate; ?></td>
                            <td><strong>Time of Visit</strong></td>
                            <td><?= $visitTime; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Field Executive's Remarks</strong></td>
                            <td colspan="3"><?= $executiveRemark; ?></td>
                            <td><strong>Field Executive's Signature</strong></td>
                            <td colspan="2"></td>
                       </tr>
                    </tbody>
                  </table>
                  This document is the property of First Advantage Private Limited if found anywhere please contact us on the below address or call us on 080-42529339 / 022-40697925 / 09738199205. You can also contact us via email: <u><strong>venkataram.raju@fadv.com</strong></u>
               </div> <!-- end col -->
              </div>
              <!-- /.row -->
              </div> <!--end content-->
              <!-- this row will not appear when printing -->
              
           </form>  
        </section>
        <div class="clearfix"></div>
      </div><!-- /.content-wrapper -->
	<!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
     <!-- PDF -->
    <script src="js/jspdf.min.js"></script>
    <script>
		var doc = new jsPDF();
		var specialElementHandlers = {
			'#editor': function (element, renderer) {
				return true;
			}
		};
		
		$('#cmd').click(function () {
			doc.fromHTML($('#content').html(), 15, 15, {
				'width': 1600,
					'elementHandlers': specialElementHandlers
			});
			doc.save('sample-file.pdf');
		});
	</script> 
  </body>
</html>

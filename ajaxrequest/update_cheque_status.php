<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$chequeId = mysql_real_escape_string($_POST['chequeId']);
/*echo $chequeId; */
?>

<!----------------- Modal ------------------>

        	<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
            	<span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="gridSystemModalLabel">Update Cheque Status</h4>
      	 	</div>
         	<div class="modal-body">
         		<form method="post">
                <input type="hidden" name="chequeId" id="chequeId" value="<?php echo $chequeId;?>">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="chequeStatus" id="chequeStatus" class="form-control drop_down">
                    	<option value="">Select Status</option>
                    	<option value="Y">Cleared</option>
                        <option value="B">Bounced</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Date</label>
                    <input type="text" class="form-control text_box date" name="date" id="date">
                  </div>
                  <input type="submit" name="updateStatus" id="updateStatus" value="Update" class="btn btn-primary btn-sm"> 
                </form>
         	</div>
          
<!---------------- End Modal --------------->
// JavaScript Document
 function confirmdelete(obj)
 {
 	 if(obj.branch.value == "0" || obj.branch.value == "")
	 {
	 alert('Please Select Branch');
	 obj.branch.focus();
	 return false;
	 }
	 if(obj.technician_id.value == "")
	 {
	 alert('Please Select Technician');
	 obj.technician_id.focus();
	 return false;
	 }
 }
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/assign_device_branch_technician.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponse");
	}
function ViewAssigned()
	{
		technician_id = document.getElementById("technician_id").value;	
		url="ajaxrequest/view_assign_device_technician.php?technician_id="+technician_id+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,technician_id,"getResponse");
	}
function getResponse(str)
	{
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	}
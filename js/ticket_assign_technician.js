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
	
	 if(confirm('Do you really want to Assign this records?'))
	 { 
	 return true;
	 } 
	 else 
	 { 
	 return false;
	 }
 }
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/assign_ticket_branch_technician.php?branch="+branch+"&token=<?php echo $token;?>"; 
		xmlhttpPost(url,branch,"getResponseByBranch");
	}
function ShowByBranchAssigned()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/view_assign_ticket_branch_technician.php?branch="+branch+"&token=<?php echo $token;?>"; 
		xmlhttpPost(url,branch,"getResponseByBranch");
	}
function getResponseByBranch(str)
	{
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	}
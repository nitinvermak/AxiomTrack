// JavaScript Document
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		url="ajaxrequest/assign_sim_branch_technician.php?branch="+branch+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponse");
	}
function ViewAssign()
	{
		technician_id = document.getElementById("technician_id").value;	
		url="ajaxrequest/view_assign_sim_branch_technician.php?technician_id="+technician_id+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,technician_id,"getResponse");
	}
function getResponse(str)
	{
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	}

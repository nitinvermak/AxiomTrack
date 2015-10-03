// JavaScript Document
function ShowProvider()
	{   
	    branch = document.getElementById("branch").value;	 
		sim_provider = document.getElementById("sim_provider").value;
		/*alert(sim_provider);*/
		url="ajaxrequest/show_sim_provider_confirmation.php?branch="+branch+"&sim_provider="+sim_provider+"&token=<?php echo $token;?>";
		
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}
function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		sim_provider = 0; 
		url="ajaxrequest/show_sim_branch_confirmation.php?branch="+branch+"&sim_provider="+sim_provider+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	} 
function getResponseUnassignedStock(str){
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
 function confirmdelete(obj)
 {
 if(obj.branch.value == "" || obj.branch.value == "0")
 {
 alert('Please Select Branch');
 obj.branch.focus();
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
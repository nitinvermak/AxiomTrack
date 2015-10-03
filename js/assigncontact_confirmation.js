// JavaScript Document
function confirmdelete()
 {
 
 if(confirm('Do you really want to Assign this records?'))
 { 
 return true;
 } 
 else 
 { 
 return false;
 }
 }
function ShowbyCategory()
	{   
	    callingcat = document.getElementById("callingcat").value;
		//alert(branch);
		url="ajaxrequest/assigncontacts_branch_confirmation.php?callingcat="+callingcat+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,callingcat,"getResponseUnassignedStock");
	}
	/*function ShowByBranch()
	{
		branch = document.getElementById("branch").value;	
		model = document.getElementById("modelname").value;	 
		url="ajaxrequest/show_branch_device_confirmation.php?branch="+branch+"&model="+model+"&token=<?php echo $token;?>"; 
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}*/
 
	function getResponseUnassignedStock(str){
	//alert(str);
	document.getElementById('divassign').innerHTML=str;
	//document.getElementById('area1').
	//document.getElementById("area1").innerHTML = "";
	//document.getElementById("divpincode").innerHTML = "";
	}
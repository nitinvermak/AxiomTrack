// JavaScript Document
	function showUnassignedStock()
	{   
	    model = document.getElementById("modelname").value;
		//alert(branch);
		url="ajaxrequest/showUnassignedStock.php?model="+model+"&token=<?php echo $token;?>";
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}
	function showAssignedStock()
	{
		branch = document.getElementById("branch").value;	
		model = document.getElementById("modelname").value;	 
		url="ajaxrequest/show_assigned_stock.php?branch="+branch+"&model="+model+"&token=<?php echo $token;?>"; 
		//alert(url);
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}
 
	function getResponseUnassignedStock(str)
	{
		//alert(str);
		document.getElementById('divassign').innerHTML=str;
	}
   	function confirmdelete(obj)
   	{
		/*if(obj.modelname.value == "0")
		{
			alert('Please Select Device Name');
			obj.modelname.focus();
			return false;
		}*/
		if(obj.branch.value == "")
	 	{
			 alert("Please Select Branch");
			 obj.branch.focus();
			 return false;
		}
		if(obj.linkID.checked==false)
		{
			 alert("Please Check Device");
			 obj.linkID.focus();
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
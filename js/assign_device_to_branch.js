// JavaScript Document
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
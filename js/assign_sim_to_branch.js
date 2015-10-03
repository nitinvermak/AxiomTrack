// JavaScript Document
function showUnassignedStock()
	{   
	    sim_provider = document.getElementById("sim_provider").value;
		/*alert(sim_provider);*/
		url="ajaxrequest/show_sim_unassigned.php?sim_provider="+sim_provider+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,branch,"getResponseUnassignedStock");
	}
function showAssignedStock()
	{
		branch = document.getElementById("branch").value;	
		sim_provider = document.getElementById("sim_provider").value;	 
		url="ajaxrequest/show_sim_assigned_stock.php?branch="+branch+"&sim_provider="+sim_provider+"&token=<?php echo $token;?>"; 
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
	
 function checkAll(field)
    {
    for (i = 0; i < field.length; i++)
    	field[i].checked = true ;
    }
    
    function uncheckAll(field)
    {
    for (i = 0; i < field.length; i++)
    	field[i].checked = false ;
    }
   function decision(message, url)
			{
				if(confirm(message))
				{		
				location.href = url;}
			} 
    
   function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{

	if(!document.forms[FormName])
		return;
	
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	
		
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	
	
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
} 
   
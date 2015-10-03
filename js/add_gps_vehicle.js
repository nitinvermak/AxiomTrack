// JavaScript Document
function chkcontactform(obj)
	{
		if(obj.organization.value == "")
		{
			alert("Please Select Organization Name");
			obj.organization.focus();
			return false;
		}
		if(obj.vehicle_no.value == "")
		{
			alert("Please Provide Vehicle No.");
			obj.vehicle_no.focus();
			return false;
		}
		if(obj.technician.value == "")
		{
			alert("Please Select Technician Name");
			obj.technician.focus();
			return false;
		}
		if(obj.mobile_no.value == "")
		{
			alert("Please Select Mobile No");
			obj.mobile_no.focus();
			return false;
		}
		if(obj.device.value == "")
		{
			alert("Please Select Device Id");
			obj.device.focus();
			return false;
		}
		if(obj.server_details.value == "")
		{
			alert("Please Select Server");
			obj.server_details.focus();
			return false;
		}
		if(obj.insatallation_date.value == "")
		{
			alert("Please Provide Installation Date");
			obj.insatallation_date.focus();
			return false;
		}
		
	} 

function ShowMobile()
	{
		technician = document.getElementById("technician").value;	
		url="ajaxrequest/show_sim_assign_technician.php?technician="+technician+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,technician,"getMobile");
		
		url="ajaxrequest/show_device_assign_technician.php?technician="+technician+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,technician,"getDevice");
	}
 
	function getMobile(str){
	document.getElementById('divMobile').innerHTML=str;
	}
	function getDevice (str){
	document.getElementById('divDevice').innerHTML=str;
    }

function ShowIMEIandDeviceName()
	{
		device = document.getElementById("device").value;	
		url="ajaxrequest/show_device_imei_assign_technician.php?device="+device+"&token=<?php echo $token;?>"; 
		/*alert(url);*/
		xmlhttpPost(url,technician,"getIMEI");
		
		url="ajaxrequest/show_device_model_assign_technician.php?device="+device+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,device,"getModel");
	}
	function getIMEI(str){
	document.getElementById('divIMEI').innerHTML=str;
	}
	function getModel(str){
	document.getElementById('getModel').innerHTML=str;
	}
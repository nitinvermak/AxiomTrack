function ShowReport()
	{   
		company = document.getElementById("company").value;
		url="ajaxrequest/show_repair_vehicle.php?company="+company+"&token=<?php echo $token;?>";
		alert(url);
		xmlhttpPost(url,company,"getResponse");
	}
function getResponse(str){
	document.getElementById('divassign').innerHTML=str;
	}
// validation 
function chkcontactform(obj)
	{
		if(obj.technician.value == "")
		{
			alert("Please Select Technician");
			obj.technician.focus();
			return false;
		}
		if(obj.ticketId.value == "")
		{
			alert("Please Select Ticket Id");
			obj.ticketId.focus();
			return false;
		}
		if(obj.organization.value == "")
		{
			alert("Please Select Organization");
			obj.organization.focus();
			return false;
		}
		if(obj.vehicleNo.value == "")
		{
			alert("Please Select Vehicle No");
			obj.vehicleNo.focus();
			return false;
		}
		if(obj.oldmobileNo.value == "")
		{
			alert("Please Select Old Mobile");
			obj.oldmobileNo.focus();
			return false;
		}
		if(obj.olddeviceId.value == "")
		{
			alert("Please Select Old DeviceId");
			obj.olddeviceId.focus();
			return false;
		}
		if(obj.repairType.value == "")
		{
			alert("Please Select Repair Type");
			obj.repairType.focus();
			return false;
		}
		if(obj.mobileNo.value == "")
		{
			alert("Please Select New Mobile");
			obj.mobileNo.focus();
			return false;
		}
		if(obj.deviceId.value == "")
		{
			alert("Please Select New Device Id");
			obj.deviceId.focus();
			return false;
		}
	}
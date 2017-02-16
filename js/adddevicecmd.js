// JavaScript Document
function validate(obj)
{
	if(obj.gpsModel.value == "")
	{
		alert("Please Select Model");
		obj.gpsModel.focus();
		return false;
	}
	if(obj.ip.value == "")
	{
		alert("Please Provide IP Command");
		obj.ip.focus();
		return false;
	}
	if(obj.apn.value == "")
	{
		alert("Please Provide Apn Command");
		obj.apn.focus();
		return false;
	}
	if(obj.timeZone.value == "")
	{
		alert("Please Provide Time Zone Command");
		obj.timeZone.focus();
		return false;
	}
	if(obj.dataIntervel.value == "")
	{
		alert("Please Provide Data Intervel Command");
		obj.dataIntervel.focus();
		return false;
	}
	if(obj.deviceInfo.value == "")
	{
		alert("Please Provide Device Info Command");
		obj.deviceInfo.focus();
		return false;
	}
	if(obj.deviceStatus.value == "")
	{
		alert("Please Provide Device Status Command");
		obj.deviceStatus.focus();
		return false;
	}
}
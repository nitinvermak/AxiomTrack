// JavaScript Document
function validate(obj)
{
	if(obj.companyName.value == "")
	{
		alert("Please Select Company Name");
		obj.companyName.focus();
		return false;
	}
	if(obj.customerId.value == "")
	{
		alert("Please Select Customer Id");
		obj.customerId.focus();
		return false;
	}
	if(obj.name.value == "")
	{
		alert("Please Provide Name");
		obj.name.focus();
		return false;
	}
	if(obj.email.value == "")
	{
		alert("Please Provide Email");
		obj.email.focus();
		return false;
	}
	if(obj.mobile.value == "")
	{
		alert("Please Provide Mobile");
		obj.mobile.focus();
		return false;
	}
	if(obj.username.value == "")
	{
		alert("Please Provide Username");
		obj.username.focus();
		return false;
	}
	if(obj.password.value == "")
	{
		alert("Please Provide Password");
		obj.password.focus();
		return false;
	}
}
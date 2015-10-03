// JavaScript Document
function validate(obj)
	{
		if(obj.device_company.value == "")
		{
			alert ("Please Select Company");
			obj.device_company.focus();
			return false;
		}
		if(obj.device_name.value == "")
		{
			alert ("Please provide Model Name");
			obj.device_name.focus();
			return false;
		}
		if(obj.date_of_purchase.value == "")
		{
			alert("Please provide Date of Purchase");
			obj.date_of_purchase.focus();
			return false;
		}
		if(obj.price.value == "")
		{
			alert("Please provide Price");
			obj.price.focus();
			return false;
		}
		if(obj.imei_no.value == "")
		{
			alert("Please provide IMEI No.");
			obj.imei_no.focus();
			return false;
		}
	}
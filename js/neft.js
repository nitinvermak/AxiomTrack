// JavaScript Document
function validate(obj)
{
	if(obj.organizationName.value == "")
	{
		alert("Please Select Organization");
		obj.organizationName.focus();
		return false;
	}
	if(obj.quickBookRefNo.value == "")
	{
		alert("Please Provide Quick Book Ref. No.");
		obj.quickBookRefNo.focus();
		return false;
	}
	if(obj.onlineTransferAmount.value == "")
	{
		alert("Please Provide Amount");
		obj.onlineTransferAmount.focus();
		return false;
	}
	if(obj.refNo.value == "")
	{
		alert("Please Provide Ref. No.");
		obj.refNo.focus();
		return false;
	}
	if(obj.remarks.value == "")
	{
		alert("Please Provide Remarks");
		obj.remarks.focus();
		return false;
	}
}
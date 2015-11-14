// JavaScript Document
function validate(obj)
{
	if(obj.taxType.value == "")
	{
		alert("Please Select Tax Type");
		obj.taxType.focus();
		return false;
	}
	if(obj.taxRate.value == "")
	{
		alert("Please Select Tax Type");
		obj.taxRate.focus();
		return false;
	}
}
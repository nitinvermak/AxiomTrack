// JavaScript Document
function validate(obj)
{
	if(obj.customer_type.value == "")
	{
		alert("Please Provide Customer Type");
		obj.customer_type.focus();
		return false;
	}
}
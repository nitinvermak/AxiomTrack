// JavaScript Document
function validate(obj)
{
	if(obj.userName.value == "")
	{
		alert("Please Select Username");
		obj.userName.focus();
		return false;
	}
}
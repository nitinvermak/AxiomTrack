// JavaScript Document
function validate(obj)
{
	if(obj.modulename.value == "")
	{
		alert("Please Select Module Name");
		obj.modulename.focus();
		return false;
	}
	if(obj.Usercategory.value == "")
	{
		alert("Please Select User Category");
		obj.Usercategory.focus();
		return false;
	}
}

// JavaScript Document
function validate(obj)
{
	if(obj.district.value == "")
	{
		alert("Please Select District");
		obj.district.focus();
		return false;
	}
	if(obj.city.value == "")
	{
		alert("Please Provide City");
		obj.city.focus();
		return false;
	}
}
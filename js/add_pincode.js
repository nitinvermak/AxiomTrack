// JavaScript Document
function validate(obj)
{
	if(obj.country.value == "")
	{
		alert("Please Select Country");
		obj.country.focus();
		return false;
	}
	if(obj.state.value == "")
	{
		alert("Please Select State");
		obj.state.focus();
		return false;
	}
	if(obj.district.value == "")
	{
		alert("Please Select District");
		obj.district.focus();
		return false;
	}
	if(obj.city.value == "")
	{
		alert("Please Select City");
		obj.city.focus();
		return false;
	}
	if(obj.area.value == "")
	{
		alert("Please Select Area");
		obj.area.focus();
		return false;
	}
	if(obj.pincode.value == "")
	{
		alert("Please Provide Pincode");
		obj.pincode.focus();
		return false;
	}
}
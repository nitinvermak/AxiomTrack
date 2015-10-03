// JavaScript Document
function chkfield(obj)
{
	if(obj.search_box.value == "")
	{
	alert('Please provide Search Criteria');
	obj.search_box.focus();
	return false;
	}
}
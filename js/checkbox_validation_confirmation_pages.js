//Checkbox Validation
function val(){
var chks = document.getElementsByName('linkID[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
break;
}
}
if (hasChecked == false)
{
	alert("Please Select at least One Checkbox");
	return false;
}
else
{
	alert("Do You Really Want to Confirm this Record");
}
return true;
}

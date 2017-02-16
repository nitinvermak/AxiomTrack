// JavaScript Document
//Checkbox Validation
function val()
{
	var chks = document.getElementsByName('linkID[]');
	var hasChecked = false;
	/*alert(chks.length);*/
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
}

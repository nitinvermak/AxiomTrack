// JavaScript Document
 function ShowHideDiv() {
            var status = document.getElementById("status");
            var dv = document.getElementById("dv");
            divclose.style.display = status.value == "1" ? "block" : "none";
			divpp.style.display = status.value == "2" ? "block" : "none";
        }
function chkcontactform(obj)
{
	if(obj.status.value == "")
	{
		alert("Please Select Status");
		obj.status.focus();
		return false;
	}
	if(obj.des.value == "")
	{
		alert("Please Provide Remarks");
		obj.des.focus();
		return false;
	}
}
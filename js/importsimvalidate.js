// JavaScript Document
function chkupload(obj) {
		var allowedFiles = [".csv"];
        var fileUpload = document.getElementById("contactfile");
        var lblError = document.getElementById("lblError");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
		
		if(obj.provider2.value == "")
		{
			alert("Please Select Provider");
			obj.provider2.focus();
			return false;
		}
		if(obj.plan2.value == "")
		{
			alert("Please Select Plan");
			obj.plan2.focus();
			return false;
		}
		if(obj.date2.value == "")
		{
			alert("Please Provide Purchase Date");
			obj.date2.focus();
			return false;
		}
		if(obj.state3.value == "")
		{
			alert("Please Select State");
			obj.state3.focus();
			return false;
		}
		if(obj.contactfile.value == "")
		{
			alert("Please Attach CSV File");
			obj.contactfile.focus();
			return false;
		}
        if (!regex.test(fileUpload.value.toLowerCase())) {
            lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
            return false;
        }
        lblError.innerHTML = "";
        return true;
    }
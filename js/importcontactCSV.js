// JavaScript Document
function chkupload(obj) {
		var allowedFiles = [".csv"];
        var fileUpload = document.getElementById("contactfile");
        var lblError = document.getElementById("lblError");
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
		
		if(obj.datasource1.value == "")
		{
			alert("Please Select Datasource");
			obj.datasource1.focus();
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
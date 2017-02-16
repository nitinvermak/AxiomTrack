// JavaScript Document
function ValidateNotInterested()
{
	if($("#mobile").val() == "" ){
		    $("#mobile").focus();
		   	alert("Please Provide Mobile No.");
		    return false;
		}
	
	if($("#notcontactedRemark").val() == "" ){
		    $("#notcontactedRemark").focus();
		   	alert("Please Select Reason");
		    return false;
		}
}

function InterestedFormValidate()
{
	if($("#mobile").val() == "" ){
		    $("#mobile").focus();
		   	alert("Please Provide Mobile No.");
		    return false;
		}
	
	if($("#firstName").val() == "" ){
		    $("#firstName").focus();
		   	alert("Please Provide First Name");
		    return false;
		}
	
	if($("#lastName").val() == "" ){
		    $("#lastName").focus();
		   	alert("Please Provide Last Name");
		    return false;
		}
	
	if($("#companyName").val() == "" ){
		    $("#companyName").focus();
		   	alert("Please Provide Company Name");
		    return false;
		}
	
	if($("#phone").val() == "" ){
		    $("#phone").focus();
		   	alert("Please Provide Phone No.");
		    return false;
		}
	
	if($("#country").val() == "" ){
		    $("#country").focus();
		   	alert("Please Select Country");
		    return false;
		}
	
	if($("#state").val() == "" ){
		    $("#state").focus();
		   	alert("Please Select State");
		    return false;
		}
	if($("#district").val() == "" ){
		    $("#district").focus();
		   	alert("Please Select District");
		    return false;
		}
	if($("#city").val() == "" ){
		    $("#city").focus();
		   	alert("Please Select City");
		    return false;
		}
	if($("#area").val() == "" ){
		    $("#area").focus();
		   	alert("Please Select Area");
		    return false;
		}
	if($("#pin_code").val() == "" ){
		    $("#pin_code").focus();
		   	alert("Please Provide Pincode");
		    return false;
		}
	if($("#address").val() == "" ){
		    $("#address").focus();
		   	alert("Please Provide Address");
		    return false;
		}
	if($("#datasource").val() == "" ){
		    $("#datasource").focus();
		   	alert("Please Select Datasource");
		    return false;
		}
	if($("#callingProduct").val() == "" ){
		    $("#callingProduct").focus();
		   	alert("Please Select Calling Product");
		    return false;
		}
	if($("#callingDate").val() == "" ){
		    $("#callingDate").focus();
		   	alert("Please Provide Calling Date");
		    return false;
		}
	if($("#model").val() == "" ){
		    $("#model").focus();
		   	alert("Please Select Model");
		    return false;
		}
}

function FormNotInterestedValidate()
{
	if($("#mobile").val() == "" ){
		    $("#mobile").focus();
		   	alert("Please Provide Mobile");
		    return false;
		}
	
	if($("#notInterestedReason").val() == "" ){
		    $("#notInterestedReason").focus();
		   	alert("Please Select Reason");
		    return false;
		}
}
function singlecontact() {
    document.getElementById("contactform").style.display = "";
	document.getElementById("contactUpload").style.display = "none";
	
}

function multiplecontact() {
//alert("test");
   document.getElementById("contactform").style.display = "none";
document.getElementById("contactUpload").style.display = "";
}

function validate(obj){
	if(obj.plan_category.value=="3" && obj.provider.value == "")
	{
	alert("Select Service Provider");
	obj.plan_category.focus();
	return false;
	} 
	if(obj.plan_category.value == "")
	{
	alert("Please Select Plan Category");
	obj.plan_category.focus();
	return false;
	}
	if(obj.plan_category.value!="3")
	{
	if(obj.plan_name.value == "")
	{
	alert ("Please provide Plan Name");
	obj.plan_name.focus();
	return false;
	}
	if(obj.plan_description.value == "")
	{
	alert("Please provide Description");
	obj.plan_description.focus();
	return false;
	}
	}

	if(obj.plan_price.value == "")
	{
	alert("Please provide Plan Price");
	obj.plan_price.focus();
	return false;
	}
	var num = /^[1.0-9.0]*$/;
	if(num.test(obj.plan_price.value) == false)
	{
	alert("Please provide valid Price");
	obj.plan_price.focus();
	return false;
	}


}
function divshow(strval)
{
	if(strval=="3")
	{
	 document.getElementById("plan_name").disabled="disabled";
	document.getElementById("plan_description").disabled="disabled";
    document.getElementById("service_provider").style.display = "";
	}
	else
	{
	 document.getElementById("plan_name").disabled="";
	document.getElementById("plan_description").disabled="";
	document.getElementById("service_provider").style.display = "none";

	}
}
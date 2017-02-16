function validate(obj){
	if(obj.moduleCategory.value == ""){
		alert("Please Select Module Category");
		obj.moduleCategory.focus();
		return false;
	}
	if(obj.parentModule.value == ""){
		alert("Please Provide Parent Module");
		obj.parentModule.focus();
		return false;
	}
}
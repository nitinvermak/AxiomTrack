// Form Validation
$(document).ready(function(){
	$("#submit").click(function(){
		if($("#bankName").val() =="")
		{
			alert('Please Provide Bank Name');
			$("#bankName").focus();
			return false;
			
		}
	});
});
// End
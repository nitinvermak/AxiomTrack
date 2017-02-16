	 $(function () {
        $("#cash").click(function () {
            if ($(this).is(":checked")) {
                $("#cashAmount").removeAttr("disabled");
                $("#cashAmount").focus();
            } else {
                $("#cashAmount").attr("disabled", "disabled");
            }
        });
    });
	$(function () {
        $("#cheque").click(function () {
            if ($(this).is(":checked")) {
                $("#chequeNo").removeAttr("disabled");
                $("#chequeNo").focus();
				$("#chequeDate").removeAttr("disabled");
				/*$("#chequeDate").focus();*/
				$("#bank").removeAttr("disabled");
				$("#amountCheque").removeAttr("disabled");
				$("#depositDate").removeAttr("disabled");
            } else {
                $("#chequeNo").attr("disabled", "disabled");
				$("#chequeDate").attr("disabled","disabled");
				$("#bank").attr("disabled","disabled");
				$("#amountCheque").attr("disabled","disabled");
				$("#depositDate").attr("disabled","disabled");
            }
        });
    });
	$(function () {
        $("#onlineTransfer").click(function () {
            if ($(this).is(":checked")) {
                $("#onlineTransferAmount").removeAttr("disabled");
                $("#onlineTransferAmount").focus();
				$("#refNo").removeAttr("disabled");
            } else {
                $("#onlineTransferAmount").attr("disabled", "disabled");
				$("#refNo").attr("disabled","disabled");
            }
        });
    });

// form Validation

$(document).ready(function(){
	$('#submit').click(function(){
		if($("#organizationName").val() == "" ){
		    $("#organizationName").focus();
		    alert("Please Select Organization");
		    return false;
		}	
		else if($("#cash").prop('checked') == true)
		{
			if($("#cashAmount").val() == "" ){
		    $("#cashAmount").focus();
		   	alert("Please Enter Cash Amount");
		    return false;
			}
		}
		else if($('#cheque').prop('checked') == true)
		{
			if($("#chequeNo").val() == "" ){
		    $("#chequeNo").focus();
		    alert("Please Enter Cheque No");
		    return false;
			}
			else if($("#chequeDate").val() == "" ){
		    $("#chequeDate").focus();
		    alert("Please Enter Cheque Date");
		    return false;
			}
			else if($("#bank").val() == "" ){
		    $("#bank").focus();
		    alert("Please Enter Bank");
		    return false;
			}
			else if($("#amountCheque").val() == "" ){
		    $("#amountCheque").focus();
		    alert("Please Enter Cheque Amount");
		    return false;
			}
			else if($("#depositDate").val() == "" ){
		    $("#depositDate").focus();
		    alert("Please Enter Bank Deposit Date");
		    return false;
			}
		}
		else if($('#onlineTransfer').prop('checked') == true)
		{
			if($("#onlineTransferAmount").val() == "" ){
		    $("#onlineTransferAmount").focus();
		    alert("Please Enter Amount");
		    return false;
			}
			if($("#refNo").val() == "" ){
		    $("#refNo").focus();
		    alert("Please Enter Reference Number");
		    return false;
			}
		}
		else
		{
			alert('Please Select Payment Type');
			return false;
		}		 
	});
	
});

//end
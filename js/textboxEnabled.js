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
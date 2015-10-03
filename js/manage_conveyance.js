$(document).ready(function(){
		$("#findRecords").click(function(){
			/*alert('afsda');*/
			$('.loader').show();
			$.post("ajaxrequest/show_conveyance_records.php?token=<?php echo $token;?>",
				{
					dateFrom : $('#dateFrom').val(),
					dateto	 : $('#dateto').val(),
					users	 : $('#users').val()
				},
					function( data ){
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
            			$('.loader').fadeOut(1000);
				});	 
		});
});
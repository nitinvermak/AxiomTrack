<!DOCTYPE html>
<html>
<head>
    <title></title>
	<meta charset="utf-8" />
    <script src="js/jquery-3.1.1.js">
    <script type="text/javascript">
        // $(document).ready(function () {
        //     alert('dsafasdf');
        //     $.ajax({
        //         type: "GET",
        //         url: "http://www.indiantruckersgps.com/jsp/ServiceUser.jsp?co_name=A.S%20Roadways",
        //         dataType: "json",
        //         success: function (data) {
        //             alert("Success");
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {
        //             alert(errorThrown);
        //         }
        //     });
        // });
       
    </script>
</head>
<body>
<button type="button" onclick="getReq();">Get Data</button>
<script type="text/javascript">
     function getReq(){
            alert('safas');
            $.ajax({
                type: "GET",
                url: "http://www.indiantruckersgps.com/jsp/ServiceUser.jsp?co_name=A.S%20Roadways",
                dataType: "json",
                success: function (data) {
                    alert(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }
</script>
</body>
</html>

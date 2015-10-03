<script>
/*file created 12:12 PM 1/16/2009 :Rajani*/
// This function is used for server side action
//file used in survillence audit to select all lob related to slected circle
function ajaxCircle_Lob(id)
{
	
var audit_lob_name = document.getElementById("lob_name")
var audit_lob      = document.getElementById("audit_lob")
//alert(document.getElementById("hdn_site").value)
var xmlHttp;
var url="ajax_circle_lob1.php?circle_id="+id;

try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    try
      {
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
  
  xmlHttp.onreadystatechange=function()
    {
    if(xmlHttp.readyState==4)
      {
	  text = xmlHttp.responseText;
	  var splited = text.split(',');
	  audit_lob_name.value = splited[1];
	  audit_lob.value      = parseInt(splited[0]);
	  
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>
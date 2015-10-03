<script>
/*file created 3:35 PM 12/10/2008 :Rajani*/
// This function is used for server side action in Manage Project Activity on user's Level
function ajaxSite(id,name)
{
var hdn_site = document.getElementById("hdn_site").value
var tbl_site = document.getElementById("tbl_site")

//alert(document.getElementById("hdn_state").value)
var xmlHttp;
var url="ajax_site.php";
if(hdn_site=='state-site')
	url += "?state_site_id="+id;
if(name!='undefined')
   url += "&pname="+name;
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
		  if(text.length>3)
		  {
			  tbl_site.style.display = 'block';
			  document.getElementById("dv_site").innerHTML = text+"<span class='rightnavtxt'>* </span>";
		  }
	  //alert(document.getElementById("state_id").option)
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>
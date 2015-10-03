<script>
/*file created 3:35 PM 12/10/2008 :Rajani*/
// This function is used for server side action in Manage Project Activity on user's Level
function ajaxHierarchy(id)
{
//alert("id"+id)
var hdn_hierarchy = document.getElementById("hdn_hierarchy").value
var tbl_hierarchy = document.getElementById("tbl_hierarchy")

//alert(document.getElementById("hdn_hierarchy").value)
var xmlHttp;
var url="ajax_location.php";
if(hdn_hierarchy=='region-state')
	url += "?region_state_id="+id;
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
			  tbl_hierarchy.style.display = 'block';
			  document.getElementById("dv_hierarchy").innerHTML = text+"<span class='rightnavtxt'>* </span>";
		  }
	  //alert(document.getElementById("state_id").option)
      }
    }
  xmlHttp.open("GET",url,true);
  xmlHttp.send(null);
  }

  </script>
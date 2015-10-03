<?
/*  function for show all activity */ 
  function activity_drop_down()
  {
	  $sql="select plan_title,plan_id from tbl_project_plan where plan_delete_status='No' and plan_status='Active'";
	  $rs=doquery($sql);
	  return($rs);
  }
  /*  function for show all status */ 
  /* Modified:Rajani 8/12/2008 
  *  modified again 12:20 PM 12/23/2008 to not show completed status 
  *  when adding a new project
  */
  function status_drop_down($id)
  {
  	  if($id!="")
  	  	$new_status = fetch_status($id);
	  if(isset($new_status)&&$new_status=='Completed')
	  {
	  	$sql="select status_id,status_name from mst_plan_status  where (status_del_status='No') and (status_name='Re-open' ||status_name='Completed' )";
	  }
	  else if(!isset($new_status))
	  {
	    $sql="select status_id,status_name from mst_plan_status  where status_del_status='No' and status_name!='Completed' and status_name!='Re-open'";
	  }
	  else
	  {
	  	$sql="select status_id,status_name from mst_plan_status  where status_del_status='No' and status_name!='Re-open'";
	  }
  	  
	  $rs=doquery($sql);
	  return($rs);
  }
  
  /*  function for show all Groups */
   function group_drop_down()
  {
  	  $sql="select group_id,group_name from mst_group  where group_del_status='No'";
	  $rs=doquery($sql);
	  return($rs);
  }
  
  /*  function for show all lob */
  function lob_drop_down()
  {
  	 $sql="select lob_id,lob_name from mst_lob where lob_del_status='No'";
	 $rs=doquery($sql);
	 return($rs);
  }
  
  /*  function for show all Designation */
  function designation_drop_down()
  {
  	 $sql="select * from  mst_designation where desig_del_status='No'";
	 $rs=doquery($sql);
	 return($rs);
  }
   /*  function for show all Designation */
  function circle_hub_drop_down()
  {
  	$sql="select * from mst_circle where circle_del_status='No'";
	$rs=doquery($sql);
	 return($rs);
  }
  
  /*  function for show all resion */
  function resion_zone_drop_down()
  {
  	$sql="select * from mst_region where region_del_status='No'";
	$rs=doquery($sql);
	return($rs);
  }
  
/* 
* function for show all circle respect to selected region
* Created 11:41 AM 1/16/2009 : Rajani
* return value is resultset
* passer parameter is region id
*/
  function region_circle_drop_down($region_id)
  {
  	$sql="select circle_id, circle_name from mst_circle  where circle_del_status='No' and circle_region_id=".$region_id;
	$rs=doquery($sql);
	return($rs);
  }
  
  
  /*  function for show all state */
  function state_drop_down()
  {
  	$sql="select * from mst_state where state_del_status='No'";
	$rs=doquery($sql);
	return($rs);
  }
  
  /*  function for show all location */
  function location_drop_down()
  {
  	$sql="select * from tbl_site where site_delete_status='No'";
	$rs=doquery($sql);
	return($rs);
  }
  
  function delay_drop_down()
  {
  	$sql="select * from  mst_delay where delay_del_status='No'";
	$rs=doquery($sql);
	return($rs);
  }
  
  /*  function for show all location which are related to selected circle
   * craeated: Rajani
  */
  function location_drop_down_selected($id)
  {
  	 $sql="SELECT s .site_id,s.site_name 
			FROM tbl_site s
			INNER JOIN mst_circle c ON s.site_id = c.site_id where c.circle_id='".$id."' and  site_delete_status='No'";
			  
	$rs=doquery($sql);
	return($rs);
  }
  /*
  This function returns all the state in the vselected Region
  * state_region_drop_down: 2:50 PM 12/10/2008 : Rajani
  * Parameter passed to this function is region id
  * Return value is all the data which carry state id and name related to the selected region
  */
  function state_region_drop_down($id)
  {
  	$sql="SELECT state_id,state_name,state_del_status from mst_state where region_id=".$id;
	$rs=doquery($sql);
	return($rs);
  }
  
   /*
  This function returns all the Location in the selected state
  * state_site_drop_down: 6:57 PM 12/11/2008 : Rajani
  * Parameter passed to this function is state id
  * Return value is all the data which carry site id and name related to the selected state
  */
   function state_site_drop_down($id)
  {
  	$sql="SELECT site_id, site_name, site_delete_status
				FROM tbl_site
				WHERE state_id=".$id;
	$rs=doquery($sql);
	return($rs);
  }
    /*
  This function returns all the Circle in the selected Location
  * state_site_drop_down: 12:17 PM 12/18/2008 : Rajani
  * Parameter passed to this function is state id
  * Return value is all the data which carry circle id and names related to the selected state
  */ 
  function site_circle_drop_down($id)
  {
  	 $sql="SELECT circle_id, circle_name, circle_del_status
				FROM mst_circle
				WHERE site_id=".$id;
	$rs=doquery($sql);
	return($rs);
  }
  
 /* function to show priority drop dowm */ 
  function priority_drop_down()
  {
  	print $sql = "select priority_id,priority_name from mst_priority";
	$rs = doquery($sql);
	return($rs);
  }
  
  /*  function for show all status for issues */ 
  function issue_status_drop_down()
  {
  	  $sql="select status_id,status_name from mst_issue_status where status_deleted='no'";
	  $rs=doquery($sql);
	  return($rs);
  }
  
/*  function for show all action on issues can be taken */ 
  function issue_action_drop_down()
  {
  	  $sql="SELECT * FROM `mst_issue_action` where deleted_status='false'";
	  $rs=doquery($sql);
	  return($rs);
  }  
  
  function filter_activity_drop_down()
  {
  	 $sql = "SELECT plan_title,plan_id FROM `tbl_project_plan` WHERE `plan_id` not in (SELECT distinct `prj_al_plan_plan_id` FROM `tbl_project_activity_log` where `prj_al_user_id` =". $_SESSION['emp_id']." || prj_al_plan_site_id =".$_SESSION['circle_id'].")";
	$rs=doquery($sql);
	return($rs);
  }
  
  /*
  function frequency_drop_down is use to create frequency drop down
  Created : Rajani :2:40 PM 1/15/2009
  it will return result set
  */
  function frequency_drop_down()
  {
	  $sql = "select frequency_id,frequency_name from mst_frequency";
	  $rs  = doquery($sql); 
	  return($rs);
  }
  
   /*
  function month_drop_down is use to create month drop down
  Created : Rajani :3:10 PM 1/15/2009
  it will return array of month
  */
  function month_drop_down()
  {
    $month = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	return($month);
  }
   /*
  function selected_region_drop_down is use to create region drop down for the logged in user
  Created : Rajani :6:51 PM 1/15/2009
  it will resultset
  */  
  function selected_region_drop_down($id)
  {
  	$sql = "select region_id,region_name from mst_region where region_del_status='No'";
  	if($_SESSION['group']!='Administrator' && $_SESSION['group']!='PMO Administrator')
	{
	   $sql .=" and  region_id=".$id;
	}
	$rs  = doquery($sql);
	return($rs);
  }
  
 /*
 function role_drop_down is use to select all roles
 this function returns the resulset
 created :12:07 PM 1/30/2009 :RAjani
 */
  
  function role_drop_down()
  {
  	$sql = "select role_id,role_name from mst_role";
	$rs  = doquery($sql);
	return($rs);
  }
  
  /* 
* function circle_lob_drop_down used for list all the lob in drop down related to a particular circle
* Created 12:56 PM 1/30/2009 : Rajani
* return value is result set
* passer parameter is circle id
*/
  function circle_lob_drop_down($circle_id)
  {
  	$sql="SELECT b.lob_id,b.lob_name
FROM `tbl_lob_circle` a
INNER JOIN mst_lob b ON b.lob_id = a.lob_id
WHERE a.circle_id = $circle_id";
	$rs=doquery($sql);
	return($rs);
  }
  
/*
function deliverable_type_drop_down use to show the drop down for 
all deliverable types
this function returns the resultset
created 11:56 PM 2/5/2009 : Rajani
*/
function deliverable_type_drop_down()
{
	$sql = "select d_type_id,d_type from mst_deliverables_type";
	if($_SESSION['group']!='Administrator' && $_SESSION['group']!='PMO Administrator')
	{
		$sql .= " where d_type!='Central Documents'";
	}
	$rs  = doquery($sql);
	return($rs);
}

/*
function asset_type_drop_down use to show the drop down for 
all asset register types
this function returns the resultset
created 01:01 PM 2/5/2009 : Rajani
*/
function asset_type_drop_down()
{
	$sql = "select a_type_id,a_type from mst_asset_type";
	$rs  = doquery($sql);
	return($rs);
}

//function use for rtp_status_drop_down
/*
created : Rajani :1:00 PM 2/7/2009
*/
function rtp_status_drop_down()
{
	$sql = "select rtp_status_id,rtp_status_name from mst_rtp_status";
	$rs = doquery($sql);
	return($rs);
}
//function use for rtp_timeline_drop_down
/*
created : Rajani :1:13 PM 2/7/2009
*/
function rtp_timeline_drop_down()
{
	$sql = "select rtp_timeline_id,rtp_timeline from mst_rtp_timeline";
	$rs = doquery($sql);
	return($rs);
}

//function use for rtp_timeline_drop_down
/*
created : Rajani :2:05 PM 2/7/2009
*/
function rtp_risk_acceptance_drop_down()
{
	$sql = "select risk_a_id,risk_a_name from mst_risk_acceptance";
	$rs = doquery($sql);
	return($rs);
}
//function use for legend_drop_down
/*
created : Rajani :7:18 PM 2/10/2009
*/
function legend_drop_down()
{
 	$sql = "select legend_id,legend_name from mst_legend";
	$rs = doquery($sql);
	return($rs);
}

//function use for type_of_nc_drop_down
/*
created : Rajani :3:26 PM 2/11/2009
*/
function type_of_nc_drop_down()
{
 	$sql = "select type_id,nc_name from mst_type_of_nc";
	$rs = doquery($sql);
	return($rs);
}
?> 
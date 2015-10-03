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
  	print $sql="SELECT circle_id, circle_name, circle_del_status
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
  
?> 
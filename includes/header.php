<!--open of the header-->
	<div class="container-fluid" id="header">
    	<div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <img src="images/indian_truckers.png" class="img-responsive" alt="Indian Truckers" title="Indian Truckers">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            	<ul class="nav nav-pills pull-right">
                	<li role="presentation" class="dropdown">
    				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-envelope"></span> <span class="caret"></span>
    				</a>
                    <ul class="dropdown-menu dropdown-user">
                    	<li><a href="#">Message</a></li>
                    </ul>
                    </li>
  					<li role="presentation" class="dropdown">
    				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name'];?> <span class="caret"></span>
    				</a>
    				<ul class="dropdown-menu dropdown-user">
    					<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
    				</ul>
  					</li>
				</ul>
            </div>
        </div>
    </div>
    <!--end of the header-->
<!--start navbar-->
<div class="row" id="nav_bar">
	<div class="col-md-12">
    	 <div class="nav navbar-default">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse">
    <ul class="nav  navbar-nav">
      <li style="border:0px;"><a href="home.php?token=<?=$token?>">Home</a></li>
      
      <li class="dropdown"><a tabindex="0" data-toggle="dropdown">Products<span class="caret"></span></a>
        <ul class="dropdown-menu drop_menu" role="menu">
        
          <li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown">Manage Branch</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_category.php?token=<?=$token?>">Add Category</a></li>
              <li><a tabindex="0" href="manage_branch.php?token=<?=$token?>">Add Branch</a></li>
            </ul>
          </li>
          
          
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Address</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_country.php?token=<?=$token?>">Country</a></li>
              <li><a tabindex="0" href="manage_state.php?token=<?=$token?>">State</a></li>
              <li><a tabindex="0" href="manage_district.php?token=<?=$token?>">District</a></li>
              <li><a tabindex="0" href="manage_city.php?token=<?=$token?>">City</a></li>
              <li><a tabindex="0" href="manage_area.php?token=<?=$token?>">Area</a></li>
              <li><a tabindex="0" href="manage_pincode.php?token=<?=$token?>">Pincode</a></li>
            </ul>
          </li>
          <li><a tabindex="0" href="manage_datasource.php?token=<?=$token?>">Data Source</a></li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Plan</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_plan_category.php?token=<?=$token?>">Plan Category</a></li>
              <li><a tabindex="0" href="manage_subcategory.php?token=<?=$token?>">Plan Sub Category</a></li>
              <li><a tabindex="0" href="manage_plan.php?token=<?=$token?>">Plan</a></li>
              <li><a tabindex="0" href="manage_plan_period.php?token=<?=$token?>">Plan Period</a></li>
            </ul>
         </li>
         <li><a tabindex="0" href="manage_status.php?token=<?=$token?>">Status</a></li>
         <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Users</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_user_category.php?token=<?=$token?>">Add/Edit Category</a></li>
              <li><a tabindex="0" href="manage_users.php?token=<?=$token?>">Add/Edit User</a></li>
            </ul>
         </li>
         <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Module</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0"  href="manage_module_category.php?token=<?=$token?>">Add/Edit Module Category</a></li>
              <li><a tabindex="0"  href="manage_module.php?token=<?=$token?>">Add/Edit Module</a></li>
              <li><a tabindex="0"  href="manage_parent_module.php?token=<?=$token?>">Add/Edit Parent Module</a></li>
              <li><a tabindex="0"  href="manage_role.php?token=<?=$token?>">Add/Edit Role</a></li>
            </ul>
         </li>
         <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Dealer</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_dealer.php?token=<?=$token?>">Add/Edit Dealer</a></li>
              <li><a tabindex="0" href="manage_device_company.php?token=<?=$token?>">Add/Edit Device Company</a></li>
              <li><a tabindex="0" href="manage_devicemodel.php?token=<?=$token?>">Add/Edit Device Model</a></li>
              <li><a tabindex="0" href="manage_accessories.php?token=<?=$token?>">Add/Edit Accessories</a></li>
            </ul>
         </li>
         <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Sim</a>
            <ul class="dropdown-menu">
               <li><a tabindex="0" href="manage_serviceprovider.php?token=<?=$token?>">Service Provider</a></li>
            </ul>
         </li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Ticket</a>
            <ul class="dropdown-menu">
               <li><a tabindex="0" href="manage_request_type.php?token=<?=$token?>">Manage Request Type</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Customer Type</a>
            <ul class="dropdown-menu">
               <li><a tabindex="0" href="manage_customer_type.php?token=<?=$token?>">Customer Type</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Customer</a>
            <ul class="dropdown-menu">
               <li><a tabindex="0" href="assign_service_branch.php?token=<?=$token?>">Assign Service Branch</a></li>
               <li><a tabindex="0" href="confirm_customer_details.php?token=<?=$token?>">Edit Customer Details</a></li>
            </ul>
          </li>
           <li><a tabindex="0" href="manage_old_vehicle.php?token=<?=$token?>">Old Vehicle Entry</a></li>
        </ul>
        
      </li>
      
      <li class="dropdown"><a tabindex="0" data-toggle="dropdown">Inventory<span class="caret"></span></a>
        <ul class="dropdown-menu drop_menu" role="menu">
          <li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown">Manage Device</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_model.php?token=<?=$token?>">Import Device</a></li>
              <li><a tabindex="0" href="assign_device_to_branch.php?token=<?=$token?>">Assign Branch</a></li>
              <li><a tabindex="0" href="branch_confirmation_device.php?token=<?=$token?>"> Branch Confirmation</a> </li>
              <li><a tabindex="0" href="assign_device_to_technician.php?token=<?=$token?>">Assign Technician</a></li>
              <li><a tabindex="0" href="device_report.php?token=<?=$token?>">Device Reports</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Manage Sim</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_sim.php?token=<?=$token?>">Import/Update Sim</a></li>
              <li><a tabindex="0" href="assign_sim_to_branch.php?token=<?=$token?>">Assign Branch</a></li>
              <li><a tabindex="0" href="sim_confirmation.php?token=<?=$token?>">Sim Confirmation</a></li>
              <li><a tabindex="0" href="assign_sim_to_technician.php?token=<?=$token?>">Assign Technician</a></li>
              <li><a tabindex="0" href="sim_report.php?token=<?=$token?>">Sim Reports</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown"><a tabindex="0" data-toggle="dropdown">Manage Lead<span class="caret"></span></a>
        <ul class="dropdown-menu drop_menu" role="menu">
          <li><a tabindex="0" href="managecontacts.php?token=<?=$token?>">Import Contact</a></li>
          <li><a tabindex="0" href="assigncontacts.php?token=<?=$token?>">Assign Contact</a></li>
          <li><a tabindex="0" href="assigncontacts_confirm.php?token=<?=$token?>">Confirm Contact</a></li>
          <li><a tabindex="0" href="assigncontacts_telecaller.php?token=<?=$token?>">Assign Telecaller</a></li>
          <li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown">Manage Telecalling</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="telecalling.php?token=<?=$token?>">Fresh Telecalling</a></li>
              <li><a tabindex="0" href="follow_up_telecalling.php?token=<?=$token?>">Follow-up</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="dropdown">
      <a tabindex="0" data-toggle="dropdown">Manage Ticket<span class="caret"></span></a>
      	 	<ul class="dropdown-menu">
               <li><a tabindex="0" href="view_ticket.php?token=<?=$token?>">Create Ticket</a></li>
               <li><a tabindex="0" href="assign_ticket_branch.php?token=<?=$token?>">Assign Branch</a></li>
               <li><a tabindex="0" href="ticket_branch_confirmation.php?token=<?=$token?>">Branch Confirmation</a></li>
               <li><a tabindex="0" href="assign_ticket_technician.php?token=<?=$token?>">Assign Ticket</a></li>
               <li><a tabindex="0" href="update_ticket_status.php?token=<?=$token?>">Update Status</a></li>
               <li><a tabindex="0" href="ticket_report.php?token=<?=$token?>">Ticket Report</a></li>
            </ul>
      </li>
      <li class="dropdown">
      <a tabindex="0" data-toggle="dropdown">Manage GPS Installation<span class="caret"></span></a>
      	 	<ul class="dropdown-menu">
               <li><a tabindex="0" href="manage_vehicle.php?token=<?=$token?>">Add New Vehicle</a></li>
               <li><a tabindex="0" href="vehicle_report.php?token=<?=$token?>">Vehicle Report</a></li>
               <li><a tabindex="0" href="create_gps_users.php?token=<?=$token?>">Manage Users</a></li>
            </ul>
      </li>
      <li class="dropdown">
      <a tabindex="0" data-toggle="dropdown">Invoice<span class="caret"></span></a>
      	 	<ul class="dropdown-menu">
               <li><a tabindex="0" href="manage_customer_payment_profile.php?token=<?=$token?>">Manage Customer Profile</a></li>
               <li><a tabindex="0" href="receive_payment.php?token=<?=$token?>">Payment Recieve</a></li>
               <li><a tabindex="0" href="add_intervel.php?token=<?=$token?>">Add Interval</a></li>
               <li><a tabindex="0" href="generate_estimates.php?token=<?=$token?>">Generate Estimate</a></li>
               <li><a tabindex="0" href="estimate_view.php?token=<?=$token?>">Estimate View</a></li>
            </ul>
      </li>
      <li class="dropdown"><a tabindex="0" data-toggle="dropdown">Option<span class="caret"></span></a>
        <ul class="dropdown-menu drop_menu" role="menu">
          <li class="dropdown-submenu"><a tabindex="0" data-toggle="dropdown">Vehicle Manager</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="update_vehicle.php?token=<?=$token?>">Update Vehicle</a></li>
            </ul>
          </li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Driver Management</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_sim.php?token=<?=$token?>">Manage Driver</a></li>
              <li><a tabindex="0" href="assign_sim_to_branch.php?token=<?=$token?>">List Driver</a></li>
             
            </ul>
          </li>
           <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Broker Management</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0" href="manage_sim.php?token=<?=$token?>">Add Broker</a></li>
              <li><a tabindex="0" href="assign_sim_to_branch.php?token=<?=$token?>">List Broker</a></li>
             
            </ul>
          </li>
       
        </ul>
      </li>
       <li style="border:0px;"><a href="manage_conveyance.php?token=<?=$token?>">Manage Conveyance</a></li>
      
      <li class="dropdown">
        <a tabindex="0" data-toggle="dropdown">Dropdown 2<span class="caret"></span></a>
        <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
        <ul class="dropdown-menu" role="menu">
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Action</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0">Sub action</a></li>
              <li class="dropdown-submenu">
                <a tabindex="0" data-toggle="dropdown">Another sub action</a>
                <ul class="dropdown-menu">
                  <li><a tabindex="0">Sub action</a></li>
                  <li><a tabindex="0">Another sub action</a></li>
                  <li><a tabindex="0">Something else here</a></li>
                </ul>
              </li>
              <li><a tabindex="0">Something else here</a></li>
            </ul>
          </li>
          <li><a tabindex="0">Another action</a></li>
          <li class="dropdown-submenu">
            <a tabindex="0" data-toggle="dropdown">Something else here</a>
            <ul class="dropdown-menu">
              <li><a tabindex="0">Sub action</a></li>
              <li><a tabindex="0">Another sub action</a></li>
              <li><a tabindex="0">Something else here</a></li>
            </ul>
          </li>
          <li class="divider"></li>
          <li><a tabindex="0">Separated link</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>	
</div>
</div>
<!--end navbar-->

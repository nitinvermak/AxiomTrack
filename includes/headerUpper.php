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
    				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name'];?><span class="caret"></span>
    				</a>
    				<ul class="dropdown-menu dropdown-user">
    					<li><a href="change_password.php?token=<?php echo $token;?>"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
    				</ul>
  					</li>
				</ul>
            </div>
        </div>
    </div> 
 
 
    <!--end of the header-->
<!--start navbar-->
 
<?php
	
	include('parts/header.php');
	
	$user = new User();
	$user->set_id($current_user['user_id']); 

?>

<div class="content-wrapper">
	<section class="content-header" style="background: red; height: 50px;">
		<h1>Administration</h1>
		<ol class="breadcrumb">
			<li><i class="fa fa-cogs"></i> Administration</li>
		</ol>
	</section>
	
	
	<div class="stretch-container">
		<div class="row">
			<div class="col-lg-8">
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "update_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Setting Updated</h4>
				    Your settings were updated successfully.
				</div>
				<?php } ?>
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "permissions_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Permissions Updated</h4>
				    User permissions updated successfully.
				</div>
				<?php } ?>
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "delete_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> User Deleted</h4>
				    User deleted successfully.
				</div>
				<?php } ?>
				
				<div class="nav-tabs-custom">
            <ul class="nav nav-tabs warning-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Admin Settings</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">User Permissions</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Add User</a></li>
            </ul>
            <div class="tab-content">
	            
	           
	           
	          <!-- Admin Settings -->
              <div class="tab-pane active" id="tab_1">
						<div class="box-body">
							<label>Company Name</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $user->get_email(); ?>">
              				</div>
              				<br />
              				<label>Base URL</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input name="name" type="text" class="form-control" placeholder="Full Name" value="<?php echo $user->get_name(); ?>">
              				</div>
              				<br />
              				<label>Job Title</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
								<input name="title" type="text" class="form-control" placeholder="Job Title" value="<?php echo $user->get_title(); ?>">
              				</div>
              				<br />
              				<button type="submit" class="btn btn-warning pull-right">Change Details</button>
						</div>
							
              </div>
              <!-- /.tab-pane -->
              
              
              
              <!-- User Listing -->
              <div class="tab-pane" id="tab_2">
	              
	              
	              <table class="table table-bordered">
                <tbody><tr>
                  <th>ID</th>
                  <th>Avatar</th>
                  <th>Display Name</th>
                  <th>Email</th>
                  <th>Permissions</th>
                  <th>Delete</th>
                </tr>

	              
			<?php	

			$authors = mysqli_query($mysqli, "SELECT * FROM users");
				
			while ($row_authors = mysqli_fetch_array($authors, MYSQLI_ASSOC)) {
				$author = new User();
				$author->set_id($row_authors['user_id']);
			?>
			
			     <tr>
				     <td><?php echo $author->get_id(); ?></td>
                  <td><img class="img-circle" src="<?php echo $author->get_gravatar(); ?>" alt="User Avatar"></td>
                  <td><?php echo $author->get_name(); ?></td>
                  <td>
				  	<?php echo $author->get_email(); ?>
                  </td>
                  <td><?php if($author->is_admin()) { ?><a href="app/process/user_permissions_process.php?id=<?php echo $author->get_id(); ?>">Revoke Admin</a><?php } else { ?><a href="app/process/user_permissions_process.php?id=<?php echo $author->get_id(); ?>">Grant Admin</a><?php } ?></td>
                  <td><a href="#" data-toggle="modal" data-target="#delete-<?php echo $author->get_id(); ?>">Delete User</a></td>
                </tr>
                

           <div class="modal fade" id="delete-<?php echo $author->get_id(); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Are you sure?</h4>
			      </div>
			      <div class="modal-body">
				      <p>Deleting this user will also delete all of their snippets.</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
			        <a href="app/process/delete_user_process.php?id=<?php echo $author->get_id(); ?>"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> I would like to delete <?php echo $author->get_name(); ?> and all their snippets.</button></a>
			      </div>
			    </div>
			  </div>
			</div>
                
			
					<?php } ?>
			
			              </tbody></table>
              </div>
              <!-- /.tab-pane -->
              
              
              
              
              
              <!-- Add User -->
              <div class="tab-pane" id="tab_3">
<form action="app/process/add_user_process.php" method="post">
<p><label>Your Email:</label> <input tabindex="1" id="start-here" name="e" type="email" placeholder="email address" /></p>
<p><label>Your Password:</label> <input tabindex="2" name="p1" type="password" /></p>
<p><label>Your Password:</label> <input tabindex="3" name="p2" type="password" /></p>
<p><input tabindex="5" type="submit" value="sign up &raquo;" /></p>
</form>
              </div>
              <!-- /.tab-pane -->
              
              
            </div>
            <!-- /.tab-content -->
          </div>
			
			</div>
			<div class="col-lg-4">
				<div class="alert alert-muted alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-info"></i> Changing your password</h4>
					To change your password, sign out and use the 'forgot password' function on the login page.
				</div>
				<div class="alert alert-muted alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-info"></i> Setting your avatar</h4>
					Your avatar is pulled from Gravatar. To set or change it, visit <a href="http://en.gravatar.com/">gravatar.com</a>.
				</div>
			</div>
		</div>
	</div>
	

	
<?php include('parts/footer.php'); ?>
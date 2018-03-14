<?php
	
	include('parts/header.php');
	
	$user = new User();
	$user->set_id($current_user['user_id']); 

?>

<div class="content-wrapper">
	<section class="content-header" style="background: red; height: 50px;">
		<h1>Your Account</h1>
	</section>
	
	
	<div class="stretch-container">
		<div class="row">
			<div class="col-lg-8">
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "update_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Details Updated</h4>
				    Your account details were updated successfully.
				</div>
				<?php } ?>
				
				<form action="app/process/account_process.php" method="post">
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">Edit Account Details</h3>
						</div>
						<div class="box-body">
							<label>Email Address</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $user->get_email(); ?>">
              				</div>
              				<br />
              				<label>Full Name</label>
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
	              			<div class="form-group">
			                	<label>Time Zone</label>
			                	<script type="text/javascript">
									$(document).ready(function() {
										$(".timezone").select2();
									});
								</script>
								<select name="timezone" class="form-control timezone">
									<?php
										// Fab timezone script from https://gist.github.com/Xeoncross/1204255
										$regions = array(
										    'Africa' => DateTimeZone::AFRICA,
										    'America' => DateTimeZone::AMERICA,
										    'Antarctica' => DateTimeZone::ANTARCTICA,
										    'Asia' => DateTimeZone::ASIA,
										    'Atlantic' => DateTimeZone::ATLANTIC,
										    'Europe' => DateTimeZone::EUROPE,
										    'Indian' => DateTimeZone::INDIAN,
										    'Pacific' => DateTimeZone::PACIFIC
										);
										$timezones = array();
										foreach ($regions as $name => $mask)
										{
										    $zones = DateTimeZone::listIdentifiers($mask);
										    foreach($zones as $timezone)
										    {
												$time = new DateTime(NULL, new DateTimeZone($timezone));
												$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
												$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
											}
										}
										foreach($timezones as $region => $list)
										{

											print '<optgroup label="' . $region . '">' . "\n";
											foreach($list as $timezone => $name)
											{
											if ($timezone == $user->get_timezone()) {
												print '<option selected="selected" value="' . $timezone . '">' . $name . '</option>' . "\n";
											} else {
												print '<option value="' . $timezone . '">' . $name . '</option>' . "\n";
											}

											}
											print '<optgroup>' . "\n";
										}
									?>
			                	</select>
	                		</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-warning pull-right">Change Details</button>
						</div>
					</div>
				</form>
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
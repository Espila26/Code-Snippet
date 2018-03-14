<?php

require_once('app/login_check.php');
require_once('app/classes/model.php');
require_once('app/classes/core.php');

$core = new Core();

if (isset($current_user) && isset($current_user['loggedin']) && $current_user['loggedin'] == true) {
	header('Location: /index.php');
	die();
}

?>
<html>
<head>
<title>Log In — Hoard</title> 
<link rel="stylesheet" href="assets/css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Dosis:500|Open+Sans:400,700" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body id="login">

<div class="container">

	<div class="header">
		<img src="assets/img/logo.svg" class="logo">
		<div class="right"><span>Don't have an account?</span> <a href="register.php">Sign Up</a></div>
	</div>
	
	<?php
if (isset($_GET['register_success'])) {
	?>
	<div class="success">Account created successfully, please log in!</div>
	<?php
}
?>

	<?php
if (isset($_GET['failed'])) {
	?>
	<div class="failure">Login failed, please double check your email and password.</div>
	<?php
}
?>

	<?php
if (isset($_GET['forbidden'])) {
	?>
	<div class="failure">Access denied, please log in to continue.</div>
	<?php
}
?>


<div class="login<?php if (isset($_GET['failed'])) { echo ' form_fail'; } ?>">
<h1>Log in to Hoard</h1>
<form action="login.php" method="post">
<p><input tabindex="1" id="start-here" name="e" type="email" placeholder="Email Address" /></p>
<p><input tabindex="2" name="p" type="password" placeholder="Password"/></p>
<p><input tabindex="3" type="submit" value="Log In" class="button" /></p>
</form>
<a href="forgot.php" class="forgot">Whoops, I forgot my password!</a>
</div>


<div class="footer">
	<div class="left">Code Snippet Manager powered by <a href="https://adamgreenough.com/hoard/">Hoard</a></div>
	<div class="right">Version <?php echo $core->version_number(); ?></div>
</div>

</div>



<script>
	// Fix weird Chrome transition bug (https://bugs.chromium.org/p/chromium/issues/detail?id=332189)
</script>

</body>
</html>
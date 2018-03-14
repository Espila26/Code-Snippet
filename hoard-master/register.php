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
<title>Create an Account — Hoard</title> 
<link rel="stylesheet" href="assets/css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Dosis:500|Open+Sans:400,700" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body id="login">

<div class="container">

	<div class="header">
		<img src="assets/img/logo.svg" class="logo">
		<div class="right"><span>Already have an account?</span> <a href="login.php">Log In</a></div>
	</div>


<div class="login">
<h1>Create an Account</h1>
<form action="app/process/register_process.php" method="post">
<input tabindex="1" id="start-here" name="e" type="email" placeholder="Email Address" /></p>
<input tabindex="2" name="p1" type="password" placeholder="Password" /></p>
<input tabindex="3" name="p2" type="password" placeholder="Confirm Password" /></p>
<p><input tabindex="5" type="submit" class="button" value="Sign Up" /></p>
</form>

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
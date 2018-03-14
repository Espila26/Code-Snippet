<?php
	
	include('parts/header.php');
	
	$user = new User();
	$user->set_id($current_user['user_id']); 

?>

<link rel="stylesheet" href="assets/vendor/plugins/colorpicker/bootstrap-colorpicker.min.css">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: red; height: 50px;">
      <h1>
        Add Label
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


<div class="stretch-container">

<div id="register-prompt">
<h1>add snippet entry</h1>
<form action="app/process/add_label_process.php" method="post">

<input name="snippet" type="hidden" value="<?php echo $_GET['id']; ?>" />
<p><label>Label Title:</label> <input tabindex="1" name="title" type="text" placeholder="test" /></p>
<p><label>Label Colour:</label> <input type="text" name ="colour" class="form-control my-colorpicker1 colorpicker-element"></p>
<p><input type="submit" value="add label" /></p>
</form>
</div>
</div>


	
<?php include('parts/footer.php'); ?>
<?php 
	require_once('app/head.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Hoard Alpha</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/assets/css/custom.css">
  <script src="/assets/vendor/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<!-- jQuery 2.2.3 -->
	<script src="/assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/js/perfect-scrollbar.jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/css/perfect-scrollbar.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Dosis:500|Open+Sans:400,700" rel="stylesheet">
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo $baseurl ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">hoard</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
                     
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $user->get_gravatar(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs">Good evening, <?php echo $user->get_name(); ?>!</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $user->get_gravatar(); ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $user->get_name(); ?>
                  <small><?php echo $user->get_email(); ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $baseurl ?>/account" class="btn btn-default btn-flat">My Account</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $baseurl ?>/app/logout" class="btn btn-default btn-flat">Sign Out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="/admin"><i class="fa fa-gears"></i></a>
          </li>
          <li>
            <a href="#" data-toggle="modal" data-target="#about"><i class="fa fa-info"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <aside class="main-sidebar">

    <section class="sidebar">

      <form action="/search" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      

      
      <ul class="sidebar-menu">
	    <li class="button"><a href="<?php echo $baseurl ?>/add" class="btn-sm btn-block btn-warning">New Snippet</a></li>
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li><a href="/team"><i class="fa fa-users"></i> <span>Team</span></a></li>
        <li class="header">LABELS<div class="pull-right"><a href="/labels"><i class="fa fa-pencil" aria-hidden="true"></i></a></div></li>
        <li><a href="search.php?q=<3"><i class="fa fa-heart text-red"></i> <span>Favourites</span></a></li>
        <?php 
	    	$labels = mysqli_query($mysqli, "SELECT * FROM labels ORDER BY label_name");
			while ($row_labels = mysqli_fetch_array($labels, MYSQLI_ASSOC)) {
			$label = new Label();
			$label->set_id($row_labels['label_id']);
	    ?>
        <?php if($label->is_visible($user->get_id())) { ?><li><a href="/search?q=%23<?php echo str_replace(' ', '_', $label->get_name()); ?>"><i class="fa fa-circle" aria-hidden="true" style="color: <?php echo $label->get_hex(); ?>;"></i> <span><?php echo $label->get_name(); ?></span></a></li><?php } ?>
        <?php 
	        }
	    ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


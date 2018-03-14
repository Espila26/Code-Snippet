<?php
	
/*******************************
	
	Snippet Single View
	snippet.php
	
********************************/
	
include('parts/header.php');
	
if(!empty($_GET["id"])) {
	$id = htmlspecialchars($_GET["id"]);
} else {
	$id = false;
}
	


?>

<div class="content-wrapper">
	
	<section class="content-header" style="background: red; height: 50px;">
	<h1>Team</h1>
	<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> Team</a></li>
	</ol>
	</section>

	<div class="stretch-container">
		

		
		<div class="row">
			
			<?php	

			$authors = mysqli_query($mysqli, "SELECT * FROM users");
				
			while ($row_authors = mysqli_fetch_array($authors, MYSQLI_ASSOC)) {
				$author = new User();
				$author->set_id($row_authors['user_id']);
			?>
			
			<div class="col-lg-4 col-md-6">
				<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="<?php echo $author->get_gravatar(); ?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $author->get_name(); ?></h3>
              <h5 class="widget-user-desc"><?php echo $author->get_title(); ?></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="/profile.php?id=<?php echo $author->get_id(); ?>">View Profile</a></li>
                <li><a href="/search.php?q=@<?php echo str_replace(' ', '_', $author->get_name()); ?>">View Snippets</a></li>
              </ul>
            </div>
          </div>
			</div>
			
			<?php } ?>
						
		</div>
	</div>
	
<?php include('parts/footer.php'); ?>
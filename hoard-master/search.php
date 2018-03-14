<?php include('parts/header.php'); 
	
	if(!empty($_GET["q"])) {
	$q = htmlspecialchars($_GET["q"]) . ' ';
} else {
	$q = false;
}

$userid = $user->get_id();

$search = new Search();
$search->set_query($q);

include('app/process/search_process.php');
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: red; height: 50px;">
      <h1>
        Search Results
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-search"></i> Search</a></li>
        <li class="active"><?php echo $q; ?></li>
      </ol>
    </section>



<div class="snippet-chooser" style="padding: 0;">
	<div class="chooser" style="height: calc(100vh - 100px); overflow-x: hidden;">
    <ul class="nav nav-tabs tabs-left" style="min-height: 100%;">
	    <div class="chooser-label">
		    <strong><?php if(mysqli_num_rows($snippets) > 0) { echo mysqli_num_rows($snippets); } else { echo '0'; } ?></strong>  RESULTS  
		    <?php if($search_contents) { ?>FOR <strong><?php echo $search_contents; ?></strong><?php } ?>
		    <?php if($search->search_label()) { ?>FILED UNDER <strong><?php if($label_results['label_name']) { echo $label_results['label_name']; } else { echo str_replace('_', ' ', $search->search_label()); } ?></strong><?php } ?>
		    <?php if($search->search_author()) { ?>POSTED BY <strong><?php if($author_results['name']) { echo $author_results['name']; } else { echo str_replace('_', ' ', $search->search_author()); } ?></strong> <?php } ?>
		    <?php if($order_name) { ?>ORDERED BY <strong><?php echo $order_name ?></strong> <?php } ?>
		    <?php if($search->search_favourite()) { ?>MARKED AS <strong>FAVOURITES</strong> <?php } ?>
		</div>
	    <?php
if(mysqli_num_rows($snippets) != 0) {
	$i = 0;
	while ($row_snippets = mysqli_fetch_array($snippets, MYSQLI_ASSOC)) {
		$snippet = new Snippet();
		$snippet->set_id($row_snippets['snippet_id']);
		$author = new User();
		$author->set_id($snippet->get_author());
?>
				<li  class='desktop-chooser<?php if ($i == 0) { echo ' active'; } ?>' onclick='getSummary(<?php echo $snippet->get_id(); ?>)'>
					<a href="#snippet-<?php echo $snippet->get_id(); ?>" data-toggle="tab">
						<img src="<?php echo $author->get_gravatar(); ?>" class="avatar">
						<span class="title"><?php echo $snippet->get_title(); ?></span><br />
						<span class="meta">Posted <?php echo $snippet->get_pretty_date('F j, Y', $user->get_timezone()); ?> by <?php echo $author->get_name(); ?></span>
									    <div class="chooser-labels">
				    <?php
		foreach($snippet->get_labels() as $labels) {
			$label = new Label();
			$labelid = $labels['label_id'];
			$label->set_id($labelid);
			echo '<span style="background-color: ' . $label->get_hex() . '">' . $label->get_name() . '</span>';
		}
?>
			    </div>

					</a>
				</li>
				
				<li class='mobile-chooser'>
					<a href="/snippet.php?id=<?php echo $snippet->get_id(); ?>">
						<img src="<?php echo $author->get_gravatar(); ?>" class="avatar">
						<span class="title"><?php echo $snippet->get_title(); ?></span><br />
						<span class="meta">Posted <?php echo $snippet->get_date(); ?> by <?php echo $author->get_name(); ?></span>
									    <div class="chooser-labels">
				    <?php
		foreach($snippet->get_labels() as $labels) {
			$label = new Label();
			$labelid = $labels['label_id'];
			$label->set_id($labelid);
			echo '<span style="background-color: ' . $label->get_hex() . '">' . $label->get_name() . '</span>';
		}
?>
			    </div>

					</a>
				</li>
		<?php
		if ($i == 0) { $startingid = $snippet->get_id(); }
		$i = $i + 1;
	}
} else {

?>
		<div class="noresults">
		<img src="assets/img/acorns.png">
		</div>
		<?php } ?>
    </ul>
</div>
</div>

<div class="snippet-viewer">
    <div class="tab-content scrolly">
		<div class="test"></div>
    </div>
</div>


<?php if (strpos($_SERVER['REQUEST_URI'], "delete_success") !== false){ ?>
  <!-- Modal -->
  <div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Snippet Deleted</h4>
        </div>
        <div class="modal-body">
          <p>Your snippet was deleted succesfully.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript">
    $(window).load(function(){
        $('#deleted').modal('show');
    });
</script>

<?php } ?>


<script>

$( document ).ready(function() {
   $.ajax({
     type: "GET",
     url: 'parts/snippet_container.php',
     data: "id=" + <?php echo $startingid; ?>, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('.test').html(data);
     }
   });

   $('.chooser').perfectScrollbar({ wheelPropagation: true, });
   $('.scrolly').perfectScrollbar({ wheelPropagation: true, });

  });
function getSummary(id)
{
$('.test').html('<div class="overlay"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
   $.ajax({
     type: "GET",
     url: 'parts/snippet_container.php',
     data: "id=" + id, // appears as $_GET['id'] @ your backend side
     success: function(data) {
           // data is ur summary
          $('.test').html(data);
     }
   });
}


</script>


<?php include('parts/footer.php'); ?>
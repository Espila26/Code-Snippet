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
$snippet = new Snippet();
$snippet->set_id($id); 
	
$author = new User();
$authorid = $snippet->get_author();
$author->set_id($authorid);

?>

<div class="content-wrapper">
	
	<section class="content-header" style="background: red; height: 50px;">
	<h1>Snippet</h1>
	<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-code" aria-hidden="true"></i> <?php echo $snippet->get_title(); ?></a></li>
	</ol>
	</section>

	<div class="stretch-container">
		<div class="row">
			<div class="col-lg-12">
			  
				<?php if (strpos($_SERVER['REQUEST_URI'], "entry_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Entry Added</h4>
				    Your new entry was created successfully.
				</div>
				
				<?php } ?>
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "edit_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Entry Updated</h4>
				    Your entry was updated successfully.
				</div>
				
				<?php } ?>

				<?php if (strpos($_SERVER['REQUEST_URI'], "details_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Details Updated</h4>
				    Your snippet was updated successfully.
				</div>
				<?php } ?>
				
				<?php if (strpos($_SERVER['REQUEST_URI'], "delete_success") !== false){ ?>
				<div class="alert alert-success alert-dismissible">
				    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				    <h4><i class="icon fa fa-check"></i> Entry Deleted</h4>
				    Your entry was deleted successfully.
				</div>
				<?php } ?>

	<?php
		if($id and $snippet->get_title()) {
	?>

			</div>

			<div class="col-lg-8">
					
			    <h2><?php echo $snippet->get_title(); ?></h2>
			    <p><?php echo $snippet->get_description(); ?></p>
			    <div class="snippet-labels">
				    <?php 
						foreach($snippet->get_labels() as $labels) { 
							$label = new Label();
							$labelid = $labels['label_id'];
							$label->set_id($labelid);
							echo '<span style="background-color: ' . $label->get_hex() . '">' . $label->get_name() . '</span>';
						}
					?>
			    </div>
			    <hr>
	
				<?php
				$row_entries = mysqli_query($mysqli, "SELECT * FROM snippets_entries WHERE snippet_id = '$id'");
				if ($row_entries AND $row_entries->num_rows !== 0) {
					while ($entries = mysqli_fetch_array($row_entries, MYSQLI_ASSOC)) {
						$id = $entries['entry_id'];
						$entry = new Entry();
						$entry->set_id($id);
				?>
				
				<div class="entry-header">
					<i class="fa fa-code" aria-hidden="true"></i><span class="lang"><?php echo $entry->pretty_lang($entry->get_language()); ?></span> <?php echo $entry->get_name(); ?>
					<div class="pull-right"><a href="/edit.php?id=<?php echo $entry->get_id() ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</a></div>
				</div>
				
				<?php	 
						echo '<div id="editor-' . $entry->get_id() . '">' . $entry->get_content() . '</div>';
				?>
	
			    <script>
				    var editor = ace.edit("editor-" + "<?php echo $entry->get_id(); ?>");
				    editor.setTheme("ace/theme/hoard");
				    editor.getSession().setMode("ace/mode/<?php echo $entry->get_language(); ?>");
				</script>
						
				<?php 
					}
				} 
				
				else {
					echo '<div class="callout callout-warning"><h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No entries found!</h4><p>Try adding a code entry to this snippet.</p></div>';
				}
				?>
	
			</div>

			<div class="col-lg-4">
				<div class="box box-widget widget-user-2">
					<div class="widget-user-header bg-yellow">
						<div class="widget-user-image">
							<img class="img-circle" src="<?php echo $author->get_gravatar(); ?>g" alt="User Avatar">
            			</div>
						<h3 class="widget-user-username"><?php echo $author->get_name(); ?></h3>
						<h5 class="widget-user-desc">Lead Developer</h5>
            		</div>
            		
					<div class="box-footer no-padding">
						<ul class="nav nav-stacked">
							<li><a href="/details.php?id=<?php echo $snippet->get_id(); ?>">Edit Snippet</a></li>
							<li><a href="/entry.php?id=<?php echo $snippet->get_id(); ?>">Add Entry</a></li>
						</ul>
            		</div>
        		</div>
        		
        		<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Collapsable</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">
              The body of the box
            </div>
            <!-- /.box-body -->
          </div>
   			</div>
		</div>
  
		<?php 
			} 
			
			else {
				echo '</div></div>
					<div class="callout callout-danger">
			        <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Snippet not found!</h4>
			        <p>It may have been deleted by the author.</p>
			        </div>';
			}
			?>
	</div>
	
<?php include('parts/footer.php'); ?>
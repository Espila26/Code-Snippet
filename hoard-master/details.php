<?php
	
/*******************************

Edit Snippet Details
details.php

********************************/

include('parts/header.php');

if(!empty($_GET["id"])) {
	$id = htmlspecialchars($_GET["id"]);
} else {
	$id = false;
}

$user = new User();
$user->set_id($current_user['user_id']); 

$snippet = new Snippet();
$snippet->set_id($id); 

?>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: red; height: 50px;">
      <h1>
        Edit Snippet Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


<div class="stretch-container">
<?php
if($id and $snippet->get_title()) {
if($snippet->get_author() == $user->get_id() OR $user->is_admin()) {
?>

<div id="register-prompt">
<form action="app/process/details_process.php" method="post">
<input name="snippetid" type="hidden" value="<?php echo $snippet->get_id(); ?>" />
<p><label>Snippet Title:</label> <input tabindex="1" name="title" value="<?php echo htmlspecialchars($snippet->get_title()); ?>" type="text" placeholder="test" /></p>
<p><label>Snippet Description:</label> <textarea name="description" type="text"><?php echo htmlspecialchars($snippet->get_description()); ?></textarea></p>
<p><label>Snippet Visibility:</label>
	<select class="form-content" style="width: 100%;" name="visibility" tabindex="-1" aria-hidden="true">
                  <option value="0" selected="selected">Only Me</option>
                  <option value="1">Team</option>
                  <option value="2">Public</option>
                </select>
                </p>
                
					<script type="text/javascript">
						$(document).ready(function() {
							$(".labelpicker").select2({
								placeholder: "Select a label..."
							});
						});
					</script>
                
             <p><label>Snippet Labels:</label>
	             <?php 
							$labels = mysqli_query($mysqli, "SELECT * FROM labels ORDER BY label_name");
							if ($labels AND $labels->num_rows !== 0) { ?>
	             <select name="labelpicker[]" size="1" id="labels" class="labelpicker form-control" multiple>
                	    <?php
							while ($row_labels = mysqli_fetch_array($labels, MYSQLI_ASSOC)) {
								$labelid = $row_labels['label_id'];
								$label = new Label();
								$label->set_id($labelid); 
								if ($label->has_label($snippet->get_id()) == true) { $active = 'selected="selected"'; } else { $active = ''; }
								echo "<option " . $active . " title='label-" . $row_labels['label_id'] . "' value='" . $row_labels['label_id'] . "'>" . $row_labels['label_name'] . "</option>";
							} 
							?>
	             </select>
	             <?php
							} else {
								echo 'Please add a label!';
							}
							
							
							// Generate a mini CSS snippet to style label chooser.
							// I am not proud of the following 8 lines of code. It's late, it works, it'll do for now!
							echo '<style>';
							$labels = mysqli_query($mysqli, "SELECT * FROM labels");
							while ($row_labels = mysqli_fetch_array($labels, MYSQLI_ASSOC)) {
								$labelid = $row_labels['label_id'];
								$label = new Label();
								$label->set_id($labelid); 
								echo 'li.select2-selection__choice[title="label-' . $label->get_id() . '"] { background-color: ' . $label->get_hex() . ' !important; border-color: ' . $label->get_hex() . ' !important; }';
							} 
							echo '</style>';
						?>
	             </select>

<p><input type="submit" value="add snippet" /></p>
</form>

<form action="app/process/delete_snippet_process.php" method="post">
	<input name="snippet_id" type="hidden" value="<?php echo $_GET['id']; ?>" />
	<input type="submit" value="delete snippet!!!!!!!" /></p>
</form>

</div>
<?php
} else {
	echo '
		<div class="callout callout-danger">
        <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Permission denied.</h4>
        <p>You can\'t edit a snippet you don\'t own!</p>
        </div>';
	}
	} 
	else {
	echo '
		<div class="callout callout-danger">
        <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Snippet not found!</h4>
        <p>It may have been deleted by the author.</p>
        </div>';
	}
	?>
</div>
	
<?php include('parts/footer.php'); ?>
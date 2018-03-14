<?php
	
/*******************************
	
	Snippet Single View
	snippet.php
	
********************************/

require_once('../app/head.php');

$snippets = mysqli_query($mysqli, "SELECT * FROM snippets");
	
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
<div class="snippet-container">

	
				<h1 class="snippet-title"><?php echo $snippet->get_title(); ?></h1>
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

	<?php
		if($id and $snippet->get_title()) {
	?>


			<div class="snippet-main">
				
	
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
				    editor.renderer.setScrollMargin(0, 20);
				    editor.setOptions({
						minLines: 20,
					    maxLines: 100
					});;
				</script>
						
				<?php 
					}
				} 
				
				else {
					echo '<div class="callout callout-warning"><h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> No entries found!</h4><p>Try adding a code entry to this snippet.</p></div>';
				}
				?>
	
			</div>

			<div class="snippet-sidebar">
				




<div class="box box-solid box-warning box-edit">
            <div class="box-header with-border">
              <h3 class="box-title">Edit</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="/details.php?id=<?php echo $snippet->get_id(); ?>"><i class="fa fa-pencil-square-o"></i> Edit Snippet Details</a></li>
                <li><a href="/entry.php?id=<?php echo $snippet->get_id(); ?>"><i class="fa fa-plus-square"></i> Add Code Entry</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>




				
				<br />
				
		<div class="nav-tabs-custom snippet-details">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Details</a></li>
              <!-- <li><a href="#tab_2" data-toggle="tab">Comments</a></li> -->
              <?php if($snippet->get_visibility() == 2) { ?><li><a href="#tab_3" data-toggle="tab">Share</a></li><?php } ?>
            </ul>
            <div class="tab-content no-pad">
              <div class="tab-pane active" id="tab_1">

			  	
			  	<table class="table table-striped">
                <tbody><tr>
                <tr>
                  <td><i class="fa fa-calendar" aria-hidden="true"></i> Posted <?php echo $snippet->get_pretty_date('F j, Y (H:i)', $user->get_timezone()); ?></td>
                </tr>
                <tr>
                  <td><?php if($snippet->get_visibility() == 0) { echo '<i class="fa fa-eye" aria-hidden="true"></i> Only Me'; } else if($snippet->get_visibility() == 1) { echo '<i class="fa fa-users"></i> Shared with Team'; } elseif($snippet->get_visibility() == 2) { echo '<i class="fa fa-globe"></i> Public'; } ?></td>
                </tr>
                <tr>
                  <td><a href="/snippet/<?php echo $snippet->get_id(); ?>"><i class="fa fa-link" aria-hidden="true"></i> Permalink</a></td>
                </tr>
              </tbody></table>
			  	

              </div>
              <!-- /.tab-pane -->
              <!-- <div class="tab-pane" id="tab_2">
<div class="box-body">
      
                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                  </div>
           
                  <img class="direct-chat-img" src="https://www.gravatar.com/avatar/8e100ea62d285d678710b9b2a045b547?d=mm" alt="Message User Image">
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                
                </div>
             

                <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                  </div>
    
                  <img class="direct-chat-img" src="https://www.gravatar.com/avatar/8e100ea62d285d678710b9b2a045b547?d=mm" alt="Message User Image">
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>

                </div>

              </div>

            <div class="box-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning btn-flat">Send</button>
                      </span>
                </div>
              </form>
            </div>
              </div> -->
              <!-- /.tab-pane -->
              <?php if($snippet->get_visibility() == 2) { ?>
              <div class="tab-pane padding-20" id="tab_3">
                <input type="text" class="form-control" value="<?php echo $baseurl . '/public/' . $snippet->get_id(); ?>" readonly="readonly">
              </div>
              <?php } ?>
            </div>
            <!-- /.tab-content -->
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
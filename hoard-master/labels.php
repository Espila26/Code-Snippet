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
        Manage Labels
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-tags"></i> Home</a></li>
        <li class="active">Manage Labels</li>
      </ol>
    </section>


<div class="stretch-container">

<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#add" data-toggle="tab" aria-expanded="true">Add Label</a></li>
              <li class=""><a href="#manage" data-toggle="tab" aria-expanded="false">Manage Labels</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="add">
<form action="app/process/add_label_process.php" method="post">
<input name="snippet" type="hidden" value="<?php echo $_GET['id']; ?>" />
<p><label>Label Title:</label> <input tabindex="1" name="title" type="text" placeholder="test" /></p>
<p><label>Label Colour:</label> <input type="text" name ="colour" class="form-control my-colorpicker1 colorpicker-element"></p>
<p><input type="submit" value="add label" /></p>
</form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="manage">
	              <table class="table table-bordered">
                <tbody><tr>
                  <th>ID</th>
                  <th>Colour</th>
                  <th>Name</th>
                  <th>Count</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>

	                       <?php
							$labels = mysqli_query($mysqli, "SELECT * FROM labels ORDER BY label_name");
							if ($labels AND $labels->num_rows !== 0) { 
							while ($row_labels = mysqli_fetch_array($labels, MYSQLI_ASSOC)) {
								$labelid = $row_labels['label_id'];
								$label = new Label();
								$label->set_id($labelid); 
								?>  
						
			     <tr>
				     <td><?php echo $label->get_id(); ?></td>
                  <td><?php echo $label->get_hex(); ?></td>
                  <td><?php echo $label->get_name(); ?></td>
                  <td>Count</td>
                  <td><a href="#" data-toggle="modal" data-target="#delete-1">Edit Label</a></td>
                  <td><a href="#" data-toggle="modal" data-target="#delete-1">Delete Label</a></td>
                </tr>
                <?php
	                							} 
							} else {
								echo '<tr><td colspan="6">No labels found!</td></tr>';
							}
				?>
				
								
			              </tbody></table>


              </div>
              <!-- /.tab-pane -->
       
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>







</div>


	
<?php include('parts/footer.php'); ?>
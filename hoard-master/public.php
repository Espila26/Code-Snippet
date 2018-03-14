<?php
	
require_once(__DIR__ . '/app/config.php');
require_once(__DIR__ . '/app/functions.php'); 
require_once(__DIR__ . '/app/classes/model.php'); 
require_once(__DIR__ . '/app/classes/core.php'); 
require_once(__DIR__ . '/app/classes/user.php'); 
require_once(__DIR__ . '/app/classes/snippet.php'); 
require_once(__DIR__ . '/app/classes/entry.php'); 
	
if(!empty($_GET["id"]) and is_numeric($_GET["id"])) {
	$id = htmlspecialchars($_GET["id"]);
} else {
	$id = null;
}

$core = new Core();

$snippet = new Snippet();
$snippet->set_id($id); 
	
$author = new User();
$authorid = $snippet->get_author();
$author->set_id($authorid);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<?php if($id and $snippet->get_title() and $snippet->get_visibility() == 2) { ?>
		<title><?php echo $snippet->get_title(); ?> — <?php echo $core->company_name(); ?></title>
	<?php } else { ?>
		<title>Snippet not found!</title>
	<?php } ?>
	
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/assets/css/public.css">
	<script src="/assets/vendor/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
	<script src="/assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/js/perfect-scrollbar.jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/css/perfect-scrollbar.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Dosis:500|Open+Sans:400,700" rel="stylesheet">
</head>

<body>
	<div class="top">
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<?php echo $core->branding_logo(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php 
		// Check we've set an ID in the URL, the snippet exists and that it has a visibility of Public
		if ($id and $snippet->get_title() and $snippet->get_visibility() == 2) {		
	?>

	<div class="sub">
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">

					<h1><?php echo $snippet->get_title(); ?></h1>
					<p><?php echo $snippet->get_description(); ?></p>
					<div class="meta">
						<img src="<?php echo $author->get_gravatar(); ?>"> Posted by <strong><?php echo $snippet->get_author_name(); ?></strong> on <strong><?php echo $snippet->get_pretty_date('F j, Y (H:i)', 'Europe/London'); ?></strong>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main">
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<?php
						$row_entries = mysqli_query($mysqli, "SELECT * FROM snippets_entries WHERE snippet_id = '$id'");
						if ($row_entries AND $row_entries->num_rows !== 0) {
							while ($entries = mysqli_fetch_array($row_entries, MYSQLI_ASSOC)) {
								$id = $entries['entry_id'];
								$entry = new Entry();
								$entry->set_id($id);
					?>

					<div class="entry-header">
						<i class="fa fa-code" aria-hidden="true"></i>
						<span class="lang"><?php echo $entry->pretty_lang($entry->get_language()); ?></span> 
						<?php echo $entry->get_name(); ?>
					</div>

					<?php echo '<div id="editor-' . $entry->get_id() . '">' . $entry->get_content() . '</div>'; ?>

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
							echo '<div class="error">No code entries found for this snippet.</div>';
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<?php 
		} 

		else {
	?>

	<div class="sub">
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">

					<h1>Snippet not found</h1>
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div>

	<div class="main">
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<div class="error">This snippet may have been hidden or deleted. Maybe it never even existed. Sorry about that.</div>				
				</div>
			</div>
		</div>
	</div>

	<?php
		}
	?>

	<footer>
		<div class="wrapper">
			<div class="row">
				<div class="col-lg-12">
					<hr>
					<div class="left">&copy; <?php echo $core->company_name(); ?> <?php echo date('Y'); ?>, unless otherwise noted.</div>
					<div class="right"><a href="https://adamgreenough.com/hoard/" title="Open source code snippet manager" target="_blank">Code snippet manager powered by <img src="http://hoard.localhost:8888/assets/img/logo.svg"></a></div>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>

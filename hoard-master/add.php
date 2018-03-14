<?php include('parts/header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="background: red; height: 50px;">
      <h1>
        Add Snippet
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-code"></i> Add Snippet</a></li>
      </ol>
    </section>

<div class="stretch-container">
<form action="app/process/add_process.php" method="post">

<div class="row">
			<div class="col-md-8">
				<div class="entry-header">
					<i class="fa fa-code" aria-hidden="true"></i> Add New Snippet
				</div>
				<textarea name="entry" data-editor="text" type="text"></textarea>
			</div>
	
			<div class="col-md-4">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Snippet Details</h3>
					</div>
				<div class="box-body">
					<input tabindex="1" id="start-here" name="snippet_title" type="text" placeholder="Snippet Title" class="form-control input-lg" /><p><label>Snippet Description:</label> <textarea name="snippet_description" type="text"></textarea></p>
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
                
	             <?php
		             		$db = new Model;
		             		$mysqli = $db->mysqli;
							$labels = mysqli_query($mysqli, "SELECT * FROM labels ORDER BY label_name");
							if ($labels AND $labels->num_rows !== 0) { ?>
	             <select name="labelpicker[]" size="1" id="labels" class="labelpicker form-control" multiple>
                	    <?php
							while ($row_labels = mysqli_fetch_array($labels, MYSQLI_ASSOC)) {
								$labelid = $row_labels['label_id'];
								$label = new Label();
								$label->set_id($labelid); 
								echo "<option title='label-" . $row_labels['label_id'] . "' value='" . $row_labels['label_id'] . "'>" . $row_labels['label_name'] . "</option>";
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

				</div>
			</div>
		

				
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Entry Details</h3>
					</div>
				<div class="box-body">
					<input name="snippet" type="hidden" value="<?php echo $_GET['id']; ?>" />
					<input tabindex="1" id="start-here" name="entry_title" type="text" placeholder="Entry Title" class="form-control input-lg" /></p>
	
					<script type="text/javascript">
						$(document).ready(function() {
							$(".langpicker").select2();
						});
					</script>
					<select name="entry_language" size="1" id="mode" class="langpicker form-control">
						<option hidden="" disabled="disabled" selected="selected" value="">Please choose a language...</option>
						<option value="abap">ABAP</option>
						<option value="abc">ABC</option>
						<option value="actionscript">ActionScript</option>
						<option value="ada">ADA</option>
						<option value="apache_conf">Apache Conf</option>
						<option value="asciidoc">AsciiDoc</option>
						<option value="assembly_x86">Assembly x86</option>
						<option value="autohotkey">AutoHotKey</option>
						<option value="batchfile">BatchFile</option>
						<option value="bro">Bro</option>
						<option value="c_cpp">C and C++</option>
						<option value="cirru">Cirru</option>
						<option value="clojure">Clojure</option>
						<option value="cobol">Cobol</option>
						<option value="coffee">CoffeeScript</option>
						<option value="coldfusion">ColdFusion</option>
						<option value="csharp">C#</option>
						<option value="css">CSS</option>
						<option value="curly">Curly</option>
						<option value="d">D</option>
						<option value="dart">Dart</option>
						<option value="diff">Diff</option>
						<option value="dockerfile">Dockerfile</option>
						<option value="dot">Dot</option>
						<option value="drools">Drools</option>
						<option value="eiffel">Eiffel</option>
						<option value="ejs">EJS</option>
						<option value="elixir">Elixir</option>
						<option value="elm">Elm</option>
						<option value="erlang">Erlang</option>
						<option value="forth">Forth</option>
						<option value="fortran">Fortran</option>
						<option value="ftl">FreeMarker</option>
						<option value="gcode">Gcode</option>
						<option value="gherkin">Gherkin</option>
						<option value="gitignore">Gitignore</option>
						<option value="glsl">Glsl</option>
						<option value="gobstones">Gobstones</option>
						<option value="golang">Go</option>
						<option value="groovy">Groovy</option>
						<option value="haml">HAML</option>
						<option value="handlebars">Handlebars</option>
						<option value="haskell">Haskell</option>
						<option value="haskell_cabal">Haskell Cabal</option>
						<option value="haxe">haXe</option>
						<option value="hjson">Hjson</option>
						<option value="html">HTML</option>
						<option value="html_elixir">HTML (Elixir)</option>
						<option value="html_ruby">HTML (Ruby)</option>
						<option value="ini">INI</option>
						<option value="io">Io</option>
						<option value="jack">Jack</option>
						<option value="jade">Jade</option>
						<option value="java">Java</option>
						<option value="javascript">JavaScript</option>
						<option value="json">JSON</option>
						<option value="jsp">JSP</option>
						<option value="jsx">JSX</option>
						<option value="julia">Julia</option>
						<option value="kotlin">Kotlin</option>
						<option value="latex">LaTeX</option>
						<option value="less">LESS</option>
						<option value="liquid">Liquid</option>
						<option value="lisp">Lisp</option>
						<option value="livescript">LiveScript</option>
						<option value="logiql">LogiQL</option>
						<option value="lsl">LSL</option>
						<option value="lua">Lua</option>
						<option value="luapage">LuaPage</option>
						<option value="lucene">Lucene</option>
						<option value="makefile">Makefile</option>
						<option value="markdown">Markdown</option>
						<option value="mask">Mask</option>
						<option value="matlab">MATLAB</option>
						<option value="maze">Maze</option>
						<option value="mel">MEL</option>
						<option value="mushcode">MUSHCode</option>
						<option value="mysql">MySQL</option>
						<option value="nix">Nix</option>
						<option value="nsis">NSIS</option>
						<option value="objectivec">Objective-C</option>
						<option value="ocaml">OCaml</option>
						<option value="pascal">Pascal</option>
						<option value="perl">Perl</option>
						<option value="pgsql">pgSQL</option>
						<option value="php">PHP</option>
						<option value="powershell">Powershell</option>
						<option value="praat">Praat</option>
						<option value="prolog">Prolog</option>
						<option value="properties">Properties</option>
						<option value="protobuf">Protobuf</option>
						<option value="python">Python</option>
						<option value="r">R</option>
						<option value="razor">Razor</option>
						<option value="rdoc">RDoc</option>
						<option value="rhtml">RHTML</option>
						<option value="rst">RST</option>
						<option value="ruby">Ruby</option>
						<option value="rust">Rust</option>
						<option value="sass">SASS</option>
						<option value="scad">SCAD</option>
						<option value="scala">Scala</option>
						<option value="scheme">Scheme</option>
						<option value="scss">SCSS</option>
						<option value="sh">SH</option>
						<option value="sjs">SJS</option>
						<option value="smarty">Smarty</option>
						<option value="snippets">snippets</option>
						<option value="soy_template">Soy Template</option>
						<option value="space">Space</option>
						<option value="sql">SQL</option>
						<option value="sqlserver">SQLServer</option>
						<option value="stylus">Stylus</option>
						<option value="svg">SVG</option>
						<option value="swift">Swift</option>
						<option value="tcl">Tcl</option>
						<option value="tex">Tex</option>
						<option value="text">Text</option>
						<option value="textile">Textile</option>
						<option value="toml">Toml</option>
						<option value="tsx">TSX</option>
						<option value="twig">Twig</option>
						<option value="typescript">Typescript</option>
						<option value="vala">Vala</option>
						<option value="vbscript">VBScript</option>
						<option value="velocity">Velocity</option>
						<option value="verilog">Verilog</option>
						<option value="vhdl">VHDL</option>
						<option value="wollok">Wollok</option>
						<option value="xml">XML</option>
						<option value="yaml">YAML</option>
						<option value="django">Django</option>
					</select>
				</div>
	
				<div class="box-footer">
					<input type="submit" value="Add Entry" class="btn btn-warning pull-right"/>
				</div>
			</div>
	
			<div class="alert alert-muted alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-info"></i> Tip!</h4>
				Select your language first to enable syntax highlighting in the editor.
			</div>
		</div>

</form>
</div>
</div>

<script>
	$(function () {
		$('textarea[data-editor]').each(function () {
			var textarea = $(this);
			var mode = textarea.data('editor');
			var editDiv = $('<div>', {
				'class': textarea.attr('class')
				}).insertBefore(textarea);
				textarea.css('display', 'none');
				var editor = ace.edit(editDiv[0]);
				editor.getSession().setValue(textarea.val());
				editor.getSession().setMode("ace/mode/" + mode);
				editor.setTheme("ace/theme/hoard");
				textarea.closest('form').submit(function () {
				textarea.val(editor.getSession().getValue());
			});
			
			$('#mode').on('change', function(){
				var newMode = $("#mode").val();
				console.log($("#mode").val());
				editor.session.setMode("ace/mode/" + newMode);
				v: Date.now();
			});          
		});  
	});
</script>

<?php include('parts/footer.php'); ?>
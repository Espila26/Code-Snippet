<?php

class Entry extends Model {
	var $entry;
	
	function set_id($current_id) { 
		$this->id = $current_id;  
 	}
 
   	function get_id() {
   		$id = $this->id;
   		return $id;
	}
	
	function get_name() {
		$id = $this->id;
		$entry_name = mysqli_query($this->mysqli, "SELECT entry_name FROM snippets_entries WHERE entry_id = $id");
		if ($row_entries = mysqli_fetch_array($entry_name, MYSQLI_ASSOC)) {
			return htmlentities($row_entries['entry_name']);	
		}
	}
	
	function get_content() {
		$id = $this->id;
		$entry_content = mysqli_query($this->mysqli, "SELECT entry_content FROM snippets_entries WHERE entry_id = $id");
		if ($row_entries = mysqli_fetch_array($entry_content, MYSQLI_ASSOC)) {
			return htmlentities($row_entries['entry_content']);	
		}
	}
	
	function get_language() {
		$id = $this->id;
		$entry_language = mysqli_query($this->mysqli, "SELECT entry_language FROM snippets_entries WHERE entry_id = $id");
		if ($row_entries = mysqli_fetch_array($entry_language, MYSQLI_ASSOC)) {
			return htmlentities($row_entries['entry_language']);	
		}
	}
	
	function get_parent() {
		$id = $this->id;
		$snippet_id = mysqli_query($this->mysqli, "SELECT snippet_id FROM snippets_entries WHERE entry_id = $id");
		if ($row_entries = mysqli_fetch_array($snippet_id, MYSQLI_ASSOC)) {
			return htmlentities($row_entries['snippet_id']);	
		}
	}
	
	function pretty_lang($lang) {
		$labels = array(
			"abap" => "ABAP", "abc" => "ABC", "actionscript" => "ActionScript", "ada" => "ADA", "apache_conf" => "Apache Conf", "asciidoc" => "AsciiDoc", "assembly_x86" => "Assembly x86", "autohotkey" => "AutoHotKey", "batchfile" => "BatchFile", "bro" => "Bro", "c_cpp" => "C and C++", "cirru" => "Cirru", "clojure" => "Clojure", "cobol" => "Cobol", "coffee" => "CoffeeScript", "coldfusion" => "ColdFusion", "csharp" => "C#", "css" => "CSS", "curly" => "Curly", "d" => "D", "dart" => "Dart", "diff" => "Diff", "dockerfile" => "Dockerfile", "dot" => "Dot", "drools" => "Drools", "eiffel" => "Eiffel", "ejs" => "EJS", "elixir" => "Elixir", "elm" => "Elm", "erlang" => "Erlang", "forth" => "Forth", "fortran" => "Fortran", "ftl" => "FreeMarker", "gcode" => "Gcode", "gherkin" => "Gherkin", "gitignore" => "Gitignore", "glsl" => "Glsl", "gobstones" => "Gobstones", "golang" => "Go", "groovy" => "Groovy", "haml" => "HAML", "handlebars" => "Handlebars", "haskell" => "Haskell", "haskell_cabal" => "Haskell Cabal", "haxe" => "haXe", "hjson" => "Hjson", "html" => "HTML", "html_elixir" => "HTML (Elixir)", "html_ruby" => "HTML (Ruby)", "ini" => "INI", "io" => "Io", "jack" => "Jack", "jade" => "Jade", "java" => "Java", "javascript" => "JavaScript", "json" => "JSON", "jsp" => "JSP", "jsx" => "JSX", "julia" => "Julia", "kotlin" => "Kotlin", "latex" => "LaTeX", "less" => "LESS", "liquid" => "Liquid", "lisp" => "Lisp", "livescript" => "LiveScript", "logiql" => "LogiQL", "lsl" => "LSL", "lua" => "Lua", "luapage" => "LuaPage", "lucene" => "Lucene", "makefile" => "Makefile", "markdown" => "Markdown", "mask" => "Mask", "matlab" => "MATLAB", "maze" => "Maze", "mel" => "MEL", "mushcode" => "MUSHCode", "mysql" => "MySQL", "nix" => "Nix", "nsis" => "NSIS", "objectivec" => "Objective-C", "ocaml" => "OCaml", "pascal" => "Pascal", "perl" => "Perl", "pgsql" => "pgSQL", "php" => "PHP", "powershell" => "Powershell", "praat" => "Praat", "prolog" => "Prolog", "properties" => "Properties", "protobuf" => "Protobuf", "python" => "Python", "r" => "R", "razor" => "Razor", "rdoc" => "RDoc", "rhtml" => "RHTML", "rst" => "RST", "ruby" => "Ruby", "rust" => "Rust", "sass" => "SASS", "scad" => "SCAD", "scala" => "Scala", "scheme" => "Scheme", "scss" => "SCSS", "sh" => "SH", "sjs" => "SJS", "smarty" => "Smarty", "snippets" => "snippets", "soy_template" => "Soy Template", "space" => "Space", "sql" => "SQL", "sqlserver" => "SQLServer", "stylus" => "Stylus", "svg" => "SVG", "swift" => "Swift", "tcl" => "Tcl", "tex" => "Tex", "text" => "Text", "textile" => "Textile", "toml" => "Toml", "tsx" => "TSX", "twig" => "Twig", "typescript" => "Typescript", "vala" => "Vala", "vbscript" => "VBScript", "velocity" => "Velocity", "verilog" => "Verilog", "vhdl" => "VHDL", "wollok" => "Wollok", "xml" => "XML", "yaml" => "YAML", "django" => "Django"
   		);
   		return $labels[$lang];
	}	
}

?>
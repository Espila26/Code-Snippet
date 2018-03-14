ace.define("ace/theme/hoard",["require","exports","module","ace/lib/dom"], function(require, exports, module) {

exports.isDark = true;
exports.cssClass = "ace-hoard";
exports.cssText = ".ace-hoard .ace_gutter {\
background: #1a2226;\
color: #8F908A\
}\
.ace-hoard .ace_print-margin {\
width: 1px;\
background: #1a2226\
}\
.ace-hoard {\
background-color: #222d32;\
color: #b8c7ce\
}\
.ace-hoard .ace_cursor {\
color: #b8c7ce\
}\
.ace-hoard .ace_marker-layer .ace_selection {\
background: rgba(0,0,0,0.3)\
}\
.ace-hoard.ace_multiselect .ace_selection.ace_start {\
box-shadow: 0 0 3px 0px #272822;\
}\
.ace-hoard .ace_marker-layer .ace_step {\
background: rgb(102, 82, 0)\
}\
.ace-hoard .ace_marker-layer .ace_bracket {\
margin: -1px 0 0 -1px;\
border: 1px solid #49483E\
}\
.ace-hoard .ace_marker-layer .ace_active-line {\
background: #1a2226\
}\
.ace-hoard .ace_gutter-active-line {\
background-color: #1a2226\
}\
.ace-hoard .ace_marker-layer .ace_selected-word {\
border: 1px solid #49483E\
}\
.ace-hoard .ace_invisible {\
color: #52524d\
}\
.ace-hoard .ace_entity.ace_name.ace_tag,\
.ace-hoard .ace_keyword,\
.ace-hoard .ace_meta.ace_tag,\
.ace-hoard .ace_storage {\
color: #f39c12\
}\
.ace-hoard .ace_punctuation,\
.ace-hoard .ace_punctuation.ace_tag {\
color: #fff\
}\
.ace-hoard .ace_constant.ace_character,\
.ace-hoard .ace_constant.ace_language,\
.ace-hoard .ace_constant.ace_numeric,\
.ace-hoard .ace_constant.ace_other {\
color: #AE81FF\
}\
.ace-hoard .ace_invalid {\
color: #F8F8F0;\
background-color: #F92672\
}\
.ace-hoard .ace_invalid.ace_deprecated {\
color: #F8F8F0;\
background-color: #AE81FF\
}\
.ace-hoard .ace_support.ace_constant,\
.ace-hoard .ace_support.ace_function {\
color: #66D9EF\
}\
.ace-hoard .ace_fold {\
background-color: #A6E22E;\
border-color: #F8F8F2\
}\
.ace-hoard .ace_storage.ace_type,\
.ace-hoard .ace_support.ace_class,\
.ace-hoard .ace_support.ace_type {\
font-style: italic;\
color: #66D9EF\
}\
.ace-hoard .ace_entity.ace_name.ace_function,\
.ace-hoard .ace_entity.ace_other,\
.ace-hoard .ace_entity.ace_other.ace_attribute-name,\
.ace-hoard .ace_variable {\
color: #00a65a\
}\
.ace-hoard .ace_variable.ace_parameter {\
font-style: italic;\
color: #FD971F\
}\
.ace-hoard .ace_string {\
color: #E6DB74\
}\
.ace-hoard .ace_comment {\
color: #b8c7ce\
}\
.ace-hoard .ace_indent-guide {\
background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAACCAYAAACZgbYnAAAAEklEQVQImWPQ0FD0ZXBzd/wPAAjVAoxeSgNeAAAAAElFTkSuQmCC) right repeat-y\
}";

var dom = require("../lib/dom");
dom.importCssString(exports.cssText, exports.cssClass);
});
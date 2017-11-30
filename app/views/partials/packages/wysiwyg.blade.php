@section('external_js')
	@parent
	{{HTML::script('vendor/tiny_mce/tiny_mce.js')}}
@stop

@section('internal_js')
	@parent
	<script>
		$(document).ready(function() {
			tinymce.init({
				mode : "specific_textareas",
				editor_selector : "wysiwyg",
				theme: "advanced",
				skin: "thebigreason",
				width: "600",
				//height: "300",
				plugins: "paste, autoresize",
				// the following removes the styling from things that are pasted in WSYIWYG
				paste_auto_cleanup_on_paste : true,
				paste_remove_styles: true,
				paste_remove_styles_if_webkit: true,
				paste_strip_class_attributes: true,
				theme_advanced_resizing : true,
				theme_advanced_resize_horizontal : false,
				theme_advanced_buttons1: "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect,formatselect,sepatator,bullist,numlist,separator,outdent,indent,separator,link,unlink,image,cleanup,code,pasteword",
				// update validation status on change
				onchange_callback: function(editor) {
					tinyMCE.triggerSave();
					try {
						$("#" + editor.id).valid();
					}
					catch(e) {}
				}
			});	
		});
	</script>
@stop

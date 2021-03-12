// JavaScript Document

tinyMCE.init({
		theme : "advanced",
		mode : "exact",
		elements : "description,description1,description2",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		//save_callback : "customSave",
		content_css : "example_advanced.css",
		theme_advanced_disable : "help,styleselect",
		extended_valid_elements : "a[href|target|name]",
		plugins : "table,flash,style",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "forecolor,backcolor,styleprops",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		//valid_elements : "input[type|value|]",
		//theme_advanced_buttons2_add_before : "",
		//invalid_elements : "a",
		theme_advanced_source_editor_width : "10000",
		theme_advanced_source_editor_height : "100000",
		width : "650",

		theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
		//execcommand_callback : "myCustomExecCommandHandler",
		debug : false
	});

	// Custom event handler
	function myCustomExecCommandHandler(editor_id, elm, command, user_interface, value) {
		var linkElm, imageElm, inst;

		switch (command) {
			case "mceLink":
				inst = tinyMCE.getInstanceById(editor_id);
				linkElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "a");

				if (linkElm)
					alert("Link dialog has been overriden. Found link href: " + tinyMCE.getAttrib(linkElm, "href"));
				else
					alert("Link dialog has been overriden.");

				return true;

			case "mceImage":
				inst = tinyMCE.getInstanceById(editor_id);
				imageElm = tinyMCE.getParentElement(inst.selection.getFocusElement(), "img");

				if (imageElm)
					alert("Image dialog has been overriden. Found image src: " + tinyMCE.getAttrib(imageElm, "src"));
				else
					alert("Image dialog has been overriden.");

				return true;
		}

		return false; // Pass to next handler in chain
	}
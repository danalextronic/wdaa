var Templates = {

	running: false,

	loadOptions: function(rowType)
	{
		// make sure that we are dealing with an uppercase version
		rowType = rowType.toUpperCase();

		// default data for sheepIt
		var opts = {
			allowRemoveLast: true,
			allowRemoveCurrent: true,
			allowRemoveAll: true,
			allowAdd: true,
			allowAddN: true,
			minFormsCount: 0,
			iniFormsCount: 1,
			separator: '<div class="divider"></div>'
		};

		if(rowType == 'T') {
			// add data
			if(typeof script_data.test_rows !== 'undefined' && script_data.test_rows.length > 0) {
				opts.data = JSON.parse(script_data.test_rows);
			}

			// use markers?
			if(script_data.use_markers) {
				opts.nestedForms = [{
					id: 'testrows_#index#_markers',
					options: {
						indexFormat: '#index_markers#',
						maxFormsCount: 5,
						allowAdd: true,
						allowRemoveLast : true,
						allowRemoveCurrent : true,
						separator: '<div class="divider"></div>'
					}
				}];
			}
		}
		else if(rowType == 'O') {
			// add data
			if(typeof script_data.overall_rows !== 'undefined' && script_data.overall_rows.length > 0) {
				opts.data = JSON.parse(script_data.overall_rows);
			}
		}

		return opts;
	},
	getRequestData: function(element)
	{
		this.value = element.val();
		this.link = this.getAnchorLink(element);

		this.hideLink(this.link);
		this.setVideoId(this.link);

		if(this.value === '') {
			throw new Error('No value provided!');
		}
	},
	validateVideo: function(e)
	{
		if(Templates.running) {
			return false;
		}

		Templates.toggleRequest();

		e.preventDefault();

		try {
			Templates.getRequestData($(this));
		}
		catch(ex) {
			Templates.toggleRequest();
			return false;
		}

		if($(this).is('select')) {
			var video_url = $("#video_dropdown option:selected").text();

			Templates.showLink(Templates.link, video_url, "Watch video");
			Templates.setVideoId(Templates.link, Templates.value);
			Templates.bindVideoLink(Templates.link);

			Templates.toggleRequest();
			return false;
		}

		if(!Templates.validUrl(Templates.value)) {
			alert('Invalid URL provided!');
			return false;
		}

		$.post(script_data.ajax_url, {
			'url'			: Templates.value
		}, function(data) {
			if(data.result != 'success') {
				Templates.toggleRequest();

				alert(data.message);
				return false;
			}

			Templates.showLink(Templates.link, Templates.value, "Watch video");
			Templates.setVideoId(Templates.link, data.video_id);
			Templates.bindVideoLink(Templates.link);

			Templates.toggleRequest();
			return false;
		});
	},
	validUrl: function(url)
	{
		// h/t to jquery validate library
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
	},
	getAnchorLink: function(element)
	{
		return $('#video_link a');
	},
	hideLink: function(element)
	{
		if(element.is(':visible')) {
			element.hide('fast', function() {
				$(this).attr('href', '{link}').text('{title}');
			});
		}
	},
	showLink: function(element, linkUrl, linkText)
	{
		linkText = linkText || "Watch Video";
		linkUrl = linkUrl || "";

		element.attr('href', linkUrl).text(linkText);

		if(!element.is(':visible')) {
			element.show();
		}
	},
	bindVideoLink: function(link)
	{
		link.on('click', loadVideo);
	},
	setVideoId: function(link, videoId)
	{
		videoId = videoId || "";

		var input = $("input[name='video_id']");

		if(input.length > 0) {
			input.val(videoId);
		}
	},
	toggleRequest: function()
	{
		return !this.running;
	},
	displayOptions : function(type)
	{
		var other;

		if(type == 'type-R') { other = 'type-S'; }
		if(type == 'type-S') { other = 'type-R'; }

		$('#' + other + '-fields').hide();
		$('#' + type + '-fields').show();
	},
	checkOptions : function(value)
	{
		return this.displayOptions('type-' + value);
	}
};

$(document).ready(function() {
	$('#type-R, #type-S').click(function() {
		return Templates.displayOptions($(this).attr('id'));
	});

	Templates.checkOptions($("input[name=type]:checked").val());

	$("#videos .check_video").on('change', Templates.validateVideo);

	if($("#video_dropdown").length > 0 && $("#video_dropdown").val()) {
		var video_url = $("#video_dropdown option:selected").text();
		var link = Templates.getAnchorLink();

		Templates.showLink(link, video_url, "Watch Video");
		Templates.bindVideoLink(link);
	}

	// scorecard rows
	try {
		var overallrows = $('#overallrows').sheepIt(Templates.loadOptions('O'));

		if(script_data.use_test_rows) {
			var testrows = $('#testrows').sheepIt(Templates.loadOptions('T'));
		}
	}
	catch(ex) {
		console.log(ex);
	}

	try {
		$("#template_builder").validate({
			errorClass: "required_marker"
		});
	}
	catch(ex) {
		console.log(ex);
	}

});

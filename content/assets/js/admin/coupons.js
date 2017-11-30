$(document).ready(function() {
	try {
		$(".datepicker").datepicker({
			minDate: new Date()
		});
	}
	catch(ex) {}

	$("#user_id").autocomplete({
		minLength: 3,
		source: function(request, callback) {
			$.post(script_data.user_search, request, function(response) {
				var list = [];

				$.each(response, function(id, user) {
					list.push('' + user.id + ' - ' + user.display_name);
				});

				// call the callback function
				callback(list);
			});
		}
	});
});

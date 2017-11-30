$(document).ready(function() {
	$(".toggle").on('click', function(e) {
		e.preventDefault();

		var list = $(this).closest("li").find(".nav-toggle");

		if(list.hasClass("open")) {
			hideList(list);
		}
		else {
			showList(list);
		}
	});

	$(".no-toggle").on('click', function(e) {
		e.preventDefault();

		return false;
	});

	$(".delete-btn").on('click', function(e) {
		if(!confirm('Are you sure that you wish to delete this item')) {
			return false;
		}
	});
});

function showList(list)
{
	list.slideDown('slow', function() {
		$(this).addClass('open');
	});
}

function hideList(list)
{
	list.slideUp('slow', function() {
		$(this).removeClass("open");
	});
}

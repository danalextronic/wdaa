$(document).ready(function() {
	$(".display-comment").on('click', function(e) {
		e.preventDefault();

		var comment = $(this).closest('.list-group-item').find('.comment');

		if(comment.is(':visible')) {
			comment.slideUp();
		}
		else {
			comment.slideDown();
		}
	});
});

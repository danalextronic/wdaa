var Scorecard = {
	init: function()
	{
		extract(Judge, this);
	},
	save_row: function(item) 
	{
		$.post(this.urls.save_row, {
			'item_id' : item.data('item-id'),
			'column' : item.data('column'),
			'value' : item.val(),
			'scorecard_id' : this.scorecard_id,
			'template_id' : this.template_id
		})
		.done(function(data) {
			var row = item.closest(".row-item"),
				cell = item.closest("td");

			if(data.row_complete) {
				Scorecard.setState(row, "success");
			}
			else {
				Scorecard.setState(cell, "success");
			}

			row.find('p.saved-message').fadeOut(500, function() {
				$(this).text(Scorecard.parseDateString(data.item.updated_at)).fadeIn(1000);
			});
		})
		.fail(function() {
			Scorecard.setState(item.closest("td"), "danger");
			Scorecard.notice("Could not save row!");
		});
	},

	save_manual_score : function(score)
	{
		var value = score.val();

		var input_container = score.closest(".input-group");
		this.removeInputError(input_container);

		if(value === '') {
			this.addInputError(input_container);
			this.notice("Please provide a value!");
			return false;
		}

		if(this.max_score !== null && parseFloat(value) > this.max_score) {
			this.addInputError(input_container);
			score.val('');
			this.notice("Please provide a value that is less than " + this.max_score);
			return false;
		}

		$.post(this.urls.save_score, {
			'scorecard_id' : this.scorecard_id,
			'score' : value
		})
		.done(function(data) {
			if(data.result != 'success') {
				Scorecard.notice(data.message);
				return false;
			}

			Scorecard.showDate(score.closest("#manual_score_container"), data.scorecard.updated_at);
		})
		.fail(function() {
			Scorecard.notice("Could not save manual score!");
		});
	},

	save_comment : function(comment)
	{
		$.post(this.urls.save_comment, {
			'scorecard_id' : this.scorecard_id,
			'comment' : comment.val()
		})
		.done(function(data) {
			if(data.result != 'success') {
				Scorecard.notice(data.message);
				return false;
			}

			Scorecard.showDate(comment.closest("#global_comment_container"), data.scorecard.updated_at);
		})
		.fail(function() {
			Scorecard.notice('Could not save global comment!');
		});
	},

	save_scorecard : function(object)
	{
		$.post(this.urls.validate_scorecard, {
			'scorecard_id' : this.scorecard_id
		})
		.done(function(data) {
			var row_items = $("tr.row-item");

			row_items.each(function(index) {
				$(this).removeClass('danger');
				var item_id  = $(this).data('item-id');

				if($.inArray(item_id, data.score.incomplete) > '-1') {
					$(this).addClass('danger');
				}
			});

			var buttons;

			if(data.complete) {
				buttons = {
					info : {
						'label' : 'Save Progress',
						'className' : 'btn-info pull-right'
					},
					success: {
						'label' : 'Mark Complete',
						'className' : 'btn-success pull-left',
						'callback' : $.proxy(Scorecard.mark_complete, Scorecard)
					}
				};
			}
			else {
				buttons = {
					success: {
						'label' : 'Continue Editing',
						'className' : 'btn-info'
					}
				};
			}

			bootbox.dialog({
				message: data.dialog,
				buttons: buttons
			});
		})
		.fail(function() {
			Scorecard.notice('There was an error saving this scorecard!');
		});
	},

	mark_complete : function() {
		$.post(this.urls.save_scorecard, {
			'scorecard_id' : this.scorecard_id
		})
		.done(function(data) {
			window.location = data.uri;
		})
		.fail(function() {
			Scorecard.notice("There was an unexpected error!");
		});
	},

	setState: function(object, className)
	{
		object.fadeOut(1500, function() {
			var oldClass = (className == 'success') ? 'danger' : 'success';

			if(object.hasClass(oldClass)) {
				object.removeClass(oldClass);
			}

			object.addClass(className).fadeIn(1500);
		});
	},

	notice: function(message)
	{
		bootbox.alert(message);
	},

	parseDateString : function(date)
	{
		var m = moment(date);

		return "Saved at " + m.format("hh:mmA");
	},

	showDate : function(object, date)
	{
		object.find(".panel-footer > .updated-score").fadeOut(1500, function() {
			$(this).text(Scorecard.parseDateString(date)).fadeIn(1000);
		});
	},

	addInputError : function(container)
	{
		container.addClass('has-error');
	},

	removeInputError : function(container)
	{
		container.removeClass('has-error');
	}
};

// attach AJAX handlers
$(document).ajaxStart(function() {
	$("input[type=submit]").prop('disabled', true);
	$("#loader").show();
});

$(document).ajaxStop(function() {
	$("input[type=submit]").prop('disabled', false);
	$("#loader").hide();
});

$(document).ready(function() {
	Scorecard.init();

	$("input:not(:hidden), select", ".row-item").on('change', function(e) {
		e.preventDefault();

		return Scorecard.save_row($(this));
	});

	$("#manual_score").on('blur', function(e) {
		e.preventDefault();

		return Scorecard.save_manual_score($(this));
	});

	$("#global_comment").on('blur', function(e) {
		e.preventDefault();

		return Scorecard.save_comment($(this));
	});

	$("#save_scorecard").on("click", function(e) {
		e.preventDefault();

		return Scorecard.save_scorecard($(this));
	});

	if(typeof Judge.fixable !== 'undefined' && Judge.fixable === true) {
		var attached = false;

		var sticky_offset_top = $('#sticky').offset().top;
		var sticky = function(){
			var sticky_div = $("#sticky");
			var scroll_top = $(window).scrollTop();
			var height = sticky_div.height();

			var table = $('.table-wrapper');

			if (scroll_top > sticky_offset_top && attached) {
				//sticky_div.css({ 'position': 'fixed', 'top': 0, 'width' : '48.5%'});
				sticky_div.addClass('attached');
				table.css('margin-top', height + 50);

			} else {
				sticky_div.removeClass('attached');
				//sticky_div.css({ 'position': 'relative', 'width' : '100%'});
				table.css('margin-top', 0);
			}
		};

		sticky();
		
		$(window).on('scroll', function() {	
			sticky();
		});
		
		// use touchmove to improve responsiveness on mobile devices and tablets
		$(window).on('touchmove', function() {
			sticky();
		});

		$('#detach_sticky').click(function() {
			if(attached) {
				attached = false;
				$(this).html('Attach  <i class="fa fa-unlock"></i>');
				$('#sticky').css({ 'position': 'relative' });
			}
			else {
				attached = true;
				$(this).html('Detach  <i class="fa fa-lock"></i>');
			}

			return false;
		});
	}
});

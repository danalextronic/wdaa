var Ranked = {

	modified : false,

	init: function()
	{
		extract(Judge, this);
	},

	saveSort : function(event, ui)
	{
		var sorted_ids = [];
		$('.sortable-item').each(function(new_position) {
			sorted_ids.push($(this).data('scorecard-id'));

			$(this).find('.ranked-position').html(new_position + 1);
		});

		this._ajax('save_sort', {
			scorecard_ids : sorted_ids,
			template_id : this.template_id
		});
	},

	loadVideo : function(scorecard_id)
	{
		this._ajax('load_scorecard', {
			'scorecard_id' : scorecard_id
		}, this.singleScorecard);
	},

	singleScorecard : function(response)
	{
		if(this.hasError(response)) {
			return false;
		}

		this.getScorecardContainer().html(response.view).fadeIn(1000);

		// bind events
		this._bind('.close', 'click', this.closeScorecard);
		this._bind('.global-comment', 'keyup', this.isModified);
		this._bind('.save-comment', 'click', this.saveComment);
	},

	saveComment : function(e)
	{
		var button = $(e.target),
			commentText = $(".global-comment").val(),
			scorecardId = button.data('scorecard-id');

		if(commentText === "") {
			bootbox.alert("Please provide a comment!");
			return false;
		}

		button.prop('disabled', true);

		var self = this;

		this._ajax('save_comment', {
			'scorecard_id' : scorecardId,
			'template_id'  : this.template_id,
			'global_comment' : commentText
		}, function(response) {
			if(self.hasError(response)) {
				button.prop('disabled', false);
				return false;
			}
			else {
				self.removeModified();

				self.closeScorecard();
				self.addCompleted(scorecardId);
				self.displayFlashMessage(response.message);

				if(response.can_mark_complete) {
					self.enableButton();
				}
			}
		});

		return false;
	},

	markComplete : function(button, template_id, scorecard_id)
	{
		button.prop('disabled', true);
		this.addLoader(button);

		this._ajax('mark_complete', {
			'template_id' : template_id,
			'scorecard_id' : scorecard_id
		}, function(response) {
			if(this.hasError(response)) {
				button.prop('disabled', false);
				this.removeLoader();
				return false;
			}

			window.location.href = response.uri;
		});
	},

	closeScorecard : function()
	{
		if(this.modified && !confirm(this.warningMessage())) {
			return false;
		}

		this.getScorecardContainer().fadeOut(1000, function() {
			$(this).html('');
		});
	},

	scorecardLoaded : function()
	{
		return (this.getScorecardContainer().html().length > 0);
	},

	getScorecardContainer : function()
	{
		return $("#single-scorecard");
	},

	isModified : function(e)
	{
		if(this.modified === false && e.target.text !== "") {
			this.modified = true;

			var message = this.warningMessage();

			$(window).on('beforeunload', function() {
				return message;
			});
		}
	},

	removeModified : function()
	{
		this.modified = false;
		$(window).off('beforeunload');
	},

	displayFlashMessage : function(message)
	{
		this.getScorecardContainer().after('<div class="alert alert-success" id="success_message">' + message + '</div>');

		setTimeout(function() {
			$("#success_message").fadeOut(1000, function() { $(this).remove(); });
		}, 5000);
	},

	addCompleted : function(scorecardId)
	{
		var container = $("#ranked-items").find('li[data-scorecard-id=' + scorecardId + ']');
		container.find('.ranked-position').after('<div class="completed"></div>');
	},

	_ajax : function(method, data, callback)
	{
		var url = this.urls[method] || false;

		if(!url) return false;

		callback = (typeof callback === 'function') ? $.proxy(callback, this) : null;

		$.post(url, data, callback);
	},

	_bind : function(selector, evt, callback)
	{
		$(selector).on(evt, $.proxy(callback, this));
	},

	hasError : function(response)
	{
		if(response.result != 'success') {
			bootbox.alert(response.message);
			return false;
		}
	},

	warningMessage : function()
	{
		return 'You have unsaved data on this form. Are you sure that you wish to leave?';
	},

	enableButton : function()
	{
		$('.mark-complete').prop('disabled', false);
	},

	addLoader : function(button)
	{
		button.after('<img src="/assets/images/loading-animation.gif" id="loader" />');
	},

	removeLoader : function() {
		$("#loader").remove();
	}
};

$(document).ready(function() {

	Ranked.init();

	$("#ranked-items").sortable({
		update: $.proxy(Ranked.saveSort, Ranked)
	});

	$(".load_ranked").on('click', function(e) {
		e.preventDefault();

		return Ranked.loadVideo($(this).data('scorecard-id'));
	});

	$(".mark-complete").on('click', function(e) {
		return Ranked.markComplete($(this), $(this).data('template-id'), $(this).data('scorecard-id'));
	});
});

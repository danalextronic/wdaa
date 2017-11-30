var Verification = {

	edit : function(id)
	{
		var container = this.getContainer(id);

		this.displayEditForm(container);
		this.hideButtons(container);
	},

	remove : function(id)
	{
		var container = this.getContainer(id);

		this.ajax(id, 'delete', function(response) {
			if(response.num_verifications > 0) {
				this.removeContainer(container);
			}

			window.location.reload();
		});
	},

	verify : function(id, order_id)
	{
		var container = this.getContainer(id);

		var button = container.find('.verify');

		button.before(this.getLoader())
			.prop('disabled', true);

		this.ajax(id, 'verify', function(response) {
			$("#loader").remove();
			console.log(response);
			if(response.result != 'success') {
				button.prop('disabled', false);
				alert('An error has occurred!');
				return false;
			}

			if(response.remaining > 0) {
				button.replaceWith('<p class="verified caption">' + response.text + '</p>');
			}

			window.location = "/verify?msg=complete";
		}, {
			order_id : order_id
		});
	},

	save : function(id)
	{
		var container = this.getContainer(id);

		if(container.find('.verification-edit .edit-comment').val() === '') {
			alert('Please provide a comment!');
			return false;
		}

		var editForm = container.find('.verification-edit');

		var data = {
			'comment' : editForm.find('.edit-comment').val(),
			'satisfactory' : editForm.find('input[name=satisfactory]:checked').val()
		};

		this.disableEditForm(editForm);

		this.ajax(id, 'edit', function(response) {
			this.enableEditForm(editForm);

			var displayForm = container.find('.verification-display');

			this.updateDisplayForm(displayForm, response.comment);

			this.updateTimestamp(displayForm, response.updated_time);

			this.showButtons(container);

			this.animateDisplayForm(container);
		}, data);
	},

	discard : function(id)
	{
		var container = this.getContainer(id);

		this.hideEditForm(container);
		this.showButtons(container);
	},

	displayEditForm : function(container)
	{
		container.find('.verification-display').hide();
		container.find('.verification-edit').show();
	},

	hideEditForm : function(container)
	{
		container.find('.verification-edit').hide();
		container.find('.verification-display').show();
	},

	disableEditForm : function(form)
	{
		form.find('textarea, input[type=radio], button').prop('disabled', true);
		form.find('.save-verification').before(this.getLoader());
	},

	enableEditForm : function(form)
	{
		form.find('textarea, input[type=radio], button').prop('disabled', false);
		form.find('#loader').remove();
	},

	updateDisplayForm : function(container, data)
	{
		// update comment
		container.find('.comment').text(data.comment);

		// update satisfactory label
		this.updateSatisfactoryLabel(container.find('.verification-badge'), data.satisfactory);
	},

	updateSatisfactoryLabel : function(label, state)
	{
		// 1. remove the old class
		//
		// since we don't have knowledge of what the existing class
		// is in our client side code, we will remove any
		// classes from the element that match the pattern
		label.removeClass(function(index, classes) {
			var classesArray = classes.split(" "),
				classesToRemove = [];

			$.each(classesArray, function(index, className) {
				if(className.match(/^badge-/)) {
					classesToRemove.push(className);
				}
			});

			return classesToRemove.join(" ");
		});

		// 2. based on the value, determine the new class to add
		var className, labelText;
		if(state == 1) {
			className = 'badge-success';
			labelText = 'Satisfactory';
		}
		else {
			className = 'badge-danger';
			labelText = 'Unsatisfactory';
		}

		// 3. add the class and update the text
		label.addClass(className).text(labelText);
	},

	animateDisplayForm : function(container)
	{
		container.find('.verification-edit').fadeOut(1000, function() {
			container.find('.verification-display').fadeIn(1000);
		});
	},

	updateTimestamp : function(container, timestamp)
	{
		var timestampContainer = container.find('.caption');
		timestampContainer.text("Last Updated: " + timestamp);

		if(timestampContainer.not(':visible')) {
			timestampContainer.show();
		}
	},

	getContainer : function(id)
	{
		return $("#item_" + id);
	},

	removeContainer : function(container)
	{
		container.fadeOut(1000, function() {
			container.remove();
		});
	},

	hideButtons : function(container)
	{
		container.find('.verification-buttons').hide();
	},

	showButtons : function(container)
	{
		container.find('.verification-buttons').show();
	},
	
	verifycompleted : function(id, order_id ){

		this.ajax(id, 'completed', function(response) {
			
			console.log(response );
			window.location = "/admin/status/completed";
		}, {
			order_id : order_id
		});
	},
	
	ajax : function(id, type, callback, args)
	{
		args = args || {};

		var url = "/verify/" + id;
		if(type != 'edit') {
			url += "/" + type;
		}

		$.post(url, $.extend({}, args, {'id' : id}), $.proxy(callback, this));
	},

	warningMsg : function()
	{
		return 'There are unsaved changes on the page. Are you sure that you wish to close?';
	},

	getLoader : function()
	{
		return '<img src="/assets/images/loading-animation.gif" id="loader" />';
	}
};

$(document).ready(function() {

	$(".edit-verification").on('click', function(e) {
		e.preventDefault();

		return Verification.edit($(this).data("verification-id"));
	});

	$(".save-verification").on('click', function(e) {
		e.preventDefault();

		return Verification.save($(this).data('verification-id'));
	});

	$(".discard-verification").on('click', function(e) {
		e.preventDefault();

		return Verification.discard($(this).data("verification-id"));
	});

	$(".remove-verification").on('click', function(e) {
		e.preventDefault();

		if(confirm('Are you sure that you wish to delete this comment?')) {
			return Verification.remove($(this).data("verification-id"));
		}
	});

	$(".verify").on('click', function(e) {
		e.preventDefault();

		return Verification.verify($(this).data("verification-id"), $(this).data('order-id'));
	});
	
	$(".verifycompleted").on('click', function(e) {
		//console.log("testtest");
		//e.preventDefault();
		//$(this).prop("disabled", "disabled");
		//$(this).val("Completing...");
		//return Verification.verifycompleted($(this).data('verification-id'), $(this).data("order-id"));
	});
});

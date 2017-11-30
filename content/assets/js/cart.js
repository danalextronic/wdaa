var Cart = {

	setKey : function(key)
	{
		Stripe.setPublishableKey(key);
	},

	paymentSubmitHandler : function(e)
	{
		var token = $("input[name=paymentToken]");

		if(token.length === 0 || token.val() === "") {
			// create token
			e.preventDefault();

			$("#paymentErrors").addClass('hide');

			var btn = $(this).find('input[type=submit]');

			Cart.disableButton(btn);
			Cart.addLoader(btn);

			Stripe.card.createToken({
				'address_line1' 	: $("#address").val(),
				'address_line2' 	: $("#address2").val(),
				'address_city'   	: $("#city").val(),
				'address_state'  	: $("#state").val(),
				'address_zip'    	: $("#zipcode").val(),
				'address_country'	: $("#country").val(),
				'number'    		: $("#card_number").val(),
				'exp_month'    		: $("#exp_month").val(),
				'exp_year'    		: $("#exp_year").val(),
				'cvc'    			: $("#cvc").val()
			}, Cart.verifyPaymentToken);
		}
	},

	verifyPaymentToken : function(status, response)
	{
		var form$ = $("#paymentForm");

		if(response.error)
		{
			Cart.enableButton(form$.find('input[type=submit]'));
			Cart.removeLoader();

			$("#paymentErrors").text(response.error.message).removeClass("hide");
		}
		else
		{
			// token contains id, last4, and card type
			var token = response['id'];

			// insert the token into the form so it gets submitted to the server
			form$.append("<input type='hidden' name='paymentToken' value='" + token + "'/>");

			// and submit
			form$.get(0).submit();
		}
	},

	removeItem : function(id, button)
	{
		var url = this.getRequestUri('removeItem');

		$.post(url, {
			'id' : id
		}, function(response) {
			if(response.result != 'success') {
				alert(response);
				return false;
			}

			Cart.updateCartTotal($(".prices .price:visible"), response.order.total);

			if(Cart.getRowCount() - 1 == 0) {
				window.location.reload();
			}
			else {
				Cart.removeRow(button.closest('tr'));
			}
		});
	},

	addCoupon : function(e)
	{
		e.preventDefault();

		var form = $(this);

		var couponCode = form.find('input[name="code"]').val();

		if(!couponCode) {
			Cart.addError(form.find('.form-group'));
			alert('Please provide a coupon code!');
			return false;
		}

		Cart.removeError(form.find('.form-group'));

		var submitBtn = form.find('button[type=submit]');

		Cart.addLoader(submitBtn);

		Cart.disableButton(submitBtn);

		$.post(Cart.getRequestUri('addCoupon'), {
			'couponCode' : couponCode
		}, function(data) {
			Cart.removeLoader();
			Cart.enableButton(submitBtn);

			if(data.result != 'success') {
				Cart.addError(form);
				alert(data.message);
				return false;
			}

			var row_id = 'order_' + data.applied_order_id;
			var discount;

			if(data.coupon_discount_type == 'percent') {
				discount = data.coupon_discount +'%';
			}
			else {
				discount = '$'+ data.coupon_discount;
			}

			$('#' + row_id +' .itemPriceWrapper').fadeOut(1000, function() {
				$('#' + row_id +' .itemPrice').addClass('strike-out');
				$('#' + row_id +' .discountedItemPrice .price').text(data.discounted_cost);
				$("#" + row_id + ' .discountedItemPrice').removeClass('hide');
				$(this).fadeIn(1000);
			});

			$('.cart_subtotal').fadeIn(1000);

			$('.totals').fadeOut(1000, function() {
				$(this).find('.checkoutTotal .price').text(data.total);
				$('.cart_subtotal').addClass('strike-out').removeClass('hide');
				$(this).fadeIn(1000);
			});

			Cart.toggleFreeOrder(data.total, data.orders.order.subtotal);

			$('.coupons').fadeOut(1000, function() {
				$(this).html(data.coupon_html).fadeIn(1000);
				$(".deleteCoupon").on('click', Cart.removeCoupon);
			});
		});
	},

	removeCoupon: function(e)
	{
		if(!confirm('Are you sure that you wish to remove this coupon?')) {
			return false;
		}

		var url = Cart.getRequestUri("removeCoupon");
		var form = $(this);

		Cart.addLoader(form);
		Cart.disableButton(form);

		$.post(url, {'couponId' : form.data('coupon-id')}, function(response) {
			Cart.removeLoader();
			Cart.enableButton(form);

			if(response.result != 'success') {
				alert(response.message);
				return false;
			}


			$('.itemPriceWrapper').fadeOut(1000, function() {
				$('.itemPrice').removeClass('strike-out');
				$('.discountedItemPrice').addClass('hide');
				$(this).fadeIn(1000);
			});

			Cart.updateCartTotal($(".checkoutTotal .price:visible"), response.total);

			if(response.total == response.orders.order.subtotal) {
				$('.cart_subtotal').fadeOut(2000);
			}

			Cart.toggleFreeOrder(response.total, response.orders.order.subtotal);

			$('.coupons').fadeOut(1000, function() {
				$(this).html(response.coupon_html).fadeIn(1000);

				// bind events
				$("#couponCode").on('keypress', function(e) {
					if(e.which === 13) {
						$("#add_coupon_form").submit();
					}
				});

				$("#add_coupon_form").on('submit', Cart.addCoupon);
			});
		});
	},

	removeRow : function(row)
	{
		row.fadeOut(1000, function() {
			row.remove();
			Cart.updateItemCount(Cart.getRowCount());
		});
	},

	getRowCount : function(table)
	{
		table = table || $("#itemTable");

		return table.find('tbody > tr').length;
	},

	updateItemCount : function(rows)
	{
		$("#numCartItems").text(rows);
	},

	updateCartTotal : function(element, total)
	{
		total = parseFloat(total).toFixed(2);

		element.fadeOut(1000, function() {
			$(this).html(total).fadeIn();
		});
	},

	getRequestUri : function(name)
	{
		return $("meta[name='" + name + "']").prop('content');
	},

	toggleError : function(element)
	{
		if(element.hasClass('has-error')) {
			this.removeError(element);
		}
		else {
			this.addError(element);
		}
	},

	addError : function(element)
	{
		element.addClass('has-error');
	},

	removeError : function(element)
	{
		element.removeClass('has-error');
	},

	addLoader : function(element)
	{
		element.after('<img src="/assets/images/loading-animation.gif" id="ajax_loader" />');
	},

	removeLoader : function()
	{
		$("#ajax_loader").remove();
	},

	disableButton : function(button)
	{
		button.prop('disabled', true);
	},

	enableButton : function(button)
	{
		button.prop('disabled', false);
	},

	toggleFreeOrder : function(total, subtotal)
	{
		if(total == 0) {
			return this.freeOrder(total, subtotal);
		}
		else {
			return this.paidOrder(total, subtotal);
		}
	},

	freeOrder : function(total, subtotal)
	{
		// disable the submit handler
		$("#paymentForm").off('submit');

		// hide the checkout confirmation fields
		$(".cardInformation").fadeOut(1000, function() {
			$(this).addClass('hide');
		});

		// enable the submit button
		this.enableButton($("#paymentForm").find('input[type=submit]'));
	},

	paidOrder : function(total, subtotal)
	{
		// enable the submit handler for payments
		$("#paymentForm").on('submit', this.paymentSubmitHandler);

		// display the checkout confirmation fields
		$(".cardInformation").removeClass('hide').fadeIn(1000);

		// disable the submit button
		this.disableButton($("#paymentForm").find('input[type=submit]'));
	}
};

$(document).ready(function() {

	// disable submit button on page load
	if($(".cardInformation").is(':visible')) {
		Cart.disableButton($("#paymentForm input[type=submit]"));
	}

	Cart.setKey($("meta[name=stripe_key]").prop('content'));

	// attach event handlers
	$(".deleteItem").on('click', function(e) {

		if(!confirm('Are you sure that you wish to remove this item?')) {
			return false;
		}

		var orderId = $(this).data('order-id');

		return Cart.removeItem(orderId, $(this));
	});

	$("#add_coupon_form").on('submit', Cart.addCoupon);

	$(".deleteCoupon").on('click', Cart.removeCoupon);

	$("#paymentForm").on('submit', Cart.paymentSubmitHandler);


	// method for validating our credit card number
	return $('#card_number').validateCreditCard(function(result) {
		if (result.card_type === null) {
			$('.cards li').removeClass('off');
			$('#card_number').removeClass('valid-card');
			Cart.disableButton($("#paymentForm input[type=submit]"));
			return;
		}

		$('.cards li').addClass('off');
		$('.cards .' + result.card_type.name).removeClass('off');

		if (result.length_valid && result.luhn_valid) {
			Cart.enableButton($("#paymentForm input[type=submit]"));
			return $('#card_number').addClass('valid-card');
		} else {
			Cart.disableButton($("#paymentForm input[type=submit]"));
			return $('#card_number').removeClass('valid-card');
		}
	});
});

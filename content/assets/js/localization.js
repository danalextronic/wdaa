var Localization = {
	init: function(country) {
		this.country = country;
		this.state = $("#state");
		this.zipcode = $("#zipcode");
		this.zipcode_label = this.zipcode.closest('.form-group').find('label');
		this.phone = $("#phone");
		this.ajax_url = Judge.states_url;
		this.userdata = Judge.user || {};
	},
	locale: function(object) {
		this.init(object.val());

		if(this.country == 'US') {
			if(this.zipcode_label.html().search("Postal") != -1) {
				this.zipcode_label.html('Zip Code:');
			}

			this.changeStateDropdown('state');
			this.updateMasks();

			return false;
		}

		// everywhere else...we change things to postal code
		this.zipcode_label.html('Postal Code:');

		this.updateMasks();

		if(this.country == 'CA' || this.country == 'AU') { 
			// make AJAX request to get the new states
			this.changeStateDropdown('province');

			return false;
		}

		this.state.closest('.form-group').hide('fast');
	},
	changeStateDropdown: function(text) {
		var that = this,
			state  = that.state;

		$.post(this.ajax_url, {
			country: this.country
		}, function(data) {
			if(data.result == 'success') {
				var select = state,
					state_div = state.closest('.form-group'),
					label = state_div.find('label'),
					html = [];
				
				html.push('<option value="">--Select ' + that.ucfirst(text) + '--</option>');
				$.each(data.states, function(key, value) {
					var current_value = that.getCurrentValue(key, "state");
					html.push('<option value="' + key + '"' + current_value + '>' + value + '</option>');
				});

				select.html(html.join("\n"));
				label.html(that.ucfirst(text));

				if(!that.is_visible(state_div)) { // show the div if it was hidden for some reason
					state_div.show('fast');
				}
			}
			else {
				alert(data.message);
			}
		});
	},
	updateMasks: function() {
		var zipcode = $('#zipcode'),
			phone = $('#phone'),
			zip_mask, phone_mask;

		if(this.country === undefined) {
			this.init($("#country").val());
		}

		switch(this.country.toLowerCase()) {
			case 'us': // United States
				zip_mask = '99999?-9999';
				phone_mask = '(999) 999-9999';
				break;
			case 'ca': // Canada
				zip_mask = 'a9a 9a9';
				phone_mask = '(999) 999-9999';
				break;
			case 'fr': // France
				zip_mask = '99999';
				phone_mask = '9999 999 999';
				break;
			case 'gr': // Germany
				zip_mask = '99999';
				phone_mask = '(999) 99999999';
				break;
			case 'mx': // Mexico
				zip_mask = '99999';
				phone_mask = '99* 999 9999';
				break;
			case 'gb': // Great Britan
				phone_mask = '999 9999 9999';
				break;
			case 'au': // Australia
				phone_mask = '(99) 9999 9999';
				break;
			case 'es' : // Spain
				zip_mask = '99999';
				phone_mask = '999 999 999';
				break;
			case 'nz' : // New Zealand
				zip_mask = '9999';
				break;
			case 'at' : // Austria
				zip_mask = '9999';
				phone_mask = '9 999 9999';
				break;
			case 'hu' : // Hungary
				zip_mask = '9999';
				phone_mask = '999 999?9';
				break;
			case 'pt' : // Portugal
				zip_mask = '9999';
				phone_mask = '99 999 9999';
				break;
			case 'br' : // Brazil
				zip_mask = '99999-999';
				phone_mask = '99 9999 9999';
				break;
			case 'ar' : // Argentina
				zip_mask = '99999-999';
				break;
			case 'cr' : // Costa Rica
				zip_mask = '99999';
				phone_mask = '9999-9999';
				break;
			default:
				zip_mask = '99999?-9999';
				phone_mask = '(999) 999-9999';
				break;
		}

		try {
			zipcode.unmask();
			phone.unmask();

			if(zip_mask !== undefined) {
				zipcode.mask(zip_mask);
			}

			if(phone_mask !== undefined) {
				phone.mask(phone_mask);
			}
		}
		catch(e) {
			console.log(e.message);
		}

	},
	is_visible: function(element) {
		return (element.is(":visible"));
	},
	ucfirst: function(string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	},
	getCurrentValue : function(value, field)
	{
		if(typeof this.userdata[field] !== 'undefined') {
			return (this.userdata[field] == value) ? 'selected="selected"' : '';
		}
	}
};

$(document).ready(function() {
	Localization.locale($("#country"));

	$("#country").on('change', function() {
		Localization.locale($(this));
	});
});

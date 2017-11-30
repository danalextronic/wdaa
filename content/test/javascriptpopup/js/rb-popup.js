(function ($) { 
	var RBPopupClass = function (el, opts) {
        var element = $(el);
        var options = opts;
		
		$(element).append('<div class="rb-arrow-btn show">-</div>');
		$(element).append('<div class="rb-header">' + options.header_title + '</div>');
		for (i = 0; i < options.choices.length; i++ ){
			if (i == 0 ){
				$(element).append('<div class="rb-options selected">' + options.choices[i] + '</div>');
			}else{
				$(element).append('<div class="rb-options">' + options.choices[i] + '</div>');
			}
		}
		$(element).append('<div class="rb-license">powered by robin</div>');
		if (options.is_final){
			$(element).append('<div class="rb-action">Send</div>');
		}else{
			$(element).append('<div class="rb-action">Next > </div>');
		}

		$(".rb-action").on("click", function(){
			handleAction();
		});

		var max_height = 70 + 46 * options.choices.length;
		$(element).css("width", "300px" );
		$(element).css("padding", "10px" );
		$(element).css("position", "fixed" );
		$(element).css("bottom", "0px" );
		$(element).css("right", options.pos_right + "px" );

		if (options.theme == "black" ){
			$(element).addClass("black-popup");
		}else if (options.theme == "yellow" ){
			$(element).addClass("yellow-popup");
		}else if (options.theme == "blue" ){
			$(element).addClass("blue-popup");
		}else{
			$(element).addClass("black-popup");
		}
       	
		if (options.is_open){
			$(element).css("height", max_height + "px" );
		}else{
			$(element).css("height", "35px" );
		}

        var clickOptions = function (e) {
			if (options.is_multiple){
				if ($(e.target).hasClass("selected")){
					$(e.target).removeClass("selected");
				}else{
					$(e.target).addClass("selected");
				}
			}else{
				$(".rb-options").removeClass("selected" );
				$(e.target).addClass("selected");
			}			

			return false;
        };

		var popupAnimation = function(e ){
          if ($(e.target).hasClass("show")){
				$(e.target).removeClass("show");
				$(e.target).addClass("close");
				$(e.target).html("×");
				showPopupWindow();
		  }else{
				$(e.target).removeClass("close");
				$(e.target).addClass("show");
				$(e.target).html("-");
				hidePopupWindow();
		  }
			return false;
		};

		var hidePopupWindow = function(){
			$(element).animate({
				height: max_height + 20
			}, 100, function() {
				$(element).animate({
					height: 35
				}, options.animation_time, function() {
				// Animation complete.
				});
			});
			return false;
		};

		var showPopupWindow = function(){
			$(element).animate({
				height: 10
			}, 100, function() {
				$(element).animate({
					height: max_height
				}, options.animation_time, function() {
				// Animation complete.
				});
			});
		};

        $(element).find('.rb-arrow-btn').bind('click', popupAnimation);
        $(element).find('.rb-options').bind('click', clickOptions);
        
    };

    $.fn.RBPopup = function (options) {
        var opts = $.extend({}, $.fn.RBPopup.defaults, options);

        return this.each(function () {
            new RBPopupClass($(this), opts);
        });
    }

    $.fn.RBPopup.defaults = {
		pos_right: 70,
        theme: "black",
		header_title: "What problem were you hoping to solve with our service?", 
		choices: Array("Multiple Choices"),
		animation_time: 500,
		is_multiple: true,
		is_final: false,
		is_open: false
    };

})(jQuery);

function getSelectedAnswer(){
	var objs = $(".rb-options");
	for (var i = 0; i < objs.length; i++ ){
		if ($(objs[i]).hasClass("selected") ){
			return $(objs[i]).html();
		}
	}
}
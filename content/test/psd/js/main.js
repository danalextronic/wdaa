$(document).ready(function(){
	$(".mobile-menu-label, .navbar-nav li").click(function(){
		if ($(".navbar-collapse").css("display") == "block" ){
			$(".navbar-collapse").css("display", "none");
		}else{
			$(".navbar-collapse").css("display", "block");
		}
	});

	$(".img-grid-content").hover(function(){
		$(".img-hover-content").css("opacity", "0");
		$(".img-hover-content", this).css("opacity", "1");
	});

	$(".img-grid-content").mouseleave(function(){
		$(".img-hover-content").css("opacity", "0");
	});

	$(window).scroll(function(){
		if ($(window).width() < 750){
			return;
		}
		var scroll_top = $(this).scrollTop();
		var offset_top = $(".logo-img").height();
		if (scroll_top > offset_top){
			$(".fixed-menu").css("position", "fixed");
			$(".fixed-menu").css("top", "0px");
		}else{
			$(".fixed-menu").css("position", "relative");
		}
	});
});
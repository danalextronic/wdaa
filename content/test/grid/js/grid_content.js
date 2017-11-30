var TOUR_LIST_URL = "grid.json";
var tour_lists;
var tour_list_container;
var tree_list_container;
var grid_data;
var selected_item = "folder-root";
var selected_ele = null;
var now_search_value = "";
var selected_level = 1;
var $tmp;
var regEx = "";
jQuery(window).load(function(){
	tree_list_container = jQuery(".tree-content-lists");
    tour_list_container = jQuery(".grid-content-lists");
    request(TOUR_LIST_URL, parse_tour_list ); 
});

function parse_tour_list(data ){
	grid_data = JSON.parse(data );
	var root_tree = $("<ul>").addClass("tree_root").appendTo(tree_list_container );
	var tmp_li = $("<li>")
		.attr("data-node", "folder-root" )
		.attr("class", "folder-root active" )
		.click(function(ev){
			var clsname = "folder-root active";
			$(".tree_root li").removeClass("active");
			$(this).addClass("active");
			ev.stopPropagation();
			if ($(this).find("ul").find("li").length > 0 ){
				if ($(this).find("i").html() == "-"){
					$(">div >i", this).html("+");
					$(">ul", this).css("display", "none" );
				}else{
					$(">div >i", this).html("-");
					$(">ul", this).css("display", "block" );
				}
			}
			if ($(this).attr("data-node") != selected_item ){
				if (selected_ele != null && clsname.indexOf(selected_item) < 0){
					if (selected_level > $(this).attr("data-level") ){
						var parent = $(selected_ele).parent().parent();
						$(">div >i", parent).html("+");
						$(">ul", parent).css("display", "none");
					}else{
						$(">div >i", selected_ele).html("+");
						$(">ul", selected_ele).css("display", "none");	
					}
					
				}
				selected_ele = $(this);
				selected_level = $(this).attr("data-level");
				selected_item = $(this).attr("data-node");
				$tmp.isotope();
				//search_tour();
				//$tmp.isotope({ filter: '.' + selected_item });

			}
		})
		.appendTo(root_tree );
	var tmp_div = $("<div>").appendTo(tmp_li );
	var tmp_i = $("<i>").text("-").appendTo(tmp_div );
	$("<span>").text("Vidabody" ).appendTo(tmp_div );				
	var tree_ul = $("<ul>").appendTo(tmp_li );
	create_tree_node(2, grid_data, tree_ul, "folder", "folder-root", true );

	return;
	tour_lists = JSON.parse(data );
	add_tour_list(tour_lists );

	tour_list_container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
}

function create_tree_node(level, node_data, parent_node, node_index_str, clsname, isRoot ){
	var tmp_cls = clsname;
	for (var i = 0; i < node_data.length; i++ ){
		if (level == 2 ){
			clsname = "folder-root " + node_index_str + "-" + i
		}else{
			clsname = tmp_cls + " " + node_index_str + "-" + i	
		}
		if (node_data[i].type == "folder" ){			
			var tmp_li = $("<li>")
				.attr("data-node", node_index_str + "-" + i )
				.attr("data-level", level )
				.attr("class", clsname )
				.click(function(ev){
					$(".tree_root li").removeClass("active");
					$(this).addClass("active");
					ev.stopPropagation();
					if ($(this).find("ul").find("li").length > 0 ){
						if ($(this).find("i").html() == "-"){
							$(">div >i", this).html("+");
							$(">ul", this).css("display", "none" );
						}else{
							$(">div >i", this).html("-");
							$(">ul", this).css("display", "block" );
						}
					}
					if ($(this).attr("data-node") != selected_item ){
						if (selected_ele != null && clsname.indexOf(selected_item) < 0){
							if (selected_level > $(this).attr("data-level") ){
								var parent = $(selected_ele).parent().parent();
								$(">div >i", parent).html("+");
								$(">ul", parent).css("display", "none");
							}else{
								$(">div >i", selected_ele).html("+");
								$(">ul", selected_ele).css("display", "none");	
							}
							
						}
						selected_ele = $(this);
						selected_level = $(this).attr("data-level");
						selected_item = $(this).attr("data-node");
						$tmp.isotope();
						//search_tour();
						//$tmp.isotope({ filter: '.' + selected_item });

					}
				})
				.appendTo(parent_node );
			var tmp_div = $("<div>")
							.css("padding-left", level * 15 + "px")
							.css("padding-top", "3px")
							.css("padding-bottom", "3px")
							.appendTo(tmp_li );
			var tmp_i = $("<i>").text("+").appendTo(tmp_div );
			$("<span>").text(node_data[i].name ).appendTo(tmp_div );				
			if (folder_count(node_data[i].children) < 1 ){
				$(tmp_i).css("display", "none");
			}
			if (node_data[i].children.length > 0 ){
				var tmp_ul = $("<ul>").appendTo(tmp_li );
				create_tree_node(level + 1, node_data[i].children, tmp_ul, node_index_str + "-" + i, clsname );	
			}
			
		}else if(node_data[i].type == "tour" ){
			add_tour(node_data[i], tour_list_container, clsname, 1 );
		}
	}
	if(isRoot) {
		$tmp = tour_list_container.isotope({
	        filter: function() {
	        	var flag = false;
	        	if (regEx ){
	        		if ($(this).text().match(regEx ) && $(this).attr("class").indexOf(selected_item ) > -1 ){
	        			flag = true;
	        		}else{
	        			flag = false;
	        		}
	        	}else{
	        		if ($(this).attr("class").indexOf(selected_item ) > -1 ){
	        			flag = true;
	        		}else{
	        			flag = false;
	        		}
	        	}
	        	return flag
    		},
	        animationOptions: {
	            duration: 750,
	            easing: 'linear',
	            queue: false
	        }
	    });
	}
}

function folder_count(node_data ){
	var ret = 0;
	for (var i = 0; i < node_data.length; i++ ){
		if (node_data[i].type == "folder" ){
			ret++;
		}
	}
	return ret;
}

function add_tour_list(tour_data ){
	for (var i = 0; i < tour_data.length; i++ ){
		add_tour(tour_data[i], tour_list_container, 1 );
	}
}

function searchkeyup(event ){
	if (event.keyCode == 13 ){
		runsearch();
	}
}

function runsearch(){
	var search_val = $(".search-input").val();
	if (now_search_value == search_val.toLowerCase() ){
		return;
	}
	now_search_value = search_val.toLowerCase();
	regEx = new RegExp( now_search_value, 'gi' );
    $tmp.isotope();
	//search_tour()
}

function search_tour(){
	var grid_contents = $(".grid-content-lists").find(".thumb-content");
	for (var i = 0; i < grid_contents.length; i++ ){
		var content_class = $(grid_contents[i]).attr("class").toLowerCase();
		var title = $(grid_contents[i]).find(".thumb-title").html().toLowerCase();
		var description = $(grid_contents[i]).find(".thumb-subtitle").html().toLowerCase();

		if ((content_class.indexOf(selected_item) > -1 ) && (title.indexOf(now_search_value) > -1 || description.indexOf(now_search_value) > -1 )){
			$(grid_contents[i]).css("display", "block");
		}else{
			$(grid_contents[i]).css("display", "none");
		}
	}
}

function show_modal_dialog(tour ){
	var white_div = jQuery("<div>")
			.addClass("modal-white-div")
			.css("height", $("body").height())
			.click(function(e){
				if (jQuery(e.target).attr("class") == "modal-white-div" ){
					$(".modal-white-div .thumb-content" ).animate({
					    opacity: 0
					}, 500, function() {
					    jQuery(".modal-white-div").remove();
					});
					
				}
			})
			.appendTo("body");
	add_tour(tour, white_div, "", 2 );
}

function add_tour(tour, parent, clsname, flag ){
	var thumb_content;
	if (flag == 1 ){
		thumb_content = jQuery("<div>")
			.attr("class", "thumb-content " + clsname )
			.appendTo(parent )
			.mousemove(function(e){
				$(this).find(".thumb-title").css("visibility", "hidden" );
				$(this).find(".thumb-subtitle").css("visibility", "hidden" );


			//if ($(e.target).attr("class").indexOf("thumb-content") > -1 ){
				var position = $(".grid-right").position();
				var posx = e.pageX - position.left - 16;
				var posy = e.pageY - 115;
				var width = $(".grid-right").width();
				var cell_width = 240 + 7 * 2;
				var cell_height = 233 + 7 * 2;
				var cell_count = parseInt(width / cell_width );
				var cell_col = parseInt(posx / cell_width );
				var cell_row = parseInt(posy / cell_height );
				
				var nowx = posx - cell_col * cell_width;
				var nowy = posy - cell_row * cell_height;
				
				var slide_count = $(".slides-count", this).attr("data-slide-count" );
				var slides = $(".slide-list", this).find("li");
				var slides_width = [];
				var total_width = 0;
				for (var i = 0; i < slides.length; i++ ){
					slides_width.push($(slides[i]).width() );
					total_width += $(slides[i]).width();
				}

				var ratio = ( total_width + 20)/ (cell_width - 14 );
				var slide_pos = nowx * ratio;
				
				if (total_width > (cell_width -14 )){
					var offset = nowx - slide_pos;
					$(".slide-list",this).css("left", offset + "px" );
				}

				var slide_index = 0;
				var tmp_sum = 0;
				var tmp_flag = false;
				for (var i = 0; i < slides.length - 1; i++ ){
					if (slide_pos > tmp_sum && slide_pos < tmp_sum + parseInt($(slides[i]).width())){
						slide_index = i;
						tmp_flag = true;
						break;
					}
					tmp_sum += parseInt($(slides[i]).width());
				}
				if (slide_pos < 10 ){
					slide_index = 0;
				}else if (tmp_flag == false ){
					slide_index = slides.length - 1;
				}
				var img_src = $("img", slides[slide_index]).attr("src");
				$(".thumb-img", this).prop("src", img_src );

				$(".slide-list li", this).removeClass("active");
				$(slides[i]).addClass("active");

			//}


			})
			.mouseleave(function(e){
				$(this).find(".thumb-title").css("visibility", "visible" );
				$(this).find(".thumb-subtitle").css("visibility", "visible" );
			})
			.hover(function(){
				$(".action-area").css("visibility", "hidden" );
				$(this).find(".action-area").css("visibility", "visible" );
			})
			.click(function(e){
				$(window).scrollTop(0);
				show_modal_dialog(tour );
			});
	}else{
		thumb_content = jQuery("<div>")
			.attr("class", "thumb-content" )
			.mousemove(function(e){
				$(this).find(".thumb-title").css("visibility", "hidden" );
				$(this).find(".thumb-subtitle").css("visibility", "hidden" );

			//if ($(e.target).attr("class").indexOf("thumb-content") > -1 ){
				var cell_width = 420;
				var posleft = ($('body').width() - $(this).width() ) / 2 - 9;
				var nowx = e.pageX - posleft;
		
				var slide_count = $(".slides-count", this).attr("data-slide-count" );
				var slides = $(".slide-list", this).find("li");
				var slides_width = [];
				var total_width = 0;
				for (var i = 0; i < slides.length; i++ ){
					slides_width.push($(slides[i]).width() );
					total_width += $(slides[i]).width();
				}

				var ratio = ( total_width + 20)/ (cell_width - 7 );
				var slide_pos = nowx * ratio;
				
				if (total_width > (cell_width -14 )){
					var offset = nowx - slide_pos;
					$(".slide-list",this).css("left", offset + "px" );
				}

				var slide_index = 0;
				var tmp_sum = 0;
				var tmp_flag = false;
				for (var i = 0; i < slides.length - 1; i++ ){
					if (slide_pos > tmp_sum && slide_pos < tmp_sum + parseInt($(slides[i]).width())){
						slide_index = i;
						tmp_flag = true;
						break;
					}
					tmp_sum += parseInt($(slides[i]).width());
				}
				if (slide_pos < 10 ){
					slide_index = 0;
				}else if (tmp_flag == false ){
					slide_index = slides.length - 1;
				}
				var img_src = $("img", slides[slide_index]).attr("src");
				$(".thumb-img", this).prop("src", img_src );

				$(".slide-list li", this).removeClass("active");
				$(slides[i]).addClass("active");

			//}
			})
			.mouseleave(function(e){
				$(this).find(".thumb-title").css("visibility", "visible" );
				$(this).find(".thumb-subtitle").css("visibility", "visible" );
			})
			.css("opacity", 0 )
			.appendTo(parent );
	}

	var thumb_title = jQuery("<span>")
			.addClass("thumb-title")
			.text(tour.title )
			.appendTo(thumb_content );

	var thumb_subtitle = jQuery("<div>")
			.addClass("thumb-subtitle")
			.text(tour.subtitle)
			.appendTo(thumb_content );

	var slides = tour.tour_data["slides"];

	var slides_count = jQuery("<div>")
			.addClass("slides-count")
			.attr("data-slide-count", slides.length )
			.text(slides.length + " slides" )
			.appendTo(thumb_content );

	var thumb_img = jQuery("<img>")
			.prop("src", slides[0].img_path )
			.addClass("thumb-img")
			.appendTo(thumb_content );

	var slide_list = jQuery("<ul>")
			.addClass("slide-list")
			.appendTo(thumb_content );

	var multi_val = 1;
	if (flag == 2 ){
		multi_val = 1.5;
	}
	for (var i = 0; i < slides.length; i++ ){
		var slide_data = jQuery("<li>")
				.addClass("slide-data")
				.attr("data-index", i )
				.attr("data-slide-count", slides.length )
				/*.css("left", i * jQuery(".slide-list li").width() * multi_val + "px")*/
				.css("top", "0px" )
				.click(function(e){
					return;
					var slide_ind = $(this).attr("data-index" );
					var slide_count = $(this).attr("data-slide-count" );

					var slide_width = $(this).width();
					var content_width = $(this).parent().width();

					var slide_av_count = parseInt(content_width / slide_width );
					var slide_list_left = $(this).parent().position().left;

					var av_left = 4 * slide_width;
					var slide_r_left = parseInt(slide_ind * slide_width + slide_list_left );
					if ( slide_r_left > av_left ){
						var diff = slide_r_left - av_left;
						$(this).parent().css("left", slide_list_left - diff + "px" );
					}
					if (slide_r_left < (slide_width + 2 ) ){
						if (slide_ind > 0 ){
							var tmp_left = slide_list_left + 2 * slide_width;
							if (tmp_left > 0 ){
								tmp_left = 0;
							}
							$(this).parent().css("left", tmp_left + "px" );
						}
					}
				})
                .hover(function(e){
                	return;
                    var slide_ind = $(this).attr("data-index" );
                    var slide_count = $(this).attr("data-slide-count" );
                    var parent_width = $(this).parent().parent().width();
                    var slide_width = $(this).width();
                    var content_width = $(this).parent().width();

                    var slide_av_count = parseInt(content_width / slide_width );
                    var slide_list_left = $(this).parent().position().left;

                    var av_left = parent_width / 	3 * 2;//4 * slide_width;
                    var slide_r_left = parseInt(slide_ind * slide_width + slide_list_left );
                    if ( slide_r_left > av_left ){
                        var diff = slide_r_left - av_left;
                        $(this).parent().css("left", slide_list_left - diff + "px" );
                    }
                    if (slide_r_left < (slide_width * 3 ) ){
                        if (slide_ind > 0 ){
                            var tmp_left = slide_list_left + 2 * slide_width;
                            if (tmp_left > 0 ){
                                tmp_left = 0;
                            }
                            $(this).parent().css("left", tmp_left + "px" );
                        }
                    }                    
                })
				.appendTo(slide_list );
		if (i == 0 ){
			jQuery(slide_data ).addClass("active");
		}
		var slide_content = jQuery("<img>")
				.addClass("slide-content")
				.prop("src", slides[i].img_path )
				.appendTo(slide_data )
                .hover(function(e){
                	return;
                    jQuery(thumb_img).prop("src", jQuery(this).prop("src") );
                    jQuery(slide_list ).find("li").removeClass("active");
                    jQuery(this).parent().addClass("active");                    
                })
				.click(function(e){
					return;
					jQuery(thumb_img).prop("src", jQuery(this).prop("src") );
					jQuery(slide_list ).find("li").removeClass("active");
					jQuery(this).parent().addClass("active");
				});
		change_slide_content_size(slide_content, slides[i].img_path );
	}

	var thumb_desc = jQuery("<div>")
			.addClass("thumb-desc")
			.text(tour.description )
			.appendTo(thumb_content );

	var thumb_links = jQuery("<ul>")
			.addClass("thumb-links")
			.appendTo(thumb_content );

	var thumb_eye_content = jQuery("<li>")
			.addClass("thumb-eye-content")
			.appendTo(thumb_links );

	var thumb_eye_icon = jQuery("<img>")
			.addClass("thumb-eye-icon")
			.prop("src", "images/icon3.png")
			.appendTo(thumb_eye_content );

	var thumb_eye_desc = jQuery("<span>")
			.addClass("thumb-eye-desc")
			.text("132")
			.appendTo(thumb_eye_content );

	var thumb_comment_content = jQuery("<li>")
			.addClass("thumb-eye-content")
			.appendTo(thumb_links );

	var thumb_comment_icon = jQuery("<img>")
			.addClass("thumb-comment-icon")
			.prop("src", "images/icon2.png")
			.appendTo(thumb_comment_content );

	var thumb_comment_desc = jQuery("<span>")
			.addClass("thumb-comment-desc")
			.text("132")
			.appendTo(thumb_comment_content );

	var thumb_hard_content = jQuery("<li>")
			.addClass("thumb-hard-content")
			.appendTo(thumb_links );

	var thumb_hard_icon = jQuery("<img>")
			.addClass("thumb-hard-icon")
			.prop("src", "images/icon1.png")
			.appendTo(thumb_hard_content );

	var thumb_hard_desc = jQuery("<span>")
			.addClass("thumb-hard-desc")
			.text("132")
			.appendTo(thumb_hard_content );

	var author_content = jQuery("<div>")
			.addClass("author-content")
			.appendTo(thumb_content );

	var author_photo = jQuery("<img>")
			.addClass("author-photo")
			.prop("src", "images/user.png")
			.appendTo(author_content );

	var author_info = jQuery("<div>")
			.addClass("author-info")
			.appendTo(author_content );

	var author_name = jQuery("<div>")
			.addClass("author-name")
			.html("By <font style='color: #6ba5b1;'>" + tour.author_name + "</font>")
			.appendTo(author_info );

	var author_desc = jQuery("<div>")
			.addClass("author_desc")
			.text(tour.author_desc )
			.appendTo(author_info );

	var action_area = jQuery("<ul>")
			.addClass("action-area")
			.appendTo(thumb_content );

	var action_play_content = jQuery("<li>")
			.addClass("action-play-content")
			.appendTo(action_area );

	var action_play_icon = jQuery("<img>")
			.addClass("action-play-icon")
			.prop("src", "images/play.png")
			.appendTo(action_play_content );

	var action_play_desc = jQuery("<span>")
			.addClass("action-play-desc")
			.text("play this tour")
			.appendTo(action_play_content );

	var action_add_content = jQuery("<li>")
			.addClass("action-add-content")
			.appendTo(action_area );

	var action_add_icon = jQuery("<img>")
			.addClass("action-add-icon")
			.prop("src", "images/add.png")
			.appendTo(action_add_content );

	var action_add_desc = jQuery("<span>")
			.addClass("action-add-desc")
			.text("add list")
			.appendTo(action_add_content );	

	var slide_top = $(slide_list ).position().top - $(thumb_content ).position().top ;

	if (flag == 1 ){
		if (slide_top < 192 ){
			var diff = 192 - slide_top;
			$(slides_count ).css("margin-bottom", diff + "px" );
		}
	}else if (flag == 2 ){
		$(thumb_content ).animate({
		    opacity: 1
		}, 500, function() {
		    // Animation complete.
		});

		if (slide_top < 307 ){
			var diff = 307 - slide_top;
			$(slides_count ).css("margin-bottom", diff + "px" );
		}
	}
}

function change_slide_content_size(ele, src ){
	/*var img = new Image();
	img.onload = function() {
	  var width = this.width * 32 / this.height;
	  $(ele).css("width", width + "px");
	  $(ele).parent().css("width", width + "px");
	}
	img.src = src;*/
}

request = function(url, callback) {
  var xhr;
  xhr = new XMLHttpRequest;
  xhr.open("GET", url, true);
  xhr.onload = (function() {
    if ((xhr.status == 200)) {
      callback(xhr.response);
    } else {
      throw ("Error loading " + url);
    }

  });
  xhr.send();
};



/****
TOUR_LIST_URL = "tour_lists.json"
tour_lists
tour_list_container

def f():
    tour_list_container = jQuery(".grid-content-lists")
    request(TOUR_LIST_URL, parse_tour_list )

def parse_tour_list(data ):
    tour_lists = JSON.parse(data )
    add_tour_list(tour_lists )

    tour_list_container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    })

def add_tour_list(tour_data ):
    for tmp_tour in tour_data:
        add_tour(tmp_tour, tour_list_container, 1 )

def show_modal_dialog(tour ):
    white_div = jQuery("<div>")
        .addClass("modal-white-div")
        .css("height", jQuery("body").height())
        .click(function(e){
            if jQuery(e.target).attr("class") == "modal-white-div":
                jQuery(".modal-white-div .thumb-content" ).animate({
                        opacity: 0
                    }, 500, function() {
                        jQuery(".modal-white-div").remove()
                })
        })
        .appendTo("body")
    add_tour(tour, white_div, 2 )

def add_tour(tour, parent, flag ):
    thumb_content
    if flag == 1:
        thumb_content = jQuery("<div>")
            .addClass("thumb-content")
            .appendTo(parent )
            .mousemove(function(e){
                jQuery(this).find(".thumb-title").css("visibility", "hidden" )
                jQuery(this).find(".thumb-subtitle").css("visibility", "hidden" )
            })
            .mouseleave(function(e){
                jQuery(this).find(".thumb-title").css("visibility", "visible" )
                jQuery(this).find(".thumb-subtitle").css("visibility", "visible" )
            })
            .hover(function(){
                jQuery(".action-area").css("visibility", "hidden" )
                jQuery(this).find(".action-area").css("visibility", "visible" )
            })
            .click(function(e){
                jQuery(window).scrollTop(0)
                show_modal_dialog(tour )
            })
    else:
        thumb_content = jQuery("<div>")
            .addClass("thumb-content")
            .mousemove(function(e){
                jQuery(this).find(".thumb-title").css("visibility", "hidden" )
                jQuery(this).find(".thumb-subtitle").css("visibility", "hidden" )
            })
            .mouseleave(function(e){
                jQuery(this).find(".thumb-title").css("visibility", "visible" )
                jQuery(this).find(".thumb-subtitle").css("visibility", "visible" )
            })
            .css("opacity", 0 )
            .appendTo(parent )

    thumb_title = jQuery("<span>")
        .addClass("thumb-title")
        .text(tour.title )
        .appendTo(thumb_content )

    thumb_subtitle = jQuery("<div>")
        .addClass("thumb-subtitle")
        .text(tour.subtitle)
        .appendTo(thumb_content )

    slides = tour.tour_data["slides"]

    slides_count = jQuery("<div>")
        .addClass("slides-count")
        .text(slides.length + " slides" )
        .appendTo(thumb_content )

    thumb_img = jQuery("<img>")
        .prop("src", slides[0].img_path )
        .addClass("thumb-img")
        .appendTo(thumb_content )

    slide_list = jQuery("<ul>")
        .addClass("slide-list")
        .appendTo(thumb_content )

    multi_val = 1
    if flag == 2:
        multi_val = 1.5

    i = 0
    for tmp_slide in slides:
        slide_data = jQuery("<li>")
            .addClass("slide-data")
            .attr("data-index", i )
            .attr("data-slide-count", slides.length )
            .css("left", i * jQuery(".slide-list li").width() * multi_val + "px")
            .css("top", "0px" )
            .click(function(e){
                slide_ind = jQuery(this).attr("data-index" )
                slide_count = jQuery(this).attr("data-slide-count" )

                slide_width = jQuery(this).width()
                content_width = jQuery(this).parent().width()

                slide_av_count = parseInt(content_width / slide_width )
                slide_list_left = jQuery(this).parent().position().left

                av_left = 4 * slide_width
                slide_r_left = parseInt(slide_ind * slide_width + slide_list_left )
                if slide_r_left > av_left:
                    diff = slide_r_left - av_left
                    jQuery(this).parent().css("left", slide_list_left - diff + "px" )
                
                if slide_r_left < (slide_width + 2 ):
                    if slide_ind > 0:
                        tmp_left = slide_list_left + 2 * slide_width
                        if tmp_left > 0:
                            tmp_left = 0
                        jQuery(this).parent().css("left", tmp_left + "px" )
            })
            .appendTo(slide_list )

        if i == 0:
            jQuery(slide_data ).addClass("active")

        slide_content = jQuery("<img>")
            .addClass("slide-content")
            .prop("src", slides[i].img_path )
            .appendTo(slide_data )
            .click(function(e){
                jQuery(thumb_img).prop("src", jQuery(this).prop("src") )
                jQuery(slide_list ).find("li").removeClass("active")
                jQuery(this).parent().addClass("active")
            })

    thumb_desc = jQuery("<div>")
        .addClass("thumb-desc")
        .text(tour.description )
        .appendTo(thumb_content )

    thumb_links = jQuery("<ul>")
        .addClass("thumb-links")
        .appendTo(thumb_content )

    thumb_eye_content = jQuery("<li>")
        .addClass("thumb-eye-content")
        .appendTo(thumb_links )

    thumb_eye_icon = jQuery("<img>")
        .addClass("thumb-eye-icon")
        .prop("src", "images/icon3.png")
        .appendTo(thumb_eye_content )

    thumb_eye_desc = jQuery("<span>")
        .addClass("thumb-eye-desc")
        .text("132")
        .appendTo(thumb_eye_content )

    thumb_comment_content = jQuery("<li>")
        .addClass("thumb-eye-content")
        .appendTo(thumb_links )

    thumb_comment_icon = jQuery("<img>")
        .addClass("thumb-comment-icon")
        .prop("src", "images/icon2.png")
        .appendTo(thumb_comment_content )

    thumb_comment_desc = jQuery("<span>")
        .addClass("thumb-comment-desc")
        .text("132")
        .appendTo(thumb_comment_content )

    thumb_hard_content = jQuery("<li>")
        .addClass("thumb-hard-content")
        .appendTo(thumb_links )

    thumb_hard_icon = jQuery("<img>")
        .addClass("thumb-hard-icon")
        .prop("src", "images/icon1.png")
        .appendTo(thumb_hard_content )

    thumb_hard_desc = jQuery("<span>")
        .addClass("thumb-hard-desc")
        .text("132")
        .appendTo(thumb_hard_content )

    author_content = jQuery("<div>")
        .addClass("author-content")
        .appendTo(thumb_content )

    author_photo = jQuery("<img>")
        .addClass("author-photo")
        .prop("src", "images/user.png")
        .appendTo(author_content )

    author_info = jQuery("<div>")
        .addClass("author-info")
        .appendTo(author_content )

    author_name = jQuery("<div>")
        .addClass("author-name")
        .html("By <font style='color: #6ba5b1'>" + tour.author_name + "</font>")
        .appendTo(author_info )

    author_desc = jQuery("<div>")
        .addClass("author_desc")
        .text(tour.author_desc )
        .appendTo(author_info )

    action_area = jQuery("<ul>")
        .addClass("action-area")
        .appendTo(thumb_content )

    action_play_content = jQuery("<li>")
        .addClass("action-play-content")
        .appendTo(action_area )

    action_play_icon = jQuery("<img>")
        .addClass("action-play-icon")
        .prop("src", "images/play.png")
        .appendTo(action_play_content )

    action_play_desc = jQuery("<span>")
        .addClass("action-play-desc")
        .text("play this tour")
        .appendTo(action_play_content )

    action_add_content = jQuery("<li>")
        .addClass("action-add-content")
        .appendTo(action_area )

    action_add_icon = jQuery("<img>")
        .addClass("action-add-icon")
        .prop("src", "images/add.png")
        .appendTo(action_add_content )

    action_add_desc = jQuery("<span>")
        .addClass("action-add-desc")
        .text("add list")
        .appendTo(action_add_content ) 

    slide_top = jQuery(slide_list ).position().top - jQuery(thumb_content ).position().top 

    if flag == 1:
        if slide_top < 192:
            diff = 192 - slide_top
            jQuery(slides_count ).css("margin-bottom", diff + "px" )
    elif flag == 2:
        jQuery(thumb_content ).animate({opacity: 1}, 500)

    if slide_top < 307:
        diff = 307 - slide_top
        jQuery(slides_count ).css("margin-bottom", diff + "px" )


window.addEventListener("load", f)
*******/
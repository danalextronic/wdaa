function create_node_hover_modal(ele, parent_element ){
  var modal_back = new_div_class("hover-node-modal", parent_element );
  modal_back.setAttribute("class","hover-node-modal hover-graph-modal");

  hover_node_selection(ele, modal_back );
  color_element(ele, modal_back );
}

function hover_node_selection(ele, parent_element ){
  var ul_node_selection = new_element_class("ul", "node-selection", parent_element );

  var li_node_font = new_element_class("li", "node-font", ul_node_selection );
  set_attributes(li_node_font, {style: "left: 0px", title:"node font" });
  var li_node_font_img = new_element_class("img", "node-font", li_node_font );
  set_attributes(li_node_font_img, {src: "images/font.png", style: "width: 24px;" });

  var li_node_fill = new_element_class("li", "node-fill", ul_node_selection );
  set_attributes(li_node_fill, {style: "left: 29px", title:"node fill" });
  var li_node_fill_img = new_element_class("img", "node-fill", li_node_fill );
  set_attributes(li_node_fill_img, {src: "images/nodefill.png", style: "width: 24px;" });

  var li_node_outline = new_element_class("li", "node-outline", ul_node_selection );
  set_attributes(li_node_outline, {style: "left: 58px", title:"node outline" });
  var li_node_outline_img = new_element_class("img", "node-outline", li_node_outline );
  set_attributes(li_node_outline_img, {src: "images/nodeout.png", style: "width: 24px;" });

  hover_font_style(ele, parent_element );
  hover_fill_style(ele, parent_element );
  hover_outline_style(ele, parent_element );

  hover_node_selection_event(ul_node_selection );
  set_class_event(document.getElementsByClassName("hover-node-modal"), "mouseleave", modal_div_leave );
}

function hover_font_style(ele, parent_element ){
  var ul_font_style = new_element_class("ul", "ul-node-font", parent_element );
  ul_font_style.setAttribute("class","ul-node-font hover-vert-selection");

  var li_font_size = new_element_class("li", "font-size", ul_font_style );
  set_attributes(li_font_size, {title:"node font size"} );
  var li_font_size_img = new_element_class("img", "font-size", li_font_size );
  set_attributes(li_font_size_img, {src: "images/font-size.png", style: "width: 24px;"} );

  var li_font_type = new_element_class("li", "font-type", ul_font_style );
  set_attributes(li_font_type, {title:"node font type"} );
  var li_font_type_img = new_element_class("img", "font-type", li_font_type );
  set_attributes(li_font_type_img, {src: "images/font-style.png", style: "width: 24px;"} );

  var li_font_color = new_element_class("li", "font-color", ul_font_style );
  set_attributes(li_font_color, {title:"node font color", class:"font-color color-area-li"} );
  var li_font_color_img = new_element_class("img", "font-color", li_font_color );
  set_attributes(li_font_color_img, {src: "images/font-color.png", style: "width: 24px;"} );

  hover_font_size(ele, parent_element );
  hover_font_type(ele, parent_element );

  hover_subnode_selection_event(ul_font_style );
}

function hover_font_size(ele, parent_element ){
  var ul_font_size = new_element_class("ul", "ul-font-size", parent_element );
  ul_font_size.setAttribute("class", "ul-font-size hover-horz-selection" );

  var li_font_big = new_element_class("li", "node-font-big", ul_font_size );
  set_attributes(li_font_big, {title:"node font big"} );
  var li_font_big_img = new_element_class("img", "node-font-big", li_font_big );
  set_attributes(li_font_big_img, {src: "images/font-big.png", style: "width: 24px;" } ); 

  var li_font_small = new_element_class("li", "node-font-small", ul_font_size );
  set_attributes(li_font_small, {title:"node font small"} );
  var li_font_small_img = new_element_class("img", "node-font-small", li_font_small );
  set_attributes(li_font_small_img, {src: "images/font-small.png", style: "width: 24px;" } ); 

  select_node_info_event(ul_font_size );
}

function hover_font_type(ele, parent_element ){
  var ul_font_type = new_element_class("ul", "ul-font-type", parent_element );
  ul_font_type.setAttribute("class", "ul-font-type hover-horz-selection" );

  var li_font_under = new_element_class("li", "node-font-under", ul_font_type );
  set_attributes(li_font_under, {title:"node font under style"} );
  var li_font_under_img = new_element_class("img", "node-font-under", li_font_under );
  set_attributes(li_font_under_img, {src: "images/font-under.png", style: "width: 24px;" } ); 

  var li_font_bold = new_element_class("li", "node-font-bold", ul_font_type );
  set_attributes(li_font_bold, {title:"node font bold style"} );
  var li_font_bold_img = new_element_class("img", "node-font-bold", li_font_bold );
  set_attributes(li_font_bold_img, {src: "images/font-bold.png", style: "width: 24px;" } );   

  var li_font_italy = new_element_class("li", "node-font-italy", ul_font_type );
  set_attributes(li_font_italy, {title:"node font italy style"} );
  var li_font_italy_img = new_element_class("img", "node-font-italy", li_font_italy );
  set_attributes(li_font_italy_img, {src: "images/font-italy.png", style: "width: 24px;" } ); 

  select_node_info_event(ul_font_type ); 
}


function hover_fill_style(ele, parent_element ){
  var ul_fill_style = new_element_class("ul", "ul-node-fill", parent_element );
  ul_fill_style.setAttribute("class", "hover-vert-selection ul-node-fill" );

  var li_fill_type = new_element_class("li", "fill-type", ul_fill_style );
  set_attributes(li_fill_type, {style: "", title:"node fill type"} );
  var li_fill_type_img = new_element_class("img", "fill-type", li_fill_type );
  set_attributes(li_fill_type_img, {src:"images/nodeshape.png", style: "width: 24px;"} );

  var li_fill_color = new_element_class("li", "fill-color", ul_fill_style );
  set_attributes(li_fill_color, {title:"node fill color", class:"fill-color color-area-li"} );
  var li_fill_color_img = new_element_class("img", "fill-color", li_fill_color );
  set_attributes(li_fill_color_img, {src:"images/font-color.png", style: "width: 24px;"} );

  hover_fill_type(ele, parent_element );
  hover_subnode_selection_event(ul_fill_style );
}

function hover_fill_type(ele, parent_element ){
  var ul_fill_shape = new_element_class("ul", "ul-fill-type", parent_element );
  ul_fill_shape.setAttribute("class", "ul-fill-type hover-horz-selection" );

  var li_none = new_element_class("li", "node-none", ul_fill_shape );
  set_attributes(li_none, {style: "", title:"node none"} );
  var li_none_img = new_element_class("img", "node-none", li_none );
  set_attributes(li_none_img, {src:"images/none.png", style: "width: 24px;"} ); 

  var li_fill_none = new_element_class("li", "node-fill-none", ul_fill_shape );
  set_attributes(li_fill_none, {style: "", title:"node fill none"} );
  var li_fill_none_img = new_element_class("img", "node-fill-none", li_fill_none );
  set_attributes(li_fill_none_img, {src:"images/shapenone.png", style: "width: 24px;"} );  

  var li_fill_square = new_element_class("li", "node-fill-square", ul_fill_shape );
  set_attributes(li_fill_square, {style: "", title:"node fill square"} );
  var li_fill_square_img = new_element_class("img", "node-fill-square", li_fill_square );
  set_attributes(li_fill_square_img, {src:"images/square.png", style: "width: 24px;"} );  

  var li_fill_rect = new_element_class("li", "node-fill-rect", ul_fill_shape );
  set_attributes(li_fill_rect, {style: "", title:"node fill rect"} );
  var li_fill_rect_img = new_element_class("img", "node-fill-rect", li_fill_rect );
  set_attributes(li_fill_rect_img, {src:"images/shaperect.png", style: "width: 24px;"} );  

  var li_fill_round = new_element_class("li", "node-fill-round", ul_fill_shape );
  set_attributes(li_fill_round, {style: "", title:"node fill round"} );
  var li_fill_round_img = new_element_class("img", "node-fill-round", li_fill_round );
  set_attributes(li_fill_round_img, {src:"images/shaperound.png", style: "width: 24px;"} );  

  var li_fill_circle = new_element_class("li", "node-fill-circle", ul_fill_shape );
  set_attributes(li_fill_circle, {style: "", title:"node fill circle"} );
  var li_fill_circle_img = new_element_class("img", "node-fill-circle", li_fill_circle );
  set_attributes(li_fill_circle_img, {src:"images/shapecircle.png", style: "width: 24px;"} ); 

  select_node_info_event(ul_fill_shape ); 
}

function hover_outline_style(ele, parent_element ){
  var ul_outline_style = new_element_class("ul", "ul-node-outline", parent_element );
  ul_outline_style.setAttribute("class", "ul-node-outline hover-vert-selection");

  /*var li_outline_type = new_element_class("li", "outline-type", ul_outline_style );
  set_attributes(li_outline_type, {style: ""} );
  var li_outline_type_img = new_element_class("img", "outline-type", li_outline_type );
  set_attributes(li_outline_type_img, {src: "images/outline.png", style:"width: 24px;"} );*/

  var li_linewid_type = new_element_class("li", "linewid-type", ul_outline_style );
  set_attributes(li_linewid_type, {style: "", title:"node line width"} );
  var li_linewid_type_img = new_element_class("img", "linewid-type", li_linewid_type );
  set_attributes(li_linewid_type_img, {src: "images/linewid.png", style:"width: 24px;"} );

  var li_outline_color = new_element_class("li", "outline-color", ul_outline_style );
  set_attributes(li_outline_color, {title:"node outline color", class:"outline-color color-area-li"} );
  var li_outline_color_img = new_element_class("img", "outline-color", li_outline_color );
  set_attributes(li_outline_color_img, {src: "images/font-color.png", style:"width: 24px;"} );

 //hover_outline_type(ele, parent_element );
  hover_linewid_type(ele, parent_element );

  hover_subnode_selection_event(ul_outline_style );
}

function hover_outline_type(ele, parent_element ){
  var ul_nodeout_type = new_element_class("ul", "ul-outline-type", parent_element );
  ul_nodeout_type.setAttribute("class", "ul-outline-type hover-horz-selection" );

  var li_node_line = new_element_class("li", "node-line", ul_nodeout_type );
  set_attributes(li_node_line, {style: "", title:"node line type"} );
  var li_node_line_img = new_element_class("img", "node-line", li_node_line );
  set_attributes(li_node_line_img, {src: "images/outline1.png", style:"width: 24px;"} );

  var li_node_dot1 = new_element_class("li", "node-dot1", ul_nodeout_type );
  set_attributes(li_node_dot1, {style: "", class:"node dot type1"} );
  var li_node_dot1_img = new_element_class("img", "node-dot1", li_node_dot1 );
  set_attributes(li_node_dot1_img, {src: "images/outline2.png", style:"width: 24px;"} );

  var li_node_dot2 = new_element_class("li", "node-dot2", ul_nodeout_type );
  set_attributes(li_node_dot2, {style: "", title:"node dot type2"} );
  var li_node_dot2_img = new_element_class("img", "node-dot2", li_node_dot2 );
  set_attributes(li_node_dot2_img, {src: "images/outline3.png", style:"width: 24px;"} );

  select_node_info_event(ul_nodeout_type );
}

function hover_linewid_type(ele, parent_element ){
  var ul_linewid_type = new_element_class("ul", "ul-linewid-type", parent_element );
  ul_linewid_type.setAttribute("class", "ul-linewid-type hover-horz-selection" );

  var li_linewid_1 = new_element_class("li", "node-linewid-1", ul_linewid_type );
  set_attributes(li_linewid_1, {style: "", title:"node line width 1"} );
  var li_linewid_1_img = new_element_class("img", "node-linewid-1", li_linewid_1 );
  set_attributes(li_linewid_1_img, {src: "images/linewid1.png", style:"width: 24px;"} );

  var li_linewid_2 = new_element_class("li", "node-linewid-2", ul_linewid_type );
  set_attributes(li_linewid_2, {style: "", title:"node line width 2"} );
  var li_linewid_2_img = new_element_class("img", "node-linewid-2", li_linewid_2 );
  set_attributes(li_linewid_2_img, {src: "images/linewid2.png", style:"width: 24px;"} );

  var li_linewid_3 = new_element_class("li", "node-linewid-3", ul_linewid_type );
  set_attributes(li_linewid_3, {style: "", title:"node line width 3"} );
  var li_linewid_3_img = new_element_class("img", "node-linewid-3", li_linewid_3 );
  set_attributes(li_linewid_3_img, {src: "images/linewid3.png", style:"width: 24px;"} );

  select_node_info_event(ul_linewid_type );
}

function color_element(ele, parent_element ){
	var color_div = new_div_class("color-modal", parent_element );
	set_color_div(color_div );
	set_class_event(color_div.getElementsByTagName("div"), "mousedown", mousedown_color );
	set_class_event(color_div.getElementsByTagName("div"), "mousemove", mousemove_color );
	set_class_event(color_div.getElementsByTagName("div"), "mouseup", mouseup_color );
}

function set_color_div(parent_element ){
	//var canvas = new_element_class("canvas", "color_canvas", parent_element );
	var canv_width = 110;//parent_element.offsetWidth;
	var canv_height = 110;//parent_element.offsetHeight;
	//set_attributes_to_class("color_canvas", {style:"position: relative; left: 0px; top:0px; width: " + canv_width + "px; height: " + canv_height + "px;"});

	var c_x = canv_width / 2;
	var c_y = canv_height / 2;
	var color_r = 42;
	for (var i = 0; i < 32; i++){
		var pos = get_position_from_angle(c_x - 21, c_y-21, 30, Math.PI * 2 / 32 * i);
		var color = get_color_i(i, 3 );
		var ele = new_div_class("color-palate", parent_element );
		ele.id = "color-" + i;
		set_attributes(ele, {style:"cursor:pointer; position: absolute; z-index: 10; background:" + color + "; width: 42px; height: 42px; border-radius: 42px; position: absolute; left: " + pos.x + "px; top: " + pos.y + "px;"} );
	}
}

function create_resize_icon(parent_element ){
  var resize_node_img = new_element_class("img", "resize_node_img", parent_element );
  set_attributes(resize_node_img, {draggable: "true", src: "images/resize.png", title:"resize node"} );
  //set_class_event(document.getElementsByClassName("resize_node_img"), "dragstart", on_drag_resize_img );
  resize_node_img.addEventListener("mousemove", mousemovenodeaction );
  resize_node_img.addEventListener("mouseout", mouseoutnodeaction );
}

function create_close_icon(parent_element ){
  var close_node_img = new_element_class("img", "close_node_img", parent_element );
  set_attributes(close_node_img, {draggable: "true", src: "images/close.png", title: "close node"} );
  set_class_event(document.getElementsByClassName("close_node_img"), "click", on_click_close_node );
  close_node_img.addEventListener("mousemove", mousemovenodeaction );
  close_node_img.addEventListener("mouseout", mouseoutnodeaction );
}

function create_new_link_icon(parent_element ){
  var new_link_img = new_element_class("img", "new_link_img", parent_element );
  set_attributes(new_link_img, {draggable: "true", src: "images/newlink.png", title:"create new link"} );
    new_link_img.addEventListener("mousemove", mousemovenodeaction );
  new_link_img.addEventListener("mouseout", mouseoutnodeaction );
}

function mousemovenodeaction(event){
  var ele = event.target || event.srcElement;
  var clsname = ele.className;
  switch(clsname){
    case "new_link_img":
      new_link_img_hover_flag = true;
      break;
    case "resize_node_img":
      resize_node_img_hover_flag = true;
      break;
    case "close_node_img":
      close_node_img_hover_flag = true;
      break;
  }
}

function mouseoutnodeaction(event){
  var ele = event.target || event.srcElement;
  var clsname = ele.className;
  switch(clsname){
    case "new_link_img":
      new_link_img_hover_flag = false;
      break;
    case "resize_node_img":
      resize_node_img_hover_flag = false;
      break;
    case "close_node_img":
      close_node_img_hover_flag = false;
      break;
  }

}
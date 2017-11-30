
function on_click_close_node(e){
  if (selected_node ){
    selected_node.remove();
    set_attributes_to_class("close_node_img", {style: "display: none;"});
    set_attributes_to_class("hover-node-modal", {style: "display: none;"});
    set_attributes_to_class("resize_node_img", {style: "display:none"});
    set_attributes_to_class("hover-link-modal", {style:"display:none"});

    hover_node_flag = false;
    hover_node_menu_flag = false;
    hover_newlink_flag = false;
    hover_resize_flag = false;
  }
}

function select_node_info_event(parent_element ){
  set_class_event(parent_element.getElementsByTagName("li"), "click", select_node_info_click );
}

function select_node_info_click(event ){
  var ele = event.target || event.srcElement;
  var clsname = ele.className;

  //set_attributes_to_class(document.getElementsByClassName("hover-graph-modal"), {style: "display: none" } );

  hover_node_flag = false;
  hover_node_menu_flag = false;
  hover_newlink_flag = false;
  hover_resize_flag = false;

  switch(clsname ){
    case "node-font-big":
      var font_size = parseInt(selected_node.data("fontSize")) + 1;
      font_size = font_size > 25 ? 25 : font_size;
      selected_node.data("fontSize", font_size );
      hover_node_menu_flag = true;
      //set_attributes_to_class(document.getElementsByClassName("hover-graph-modal"), {style: "display: block" } );
      break;
    case "node-font-small":
      var font_size = parseInt(selected_node.data("fontSize")) - 1;
      font_size = font_size < 10 ? 10 :font_size;
      selected_node.data("fontSize", font_size );
      hover_node_menu_flag = true;
      //set_attributes_to_class(document.getElementsByClassName("hover-graph-modal"), {style: "display: block" } );
      break;
    case "node-font-under":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      if (selected_node.data("textDecoration") == "underline" ){
        selected_node.data("textDecoration", "normal" );
      }else{
        selected_node.data("fontWeight", "underline" );
      }
      break;
    case "node-font-bold":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      if (selected_node.data("fontWeight") == "bold" ){
        selected_node.data("fontWeight", "normal" );
      }else{
        selected_node.data("fontWeight", "bold" );
      }
      
      break;
    case "node-font-italy":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      if (selected_node.data("fontStyle") == "italic" ){
        selected_node.data("fontStyle", "normal" );
      }else{
        selected_node.data("fontStyle", "italic" );
      }
      
      break;
    case "node-none":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      selected_node.data('borderWidth', '0' );
      selected_node.data("backOpacity", "0" );
      break;
    case "node-fill-none":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      selected_node.data('borderWidth', selected_node.data('tmpBorderWidth' ));
      selected_node.data("faveShape", "ellipse" );
      selected_node.data("backOpacity", "0" );
      break;
    case "node-fill-square":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      var zoom = cy.zoom();
      var ele_pos_x = selected_node.renderedPosition("x" );
      var ele_pos_y = selected_node.renderedPosition("y" );
      var ele_width = selected_node.width() * zoom;
      var ele_height = selected_node.height() * zoom;
      show_new_link_and_resize_img(ele_pos_x, ele_pos_y, ele_width, ele_height, "square" );
      
      selected_node.data('borderWidth', selected_node.data('tmpBorderWidth' ));
      selected_node.data("backOpacity", "1" );
      selected_node.data("faveShape", "square" );
      break;
    case "node-fill-rect":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      var zoom = cy.zoom();
      var ele_pos_x = selected_node.renderedPosition("x" );
      var ele_pos_y = selected_node.renderedPosition("y" );
      var ele_width = selected_node.width() * zoom;
      var ele_height = selected_node.height() * zoom;
      show_new_link_and_resize_img(ele_pos_x, ele_pos_y, ele_width, ele_height, "rectangle" );
      

      selected_node.data('borderWidth', selected_node.data('tmpBorderWidth' ));
      selected_node.data("backOpacity", "1" );
      selected_node.data("faveShape", "rectangle" );
      break;
    case "node-fill-round":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      var zoom = cy.zoom();
      var ele_pos_x = selected_node.renderedPosition("x" );
      var ele_pos_y = selected_node.renderedPosition("y" );
      var ele_width = selected_node.width() * zoom;
      var ele_height = selected_node.height() * zoom;
      show_new_link_and_resize_img(ele_pos_x, ele_pos_y, ele_width, ele_height, "roundrectangle");
      

      selected_node.data('borderWidth', selected_node.data('tmpBorderWidth' ));
      selected_node.data("backOpacity", "1" );
      selected_node.data("faveShape", "roundrectangle" );
      break;
    case "node-fill-circle":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      var zoom = cy.zoom();
      var ele_pos_x = selected_node.renderedPosition("x" );
      var ele_pos_y = selected_node.renderedPosition("y" );
      var ele_width = selected_node.width() * zoom;
      var ele_height = selected_node.height() * zoom;
      show_new_link_and_resize_img(ele_pos_x, ele_pos_y, ele_width, ele_height, "ellipse" );
      

      selected_node.data('borderWidth', selected_node.data('tmpBorderWidth' ));
      selected_node.data("backOpacity", "1" );
      selected_node.data("faveShape", "ellipse" );
      break;
    case "node-line":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      break;
    case "node-dot1":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      break;
    case "node-dot2":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      break;
    case "node-linewid-1":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      selected_node.data('borderWidth', '1' );
      selected_node.data('tmpBorderWidth', '1' );
      break;
    case "node-linewid-2":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      selected_node.data('borderWidth', '2' );
      selected_node.data('tmpBorderWidth', '2' );
      break;
    case "node-linewid-3":
      set_attributes_to_class("hover-node-modal", {style: "display: none" } );

      selected_node.data('borderWidth', '3' );
      selected_node.data('tmpBorderWidth', '3' );
      break;
  }
 //selected_node = "";
}

function hover_subnode_selection_event(parent_element ){
  set_class_event(parent_element.getElementsByTagName("li"), "mousemove", subnode_select_mouse_move );
}

function node_select_mouse_move(event ){
  var ele = event.target || event.srcElement;
  var clsname = ele.className;

  hover_node_menu_flag = true;

  if (clsname == "node-font" ){
  	document.getElementsByClassName("color-modal")[0].style.left = "-37px";
  	document.getElementsByClassName("color-modal")[0].style.top = "72px";
	selected_root_menu = clsname;
  }else if(clsname == "node-fill" ){
    document.getElementsByClassName("color-modal")[0].style.left = "-9px";
  	document.getElementsByClassName("color-modal")[0].style.top = "42px";
  	selected_root_menu = clsname;
  }else if(clsname == "node-outline"){
    document.getElementsByClassName("color-modal")[0].style.left = "22px";
  	document.getElementsByClassName("color-modal")[0].style.top = "42px";
  	selected_root_menu = clsname;
  }

  set_attributes_to_class("hover-horz-selection", {style: "display: none;" } );
  set_attributes_to_class("hover-vert-selection", {style: "display: none;" } );
  set_attributes_to_class("ul-" + clsname, {style: "display: block;" } );

}

function subnode_select_mouse_move(event ){
  var ele = event.target || event.srcElement;
  var clsname = ele.className;

  hover_node_menu_flag = true;
  set_attributes_to_class("hover-horz-selection", {style: "display: none;" } );
  //document.getElementsByClassName("color-modal")[0].style.display="none";

  if (clsname.indexOf("font-color") > -1|| clsname.indexOf("outline-color" ) > -1 || clsname.indexOf("fill-color") > -1 ){
  	document.getElementsByClassName("color-modal")[0].style.display="block";
  }else{
  	set_attributes_to_class("ul-" + clsname, {style: "display: block;" } );
  	document.getElementsByClassName("color-modal")[0].style.display="none";
  }

}

function hover_node_selection_event(parent_element ){
  set_class_event(parent_element.getElementsByTagName("li"), "mousemove", node_select_mouse_move );
}


function modal_div_leave(e){
  //selected_node = "";
  hover_node_menu_flag = false;
  hide_node_menu_delay(HIDE_PLACEHOLD_DELAY_TIME );
}

function hide_node_menu_delay(millisecond ){
  setTimeout(function(){
    if (hover_node_flag == false ){
      document.getElementsByClassName("hover-node-modal")[0].style.display = "none";
    }
    
  }, millisecond);
}

function hover_node(ele ){

  //hover_node_menu_flag = true;
  var zoom = cy.zoom();
  var ele_pos_x = ele.renderedPosition("x" );
  var ele_pos_y = ele.renderedPosition("y" );
  var ele_width = ele.width() * zoom;
  var ele_height = ele.height() * zoom;
  var node_pos_x = (ele_pos_x + ele_width / 2 - 118);
  var node_pos_y = (ele_pos_y + ele_height / 2);

  show_new_link_and_resize_img(ele_pos_x, ele_pos_y, ele_width, ele_height, ele.data("faveShape") );
  //set_attributes_to_class("new_link_img", {style:"display: block;" } );

  set_attributes_to_class("color-modal", {style:"display:none;"} );
  set_attributes_to_class("hover-horz-selection", {style: "display: none;" } );
  set_attributes_to_class("hover-vert-selection", {style: "display: none;" } );
  set_attributes(document.getElementsByClassName("hover-node-modal")[0], {style: "display: block; left: " + node_pos_x + "px; top: " + node_pos_y + "px;"})

  //console.log(selected_node.data("fontColor") );
  document.getElementsByClassName("font-color")[0].style.backgroundColor = selected_node.data("fontColor" );
  document.getElementsByClassName("fill-color")[0].style.backgroundColor = selected_node.data("backColor" );
  document.getElementsByClassName("outline-color")[0].style.backgroundColor = selected_node.data("borderColor" );

}

function show_new_link_and_resize_img(pos_x, pos_y, width, height, shape_type ){

  //console.log(pos_x, pos_y, width, height, shape_type)
  var a = width / 2;
  var b = height / 2;
  var alpha = Math.atan(b/a );
  var x, resize_x, close_x;
  var y, resize_y, close_y;

  switch(shape_type ){
    case "ellipse": 
      x = pos_x - ( a + 16 ) * Math.cos(alpha );
      y = pos_y - ( b + 16 ) * Math.sin(alpha );
      resize_x = pos_x + ( a - 16 ) * Math.cos(alpha );
      resize_y = pos_y + ( b - 16 ) * Math.sin(alpha );
      close_x = pos_x +  ( a - 12 ) * Math.cos(alpha );
      close_y = pos_y - ( b + 12 ) * Math.sin(alpha );
      break;
    case "square": case "rectangle": case "roundrectangle":
      x = pos_x - a - 10;
      y = pos_y - b - 10;
      resize_x = pos_x + a - 12;
      resize_y = pos_y + b - 12;
      close_x = pos_x + a - 12;
      close_y = pos_y - b - 12;
      break;
  
  }
  set_attributes_to_class("new_link_img", {style:"display: block; left: " + x + "px; top: " + y + "px;" } );
  set_attributes_to_class("resize_node_img", {style:"display: block; left: " + resize_x + "px; top: " + resize_y + "px;" } );
  set_attributes_to_class("close_node_img", {style:"display: block; left: " + close_x + "px; top: " + close_y + "px;" } );
}

function clearNode(e ){
  cy.remove("");
}


function select_node(ele){
    if (sel_button == ADD_EDGE ){
      if (document.getElementsByClassName("source-input")[0].value == "" ){
        document.getElementsByClassName("source-input")[0].value = ele.data("name");
        document.getElementsByClassName("source-input")[0].setAttribute("data-id", ele.id() );
      }else if (document.getElementsByClassName("target-input")[0].value == "" ){
        document.getElementsByClassName("target-input")[0].value = ele.data("name");
        document.getElementsByClassName("target-input")[0].setAttribute("data-id", ele.id() );
      }else{
        document.getElementsByClassName("source-input")[0].setAttribute("data-id", "");
        document.getElementsByClassName("target-input")[0].setAttribute("data-id", "" );
        document.getElementsByClassName("source-input")[0].value = "";
        document.getElementsByClassName("target-input")[0].value = "";
      }
    }else if(sel_button == RESIZE_SHAPE ){
      document.getElementsByClassName("node-input")[0].value = ele.data("name");
      document.getElementsByClassName("node-input")[0].setAttribute("data-id", ele.id() );
    }
}


function mousedown_color(event){
	var ele = event.target || event.srcElement;
	var cls_name = ele.className;

	var back_color = ele.style.backgroundColor;
	var root_menu = document.getElementsByClassName("ul-" + selected_root_menu )[0];
	var color_item = root_menu.getElementsByClassName("color-area-li")[0].style.backgroundColor = back_color;

	if (selected_root_menu.indexOf("node-font") > -1 ){
		selected_node.data("fontColor", back_color );
	}else if(selected_root_menu.indexOf("node-fill") > -1 ){
		selected_node.data("backColor", back_color );
	}else if(selected_root_menu.indexOf("node-outline") > -1 ){
		selected_node.data("borderColor", back_color );
	}
}
	
function mousemove_color(event){
  hover_node_menu_flag = true;
	var ele = event.target || event.srcElement;
	var cls_name = ele.className;

	var color_div = document.getElementsByClassName("color-modal")[0];
	var elements = color_div.getElementsByTagName("div");
	for (var i = 0; i < elements.length; i++ ){
		elements[i].style.zIndex = 10;
	}

	ele.style.zIndex = 11;
}

function mouseup_color(e){

}
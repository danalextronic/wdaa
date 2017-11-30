function hover_edge(ev, ele ){
  var zoom = cy.zoom();
  var or_ev = ev.originalEvent;
  var pos_x = or_ev.pageX - 110;
  var pos_y = or_ev.pageY - 60;

  var link_color = document.getElementsByClassName("link-color")[0];
  link_color.getElementsByTagName("img")[0].style.backgroundColor = selected_edge_ele.data("linecolor");
  set_attributes_to_class("link-hover-vert-selection", {style: "display: none"} );
  set_attributes_to_class("hover-link-modal", {style: "display: block; left: " + pos_x + "px; top: " + pos_y + "px;"})

  selected_edge_ele.data("linecolor", selected_edge_ele.data("hovercolor") );
  
}

function mousemove_edge(e){
  selected_edge = true;
}

function mouseleave_edge(e){
  hide_edge_delay(100, "hover-link-modal" );
}

function hide_edge_delay(millisecond, cls_name ){
  setTimeout(function(){

    document.getElementsByClassName(cls_name)[0].style.display = "none";
    var link_color = document.getElementsByClassName("link-color")[0];
    if (selected_edge_ele != NONE ){
      console.log(link_color.getElementsByTagName("img")[0].style.backgroundColor);
      selected_edge_ele.data("linecolor", link_color.getElementsByTagName("img")[0].style.backgroundColor );
      selected_edge_ele.data("hovercolor", "#00f" );
    }
    selected_edge = false;  
    selected_edge_ele = NONE;
  }, millisecond);
}

function select_link_info_click(event ){	
	var ele = event.target || event.srcElement;
  	var clsname = ele.className;

  	if (clsname == "link-color" ){
  		set_attributes_to_class("link-hover-vert-selection", {style:"display: none;"} );
  		set_attributes_to_class("link-color-modal", {style: "display: block;"} );
  	}else{
  		set_attributes_to_class("link-hover-vert-selection", {style:"display: none;"} );
  		set_attributes_to_class("link-color-modal", {style: "display: none;"} );
  		set_attributes_to_class("ul-" + clsname, {style: "display: block;"} );
  	}
}

function change_link_info(event ){
	var ele = event.target || event.srcElement;
  	var clsname = ele.className;

  	switch(clsname){
  		case "link-linedelete":
        set_attributes_to_class("close_node_img", {style: "display: none;"});
        set_attributes_to_class("hover-node-modal", {style: "display: none;"});
        set_attributes_to_class("resize_node_img", {style: "display:none"});
        set_attributes_to_class("hover-link-modal", {style:"display:none"});
  			selected_edge_ele.remove();
  		case "link-linewid-1":
  			selected_edge_ele.data("width", 1 );
  			break;
  		case "link-linewid-2":
  			selected_edge_ele.data("width", 3 );
  			break;
  		case "link-linewid-3":
  			selected_edge_ele.data("width", 5 );
  			break;
  		case "link-line":
  			selected_edge_ele.data("linestyle", "solid" );
  			break;
  		case "link-dot1":
  			selected_edge_ele.data("linestyle", "dotted" );
  			break;
  		case "link-dot2":
  			selected_edge_ele.data("linestyle", "dashed" );
  			break;
  	}
}

function mousedown_edgecolor(event){
	var ele = event.target || event.srcElement;
	var cls_name = ele.className;

	var back_color = ele.style.backgroundColor;
	selected_edge_ele.data("linecolor", back_color );

  var link_color = document.getElementsByClassName("link-color")[0];
  link_color.getElementsByTagName("img")[0].style.backgroundColor = back_color;
}
	
function mousemove_edgecolor(event){
	var ele = event.target || event.srcElement;
	var cls_name = ele.className;

	var color_div = document.getElementsByClassName("link-color-modal")[0];
	var elements = color_div.getElementsByTagName("div");
	for (var i = 0; i < elements.length; i++ ){
		elements[i].style.zIndex = 10;
	}

	ele.style.zIndex = 11;
}
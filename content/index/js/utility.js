function set_class_event(elements, event_name, callback ){
  for(var i = 0; i < elements.length; i++ ){
    elements[i].addEventListener(event_name, function(e){callback(e); } );
  }
}

function set_attributes(element, attributes){
    for(var a in attributes){
        element.setAttribute(a, attributes[a]);
    }
}

function set_attributes_to_elements(elements, attributes ){
    for (var i = 0; i < elements.length; i++ ){
      set_attributes(elements[i], attributes );
    }
}

function set_attributes_to_class(cls_name, attributes ){
	var elements = document.getElementsByClassName(cls_name );
    for (var i = 0; i < elements.length; i++ ){
      set_attributes(elements[i], attributes );
    }
}

function generate_id(prefix ){
  var now_time = new Date().getTime();
  return prefix + now_time;
}

function new_div_class(class_name, parent){
  var div = document.createElement('div');
  div.classList.add(class_name);
  parent.appendChild(div);
  return div;
}

function new_input_class(type, class_name, parent ){
	var ele = document.createElement("input");
	ele.classList.add(class_name );
	ele.type = type;
	parent.appendChild(ele );
	return ele;
}

function new_element_class(ele_name, class_name, parent){
  var ele = document.createElement(ele_name);
  ele.classList.add(class_name);
  parent.appendChild(ele );
  return ele;
}

function hide_placehold_delay(millisecond, cls_name ){
  setTimeout(function(){
    document.getElementsByClassName(cls_name)[0].style.display = "none";
  }, millisecond);
}

function get_position_from_angle(c_x, c_y, r, angle ){
	var ret = new Object();
	ret.x = c_x + r * Math.sin(angle );
	ret.y = c_y + r * Math.cos(angle );
	return ret;
}

function get_color_i(i, range ){
	var step = 256 / range;
	var color_r = parseInt((i % range) * step );
	var color_g = parseInt((((i - (i % range) ) / range ) % range) * step );
	var color_b = parseInt((((i - (i % range)) / (range * range))) % range * step );

	return "rgb(" + color_r + "," + color_g + "," + color_b + ")";
}
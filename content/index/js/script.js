var ADD_NODE = "add-node";
var ADD_EDGE = "add-edge";
var CHANGE_SHAPE = "change-shape";
var RESIZE_SHAPE = "resize-shape";
var HOVER_NODE = "hover-node";
var NONE = "";
var HIDE_PLACEHOLD_DELAY_TIME = 350;
var DOWN_NEW_LINK = "down_new_link";
var NEWLINE_IMG = "newlinkimg";
var RESIZENODE_IMG = "resizenodeimg";

var cy;
var sel_button = NONE;
var selected_node;
var selected_item = NONE;
var selected_edge = NONE;
var selected_root_menu = NONE;
var editable_node = NONE;
var editing_flag = false;

var hover_node_flag = false;
var hover_node_menu_flag = false;
var hover_newlink_flag = false;
var hover_resize_flag = false;
var hover_node_text_modal = false;

var start_node, end_node;
var selected_edge = false;
var selected_edge_ele = NONE;
var add_node_flag = false;

var draw_line_flag = false;
var draw_line_canvas, draw_line_context;
var draw_line_pos_x, draw_line_pos_y;

var resize_node_img_hover_flag = false;
var new_link_img_hover_flag = false;
var close_node_img_hover_flag = false;

var touch_start = false;
window.addEventListener("load", init_window );

var resize_node_start_x, resize_node_start_y;

var tmp_node = [
      { data: { id: 'j', name: 'Jesadf\nsdfasdfdsf\nfdsafdfry',  weight: 75, height: 55, fontSize: 14, fontColor:"#000", borderColor: "#000", borderWidth: 1, tmpBorderWidth: 1, backColor: "#aaa", faveShape: "ellipse" } },
      { data: { id: 'e', name: 'Elaine', weight: 75, height: 55, fontSize: 14, fontColor:"#000", borderColor: "#000", borderWidth: 1, tmpBorderWidth: 1, backColor: "#aaa", faveShape: "ellipse" } },
      { data: { id: 'k', name: 'Kramer', weight: 75, height: 55, fontSize: 14, fontColor:"#000", borderColor: "#000", borderWidth: 1, tmpBorderWidth: 1, backColor: "#aaa", faveShape: "ellipse" } },
      { data: { id: 'g', name: 'George', weight: 75, height: 55, fontSize: 14, fontColor:"#000", borderColor: "#000", borderWidth: 1, tmpBorderWidth: 1, backColor: "#aaa", faveShape: "ellipse" } }
    ];

var tmp_edge = [
      { data: { source: 'j', target: 'e', width: 3, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },
      { data: { source: 'j', target: 'k', width: 2, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },
      { data: { source: 'j', target: 'g', width: 3, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },

      { data: { source: 'e', target: 'j', width: 1, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },
      { data: { source: 'e', target: 'k', width: 3, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },

      { data: { source: 'k', target: 'j', width: 1, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },
      { data: { source: 'k', target: 'e', width: 3, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },
      { data: { source: 'k', target: 'g', width: 2, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } },

      { data: { source: 'g', target: 'j', width: 3, linestyle:"solid", linecolor:"#aaa", hovercolor:"#00f" } }
    ];

function init_cytoscape(parent_element){
  cy = cytoscape( options = {
  container: parent_element,
  grabbable: false,
  selectable: false,
  selected: false,
  minZoom: 1.0,
  maxZoom: 1,
  zoomingEnabled: false,
  userZoomingEnabled: false,
  pan: { x: 0, y: 0 },
  // style can be specified as plain JSON, a stylesheet string (probably a CSS-like
  // file pulled from the server), or in a functional format
  style: [
    {
      selector: 'node',
      css: {
        'shape': 'data(faveShape)',
        'content': 'data(name)',
        'font-family': 'helvetica',
        'font-size': 'data(fontSize)',
        'font-style': 'data(fontStyle )',
        'font-weight': 'data(fontWeight)',
        'text-decoration': 'data(textDecoration)',
        //'text-outline-width': 2,
        //'text-outline-color': '#000',
        'text-valign': 'center',
        'color': 'data(fontColor)',
        'width': 'data(weight)',
        'height': 'data(height )',
        'border-color': 'data(borderColor )',
        'border-width': 'data(borderWidth)',
        'border-style': 'none',
        'background-color': 'data(backColor )',
        'background-opacity': 'data(backOpacity)'
      }
    },

    {
      selector: ':selected',
      css: {
        'background-color': '#000',
        'line-color': '#000',
        'target-arrow-color': '#000',
        'text-outline-color': '#000',
        'color': "#fff"
      }
    },

    {
      selector: 'edge',
      css: {
        'line-color': 'data(linecolor)',
        'source-arrow-color': 'data(linecolor)',
        'target-arrow-color': 'data(linecolor)',
        'width': 'data(width)',
        'line-style': 'data(linestyle)',
        'target-arrow-shape': 'triangle'
      }
    }
  ],

  // specify the elements in the graph
  elements: {
    nodes: tmp_node,
    edges: tmp_edge,
  },
  ready: function(){
    // when layout has set initial node positions etc
  }
  } );  
cy.zoom({
  level: 1.0, // the zoom level
  position: { x: 0, y: 0 }
});
  
  create_new_canvas_for_drawing();
  cy_events();
}

function create_new_canvas_for_drawing(){
  return;
  draw_line_canvas = document.createElement('canvas');
  set_attributes(draw_line_canvas, {id:"drawline", style:"width: 100%; height: 100%; z-index:6; position: absolute;"});
  var cy_ele = document.getElementById("cy");
  var div_ele = cy_ele.getElementsByTagName("div")[0];
  document.body.appendChild(draw_line_canvas );

  draw_line_context = draw_line_canvas.getContext('2d');
  draw_line_context.scale(1,1);
}

function cy_events(){
cy.$('node').on("change", function(e){
  console.log("change");
});

cy.$('node').on('tap', function(e){
  var ele = e.cyTarget;
  select_node(ele );
});

cy.$("node").on("mousedown", function(e ){
  touch_start = true;
});
cy.$("node").on("mousemove", function(e ){
  if (sel_button == NONE ){
    if (hover_node_menu_flag == false &&  hover_resize_flag == false && hover_newlink_flag == false && selected_edge_ele == NONE ){
      hover_node_flag = true;
      var ele = e.cyTarget;
      selected_node = ele;
      editable_node = ele;
      sel_button = HOVER_NODE;
      hover_node(ele );

      if (selected_item == NONE ){
        start_node = ele;
        resize_node_start_x = e.pageX;
        resize_node_start_y = e.pageY;
      }
    }
  }
});

cy.$("node").on("mouseout", function(e){
  hover_node_flag = false;
  hide_node_menu_container(HIDE_PLACEHOLD_DELAY_TIME );
  if (editing_flag == false ){
    editable_node = NONE;
  }
});

  cy.$("edge").on("mousemove", function(e ){
    if (selected_edge == false ){
      //console.log(hover_node_flag, hover_node_menu_flag, hover_resize_flag, hover_newlink_flag );
      if (hover_node_flag == false && hover_node_menu_flag == false && hover_resize_flag == false && hover_newlink_flag == false ){
        var ele = e.cyTarget;
        selected_edge_ele = ele;
        hover_edge(e, ele );
        //selected_edge = ele;
        //sel_button = HOVER_NODE;
        //hover_node(ele );
      }
    }
  });


  cy.$("node").on("mouseup", function(e ){
    touch_start = false;
    end_node = e.cyTarget;
  });

  cy.$("node").on("dblclick", function(e ){
    document.body.innerHTML = "";
  });

  cy.$("node").bind("mouseout", function(e ){
    if (sel_button == HOVER_NODE ){
        sel_button = NONE;
        //set_attributes_to_class(document.getElementsByClassName("hover-graph-modal"), {style: "display: none" } );
    }
  });
}

function hide_node_menu_container(millisecond ){
  setTimeout(function(){
    if (hover_node_flag == false && hover_node_menu_flag == false && hover_newlink_flag == false && hover_resize_flag == false ){
      hover_node_flag = false;
      document.getElementsByClassName("hover-node-modal")[0].style.display = "none";
      if (resize_node_img_hover_flag == false && new_link_img_hover_flag == false && close_node_img_hover_flag == false){
        document.getElementsByClassName("resize_node_img")[0].style.display = "none";
        document.getElementsByClassName("new_link_img")[0].style.display = "none";
        document.getElementsByClassName("close_node_img")[0].style.display = "none";
      }
    }
  }, millisecond);
}

function init_window(){
  init_cytoscape(document.getElementById("cy") );
  //document.getElementById("add-node").addEventListener("click", addNode );
  //document.getElementById("add-edge").addEventListener("click", addEdge );
  document.getElementById("clear-node").addEventListener("click", clearNode );
  //document.getElementById("resize-shape").addEventListener("click", addResizeShapeModal );
  document.getElementById("add-new-node").addEventListener("click", addNewNode );
  //document.getElementById("change-shape").addEventListener("click", changeShape );

  create_nodetext_modal(document.body ); 
  create_node_hover_modal("", document.getElementById("cy") );
  create_new_link_icon(document.getElementById("cy") );
  create_resize_icon(document.getElementById("cy") );
  create_close_icon(document.getElementById("cy") );
  create_link_hover_modal("", document.getElementById("cy") );

  window.addEventListener("mousedown", window_mouse_down );
  window.addEventListener("mousemove", window_mouse_move );
  window.addEventListener("mouseup", window_mouse_up );
  window.addEventListener("dblclick", window_dblclick );
}

function addNewNode(e){
  add_node_flag = document.getElementById("add-new-node").checked;
}

function create_nodetext_modal(parent_element ){
  var modal_back = new_element_class("div", "nodetext-modal", parent_element );
  var text_edit = new_input_class("text", "nodetext-obj", modal_back );
  var text_done = new_input_class("button", "nodetext-done", modal_back );
  text_done.setAttribute("value", "Ok");
  var text_cancel = new_input_class("button", "nodetext-cancel", modal_back );
  text_cancel.setAttribute("value", "Cancel" );

  modal_back.addEventListener("keydown", set_keyevent_textedit );
  text_done.addEventListener("click", change_node_text );
  text_cancel.addEventListener("click", change_node_text_cancel );

  hover_node_text_modal = true;
}

function set_keyevent_textedit(e){
    if (e.keyCode == 27 ){
      change_node_text_cancel();
    }else if(e.keyCode == 13 ){
      change_node_text();
    }
}

function change_node_text(){
  var change_text = document.getElementsByClassName("nodetext-obj")[0].value;
  if (change_text == "" ){
    alert("please input the text" );
    return;
  }
  editing_flag = false;
  editable_node.data("name", change_text );
  document.getElementsByClassName("nodetext-modal")[0].style.display = "none";
  hover_node_text_modal = false;
}

function change_node_text_cancel(){
  document.getElementsByClassName("nodetext-modal")[0].style.display = "none";
  editing_flag = false;
  hover_node_text_modal = false;
}

function window_dblclick(e){
  if (editable_node != NONE && editing_flag == false ){
    var pos = editable_node.position();
    var node_text_modal = document.getElementsByClassName("nodetext-modal")[0];
    //set_attributes(node_text_modal, {style:"display:block; left:" + e.pageX + "px; top:" + e.pageY + "px;"});
    set_attributes_to_class("nodetext-modal", {style:"display:block; left:" + e.pageX + "px; top:" + e.pageY + "px;"} );
    node_text_modal.getElementsByClassName("nodetext-obj")[0].value = editable_node.data("name");
    editing_flag = true;
  }
}

function window_mouse_down(e ){
  var ele = e.srcElement || e.target;
  var cls_name = ele.className;

  if (add_node_flag ){
    var pos_x = 400;//e.pageX;
    var pos_y = 200;//e.pageY;

    cy.add({
        group: "nodes",
        data: { id: generate_id("node"), name:"New Node", weight: 75, height: 55, 
                fontSize:14, fontColor:"#000", borderColor:"#000", borderWidth:1, tmpBorderWidth:1,
                backColor:"#aaa", faveShape:"roundrectangle" },
        position: { x: pos_x, y: pos_y }
    });
    add_node_flag = false;
    document.getElementById("add-new-node").checked = false;
    cy_events();

    return;
  }
  if (cls_name == "new_link_img" ){
    selected_item = NEWLINE_IMG;
    //e.stopPropagation();
    cy.boxSelectionEnabled( false );
    cy.panningEnabled( false );
    //cy.userPanningEnabled(false );
    //cy.$("node").unselectify();
    hover_newlink_flag = true;
    draw_line_pos_x = start_node.renderedPosition("x");
    draw_line_pos_y = start_node.renderedPosition("y");
    draw_line_flag = true;
  }else if(cls_name == "resize_node_img"){
    selected_item = RESIZENODE_IMG;
    cy.boxSelectionEnabled(false );
    cy.panningEnabled(false );  
    hover_resize_flag = true;
  }
  else{
    selected_item = NONE;
    hover_newlink_flag = false;
    hover_resize_flag = false;
  }
}

function window_mouse_move(e ){
  var end_pos_x = e.pageX;
  var end_pos_y = e.pageY - 52;

  if (selected_item == NEWLINE_IMG ){
    //console.log(e.x, e.y, e.pageX, e.pageY, e.layerX, e.layerY, e.clientX, e.clientY, e.screenX, e.screenY );
    set_attributes_to_class("new_link_img", {style:"display: block; left: " + end_pos_x + "px; top: " + end_pos_y + "px;"});
    
   /* draw_line_context.clearRect(0, 0, draw_line_canvas.width, draw_line_canvas.height);

    draw_line_context.beginPath();
    draw_line_context.moveTo(10, 10);
    draw_line_context.lineTo(end_pos_x, end_pos_y);
    draw_line_context.lineWidth = 1;
    draw_line_context.stroke();
    draw_line_context.closePath();
    console.log(draw_line_pos_x, draw_line_pos_y, end_pos_x, end_pos_y );*/

  }else if(selected_item == RESIZENODE_IMG ){
    set_attributes_to_class("new_link_img", {style:"display: none;"});
    set_attributes_to_class("close_node_img", {style:"display: none;"});

    set_attributes_to_class("resize_node_img", {style:"display: none; left: " + end_pos_x + "px; top: " + end_pos_y + "px;"});
    var start_pos_x = start_node.renderedPosition("x" );
    var start_pos_y = start_node.renderedPosition("y" );
    
    var width = end_pos_x - start_pos_x + 30;
    var height = end_pos_y - start_pos_y + 30;
    if (width < 30 ){
      width = 30;
      end_pos_x = start_pos_x + width;
    }

    if (height < 30 ){
      height = 30;
      end_pos_y = start_pos_x + height;
    }
    //if (width > 30 && height > 30 ){
      
      start_node.data("weight", width );
      start_node.data("height", height );
    //}
  }else{
    if (touch_start == true ){
      console.log(start_node.position("x"), start_node.position("y"), "-", end_pos_x, end_pos_y  );
      set_attributes_to_class("new_link_img", {style:"display: none;"});
      set_attributes_to_class("resize_node_img", {style:"display: none;"});
      set_attributes_to_class("close_node_img", {style:"display: none;"});
      set_attributes_to_class("nodetext-modal", {style:"display:none;"})
      document.getElementsByClassName("hover-node-modal")[0].style.display = "none";
      editing_flag = false;
      hover_node_text_modal = false;
      //hover_node_menu_flag = false;
      //hover_newlink_flag = false;
      //hover_resize_flag = false;      
    }
  }
} 

function window_mouse_up(e ){
  draw_line_flag = false;
  var ele = e.srcElement || e.target;
  if (selected_item == NEWLINE_IMG ){
    selected_item = NONE;
    document.getElementsByClassName("new_link_img")[0].style.display = "none";
    //e.stopPropagation();
    cy.boxSelectionEnabled( true );
    cy.panningEnabled( true );
    //cy.userPanningEnabled(false );
    //cy.$("node").unselectify();

    if (end_node){
      if (start_node.id() != end_node.id() ){
        cy.add([
          { group: "edges", data: { id: generate_id("edge"), source: start_node.id(), target: end_node.id() } }]);
      }
         
    }
    cy_events();
    end_node = NONE;
    hover_newlink_flag = false;

  }else if(selected_item == RESIZENODE_IMG ){
    selected_item = NONE;
    document.getElementsByClassName("resize_node_img")[0].style.display = "none";
    document.getElementsByClassName("new_link_img")[0].style.display = "none";
    //e.stopPropagation();
    cy.boxSelectionEnabled( true );
    cy.panningEnabled( true );
    //cy.userPanningEnabled(false );
    //cy.$("node").unselectify();
    end_node = NONE;
    hover_resize_flag = false;
  } 
}


function addEdge(e ){
  //sel_button = ADD_EDGE;
  //e.target.setAttribute("disabled", "disabled" );
  //var modal_back = addEdgeModal();
}

function addEdgeModal(e ){
  var modal_back = new_div_class("edge-modal-back", document.body );
  var form_div = new_div_class("form-modal-div", modal_back );  

  var source_cotent_area = new_div_class("modal-content-area", form_div );
  var source_label_span = new_div_class("form-label-span", source_cotent_area )
  source_label_span.innerHTML = "Source : "; 
  var source_input = new_element_class("input", "source-input", source_cotent_area );
  source_input.setAttribute("disabled", "disabled" );

  var target_cotent_area = new_div_class("modal-content-area", form_div );
  var target_label_span = new_div_class("form-label-span", target_cotent_area )
  target_label_span.innerHTML = "Target : "; 
  var target_input = new_element_class("input", "target-input", target_cotent_area );
  target_input.setAttribute("disabled", "disabled" );  

  var done_content_area = new_div_class("modal-content-area", form_div );
  var done_btn = new_div_class("done-btn", done_content_area );
  done_btn.innerHTML = "done";

  var cancel_btn = new_div_class("cancel-btn", done_content_area );
  cancel_btn.innerHTML = "cancel";

  cancel_btn.addEventListener("click", cancel_click );
  cancel_btn.button_id = "add-edge";

  done_btn.addEventListener("click", add_edge_done );
  done_btn.button_id = "add-edge";

  return modal_back;
}

function add_edge_done(e ){
  var source_id = document.getElementsByClassName("source-input")[0].getAttribute("data-id" );
  var target_id = document.getElementsByClassName("target-input")[0].getAttribute("data-id" );

  if (!source_id || !target_id || source_id == "" || target_id == "" ){
    alert("select source and target node, please" );
    return;
  }

  
  cy.add([
    { group: "edges", data: { id: generate_id("edge"), source: source_id, target: target_id } }
  ]);

  document.getElementById(sel_button ).removeAttribute("disabled" );
  e.target.parentNode.parentNode.parentNode.remove();
  sel_button = NONE;
}

function get_nodes_list(){
  var nodes = cy.nodes();
  var ret_arr = new Array();

  for (var ind = 0; ind < nodes.length; ind++ ){
    var obj = new Object();
    obj.id = nodes[ind].data("id");
    obj.name = nodes[ind].data("name");
    ret_arr.push(obj );
  }

  return ret_arr;
}

function resize_shape(e){
  addResizeShapeModal();
}

function addResizeShapeModal(e){
  sel_button = RESIZE_SHAPE;
  e.target.setAttribute("disabled", "disabled" );

  var modal_back = new_div_class("resize-modal-back", document.body );
  var form_div = new_div_class("form-modal-div", modal_back );

  var node_content_area = new_div_class("modal-content-area", form_div );
  var node_content_span = new_div_class("form-label-span", node_content_area );
  node_content_span.innerHTML = "Node : ";
  var node_content_input = new_element_class("input", "node-input", node_content_area );

  var node_width_area = new_div_class("modal-content-area", form_div );
  var node_width_span = new_div_class("form-label-span", node_width_area );
  node_width_span.innerHTML = "Width : ";
  var node_width_input = new_element_class("input", "node-width", node_width_area );

  var node_height_area = new_div_class("modal-content-area", form_div );
  var node_height_span = new_div_class("form-label-span", node_height_area );
  node_height_span.innerHTML = "Node : ";
  var node_height_input = new_element_class("input", "node-height", node_height_area );

  var done_content_area = new_div_class("modal-content-area", form_div );
  var done_btn = new_div_class("done-btn", done_content_area );
  done_btn.innerHTML = "done";
  var cancel_btn = new_div_class("cancel-btn", done_content_area );
  cancel_btn.innerHTML = "cancel";

  cancel_btn.addEventListener("click", cancel_click );
  cancel_btn.button_id = "resize-shape";

  done_btn.addEventListener("click", done_resize_node );
  done_btn.button_id = "resize-shape";
}

function done_resize_node(e ){
  var node_id = document.getElementsByClassName("node-input")[0].getAttribute("data-id" );

  if (!node_id || node_id == "" ){
    alert("select node, please" );
    return;
  }

  var width = parseInt(document.getElementsByClassName("node-width")[0].value);
  var height = parseInt(document.getElementsByClassName("node-height")[0].value);

  if (!width || !height || width == "" || height =="" || width < 1 ||  height < 1  ){
    alert("input all of the values (not 0 or string)" );
    return;
  }

  cy.getElementById(node_id).data("weight", width );
  cy.getElementById(node_id).data("height", height );

  document.getElementById(sel_button ).removeAttribute("disabled" );
  e.target.parentNode.parentNode.parentNode.remove();
  sel_button = NONE;
}

function addNode(e){
  sel_button = ADD_NODE;
  e.target.setAttribute("disabled", "disabled" );
  var modal_back = addNodeModal();
}

function addNodeModal(){
  sel_button = ADD_NODE;
  var modal_back = new_div_class("node-modal-back", document.body );
  var form_div = new_div_class("form-modal-div", modal_back );

  var name_cotent_area = new_div_class("modal-content-area", form_div );
  var name_label_span = new_div_class("form-label-span", name_cotent_area )
  name_label_span.innerHTML = "Name : "; 
  var name_input = new_element_class("input", "name-input", name_cotent_area );

  /*var weight_cotent_area = new_div_class("modal-content-area", form_div );
  var weight_label_span = new_div_class("form-label-span", weight_cotent_area )
  weight_label_span.innerHTML = "Weight : "; 
  var weight_input = new_element_class("input", "weight-input", weight_cotent_area );
  */
  var width_cotent_area = new_div_class("modal-content-area", form_div );
  var width_label_span = new_div_class("form-label-span", width_cotent_area )
  width_label_span.innerHTML = "Width : "; 
  var width_input = new_element_class("input", "width-input", width_cotent_area );

  var height_cotent_area = new_div_class("modal-content-area", form_div );
  var height_label_span = new_div_class("form-label-span", height_cotent_area )
  height_label_span.innerHTML = "Height : "; 
  var height_input = new_element_class("input", "height-input", height_cotent_area );

  var posx_cotent_area = new_div_class("modal-content-area", form_div );
  var posx_label_span = new_div_class("form-label-span", posx_cotent_area )
  posx_label_span.innerHTML = "Pos X : "; 
  var posx_input = new_element_class("input", "posx-input", posx_cotent_area ); 

  var posy_cotent_area = new_div_class("modal-content-area", form_div );
  var posy_label_span = new_div_class("form-label-span", posy_cotent_area )
  posy_label_span.innerHTML = "Pos Y : "; 
  var posy_input = new_element_class("input", "posy-input", posy_cotent_area ); 

  var done_content_area = new_div_class("modal-content-area", form_div );
  var done_btn = new_div_class("done-btn", done_content_area );
  done_btn.innerHTML = "done";

  var cancel_btn = new_div_class("cancel-btn", done_content_area );
  cancel_btn.innerHTML = "cancel";

  cancel_btn.addEventListener("click", cancel_click );
  cancel_btn.button_id = "add-node";

  done_btn.addEventListener("click", click_done );
  done_btn.button_id = "add-node";

  /*done_btn.weight = document.getElementsByClassName('weight-input')[0].value;
  done_btn.posx = document.getElementsByClassName('posx-input')[0].value;
  done_btn.posy = document.getElementsByClassName('posy-input')[0].value;*/
  return modal_back;
}

function cancel_click(e ){
  document.getElementById(sel_button ).removeAttribute("disabled" );
  e.target.parentNode.parentNode.parentNode.remove();
  sel_button = NONE;
}

function click_done(e ){

  var width = parseInt(document.getElementsByClassName('width-input')[0].value );
  var height = parseInt(document.getElementsByClassName('height-input')[0].value );
  var posx = parseInt(document.getElementsByClassName('posx-input')[0].value );
  var posy = parseInt(document.getElementsByClassName('posy-input')[0].value );
  var name = document.getElementsByClassName("name-input")[0].value;

  if (!width || !height || !posx || !posy || !name || name == "" || width == "" || height =="" || posx == "" || posy == ""  || width < 1 ||  height < 1 || posx < 1 || posy < 1 ){
    alert("input all of the values (not 0 or string)" );
    return;
  }
 
  cy.add({
      group: "nodes",
      data: { id: generate_id("node"), name: name, weight: width, width: width, height: height },
      position: { x: posx + 150, y: posy + 50 }
  });

  cy.$('node').off('tap'); 
  cy.$('node').on('tap', function(e){
    var ele = e.cyTarget;
    select_node(ele );
  });

  cy.$("node").off("mousemove");
  cy.$("node").off("mouseout");

  cy.$("node").on("mousemove", function(e ){
    if (sel_button == NONE ){
      var ele = e.cyTarget;
      selected_node = ele;
      sel_button = HOVER_NODE;
      hover_node(ele );
    }
    
  });
  cy.$("node").bind("mouseout", function(e ){
    if (sel_button == HOVER_NODE ){
        sel_button = NONE;
        //set_attributes_to_class(document.getElementsByClassName("hover-graph-modal"), {style: "display: none" } );
    }
  });

  document.getElementById(sel_button ).removeAttribute("disabled" );
  e.target.parentNode.parentNode.parentNode.remove();
  sel_button = NONE;
}

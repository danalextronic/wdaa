
function create_link_hover_modal(ele, parent_element ){
  var modal_back = new_div_class("hover-link-modal", parent_element );
  modal_back.setAttribute("class","hover-link-modal link-hover-graph-modal");

  hover_link_selection(ele, modal_back );

  document.getElementsByClassName("hover-link-modal")[0].addEventListener("mousemove", mousemove_edge );
  document.getElementsByClassName("hover-link-modal")[0].addEventListener("mouseleave", mouseleave_edge );
}

function hover_link_selection(element, parent_element ) {
  var ul_link_selection = new_element_class("ul", "link-selection", parent_element );

  var li_link_color = new_element_class("li", "link-color", ul_link_selection );
  set_attributes(li_link_color, {style: "left: 0px" });
  var li_link_color_img = new_element_class("img", "link-color", li_link_color );
  set_attributes(li_link_color_img, {src: "images/font-color.png", style: "width: 24px;" });

  var li_link_linewidth = new_element_class("li", "link-linewidth", ul_link_selection );
  set_attributes(li_link_linewidth, {style: "left: 29px" });
  var li_link_linewidth_img = new_element_class("img", "link-linewidth", li_link_linewidth );
  set_attributes(li_link_linewidth_img, {src: "images/linewid.png", style: "width: 24px;" });

  var li_link_linestyle = new_element_class("li", "link-linestyle", ul_link_selection );
  set_attributes(li_link_linestyle, {style: "left: 58px" });
  var li_link_linestyle_img = new_element_class("img", "link-linestyle", li_link_linestyle );
  set_attributes(li_link_linestyle_img, {src: "images/outline.png", style: "width: 24px;" });

  var li_link_delete = new_element_class("li", "link-linedelete", ul_link_selection );
  set_attributes(li_link_delete, {style: "left: 87px" });
  var li_link_delete_img = new_element_class("img", "link-linedelete", li_link_delete );
  set_attributes(li_link_delete_img, {src: "images/close.png", style: "width: 24px;" });

  hover_link_color(element, parent_element );
  hover_link_linewidth(element, parent_element );
  hover_link_linestyle(element, parent_element );
 
  set_class_event(ul_link_selection.getElementsByTagName("li"), "mousemove", select_link_info_click );
  set_class_event(ul_link_selection.getElementsByTagName("li"), "click",     change_link_info );
}

function hover_link_linestyle(element, parent_element ){
  var ul_linkline_type = new_element_class("ul", "ul-link-linestyle", parent_element );
  ul_linkline_type.setAttribute("class", "ul-link-linestyle link-hover-vert-selection" );

  var li_link_line = new_element_class("li", "link-line", ul_linkline_type );
  set_attributes(li_link_line, {style: ""} );
  var li_link_line_img = new_element_class("img", "link-line", li_link_line );
  set_attributes(li_link_line_img, {src: "images/outline1.png", style:"width: 24px;"} );

  var li_link_dot1 = new_element_class("li", "link-dot1", ul_linkline_type );
  set_attributes(li_link_dot1, {style: ""} );
  var li_link_dot1_img = new_element_class("img", "link-dot1", li_link_dot1 );
  set_attributes(li_link_dot1_img, {src: "images/outline2.png", style:"width: 24px;"} );

  var li_link_dot2 = new_element_class("li", "link-dot2", ul_linkline_type );
  set_attributes(li_link_dot2, {style: ""} );
  var li_link_dot2_img = new_element_class("img", "link-dot2", li_link_dot2 );
  set_attributes(li_link_dot2_img, {src: "images/outline2.png", style:"width: 24px;"} );

  set_class_event(ul_linkline_type.getElementsByTagName("li"), "click",     change_link_info );
}

function hover_link_linewidth(element, parent_element ){
  var ul_link_linewidth = new_element_class("ul", "ul-link-linewidth", parent_element );
  ul_link_linewidth.setAttribute("class", "ul-link-linewidth link-hover-vert-selection");

  var li_linewid_1 = new_element_class("li", "link-linewid-1", ul_link_linewidth );
  set_attributes(li_linewid_1, {style: ""} );
  var li_linewid_1_img = new_element_class("img", "link-linewid-1", li_linewid_1 );
  set_attributes(li_linewid_1_img, {src: "images/linewid1.png", style:"width: 24px;"} );

  var li_linewid_2 = new_element_class("li", "link-linewid-2", ul_link_linewidth );
  set_attributes(li_linewid_2, {style: ""} );
  var li_linewid_2_img = new_element_class("img", "link-linewid-2", li_linewid_2 );
  set_attributes(li_linewid_2_img, {src: "images/linewid2.png", style:"width: 24px;"} );

  var li_linewid_3 = new_element_class("li", "link-linewid-3", ul_link_linewidth );
  set_attributes(li_linewid_3, {style: ""} );
  var li_linewid_3_img = new_element_class("img", "link-linewid-3", li_linewid_3 );
  set_attributes(li_linewid_3_img, {src: "images/linewid3.png", style:"width: 24px;"} );

  set_class_event(ul_link_linewidth.getElementsByTagName("li"), "click",     change_link_info );
}

function hover_link_color(element, parent_element ){
  var color_div = new_div_class("link-color-modal", parent_element );
  set_color_div(color_div );

  set_class_event(color_div.getElementsByTagName("div"), "mousedown", mousedown_edgecolor );
  set_class_event(color_div.getElementsByTagName("div"), "mousemove", mousemove_edgecolor );
  //set_class_event(color_div.getElementsByTagName("div"), "mouseup", mouseup_edgecolor );
}

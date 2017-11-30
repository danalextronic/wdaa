var Status = {

	getStatus: function(type ){
		$.post("/statusajax/" + type, function(data){
			$("table.datatable tbody").html("");
			
			console.log(data );
			var students = data.students;
			
			
			
			for (var i = 0; i < students.length; i++){
				var s = students[i];
				
				var tr = $("<tr>")
					.appendTo("table.datatable tbody");
				
				var td = $("<td>")
					.appendTo(tr);
				if (data.cur_status == "inprogress"){
					var a_user_link = $("<a>")
						.prop("href", "/users/" + s.username)
						.text(s.display_name )
						.appendTo(td );	
				}else{
					var a_link = $("<a>")
						.prop("href", "/verify/view/" + s.ordersid )
						.text(s.display_name )
						.appendTo(td );
				}
				
				td = $("<td>")
					.appendTo(tr);
				
				var a_email = $("<a>")
					.prop("href", "mailto:" + s.email)
					.text(s.email )
					.appendTo(td );

				td = $("<td>")
					.appendTo(tr);
				
				var a_package = $("<a>")
					.prop("href", "/admin/packages/" + s.package_id )
					.text(s.package_name )
					.appendTo(td);
					
				 td = $("<td>")
				 	.appendTo(tr );
				 
				 var a_result;
				 if (data.completed == 1 || data.completed == '1' || s.vrycompleted == 1 || s.vrycompleted == '1' ){
				 	var text = $("<span>")
				 		.text(s.status )
				 		.appendTo(td );
				 }else if(data.cur_status == 'satisfactory' || data.cur_status == 'unsatisfactory' ){
				 	var input = $("<input type='button'>")
				 		.addClass("btn btn-success verifycompleted")
				 		.attr("data-order-id", s.ordersid )
				 		.attr("data-verification-id", s.scorecard_verify_id )
				 		.val("Completed" )
				 		.click(function(ev){
				 			clickCompleted(ev);
				 			
				 		})
				 		.appendTo(td );
				 }else{
				 	var div = $("<div>")
				 		.addClass("progress")
				 		.appendTo(td );
				 	var sub_div = $("<div>")
				 		.addClass("progress-bar" )
				 		.css("width", s.percentage + "%" )
				 		.appendTo(div );
				 	
				 	var p = $("<p>")
				 		.addClass("lead")
				 		.text(s.complete + " of " + s.total + " tests completed" )
				 		.appendTo(td );
				} 		
			}
			
			$(".student-status li").removeClass("active");
			$(".student-status li." + type + "-st").addClass("active" );
						
			hideLoadingIcon();
		});
			
	}
};

function clickCompleted(evt ){
	evt.preventDefault();
	$(evt.target).prop("disabled", "disabled");
	$(evt.target).val("Completing...");
	showLoadingIcon();
	$.post("/verify/" +  $(evt.target).data("verification-id") + "/completed", {order_id: $(evt.target).data("order-id")}, function(data){
		return Status.getStatus("completed");	
	});
	
}

$(document).ready(function() {

	$(".inprogress-st").on('click', function(e) {
		e.preventDefault();
		showLoadingIcon();	
		return Status.getStatus("inprogress");
	});

	$(".pending-st").on('click', function(e) {
		e.preventDefault();
		showLoadingIcon();
		return Status.getStatus("pending");
	});

	$(".satisfactory-st").on('click', function(e) {
		e.preventDefault();
		showLoadingIcon();
		return Status.getStatus("satisfactory");
	});

	$(".unsatisfactory-st").on('click', function(e) {
		e.preventDefault();
		showLoadingIcon();
		return Status.getStatus("unsatisfactory");
	});

	$(".completed-st").on('click', function(e) {
		e.preventDefault();
		showLoadingIcon();
		return Status.getStatus("completed");
	});
});

function showLoadingIcon(){
	var back = $("<div>")
		.addClass("tmp-loading-back")
		.css("position", "fixed" )
		.css("left", "0px" )
		.css("top", "0px" )
		.css("width", "100%" )
		.css("height", "100%" )
		.css("background", "rgba(0,0,0,0.8)" )
		.appendTo("body");
	var load_icon = $("<img>")
		.prop("src", "/assets/images/ajax_loader_gray_64.gif")
		.css("position", "absolute" )
		.css("left", "50%" )
		.css("top", "30%")
		.appendTo(back );
}

function hideLoadingIcon(){
	$(".tmp-loading-back").remove();
}

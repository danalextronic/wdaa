var MAIN_URL = "https://script.google.com/macros/s/AKfycbyTWTAq8bO2xgAAQ3MbAgmVUHvZpwllHMWSCGwps7yt2aRqba0/exec";
var index = 0;

	//var choices=new Array( "Multiple Choice 1", "Multiple Choice 2");
	//var choices=new Array( "Multiple Choice 1", "Multiple Choice 2", "Multiple Choice 3", "Multiple Choice 4");
	var choices1=new Array( "Multiple Choice 1", "Multiple Choice 2", "Multiple Choice 3", "Multiple Choice 4", "Multiple Choice 5");
	var choices2=new Array( "Multiple Choice 1", "Multiple Choice 2");
	var choices3=new Array( "Multiple Choice 1", "Multiple Choice 2", "Multiple Choice 3", "Multiple Choice 4", "Multiple Choice 5", "Multiple Choice 6");

	var theme = "block";
//	var theme = "yellow";
//	var theme = "blue";

	var header_title_arr = new Array();
	header_title_arr.push("What problem were you hoping to solve with our service1?" );
	header_title_arr.push("What problem were you hoping to solve with our service2?" );
	header_title_arr.push("What problem were you hoping to solve with our service3?" );
	header_title_arr.push("What problem were you hoping to solve with our service4?" );
	header_title_arr.push("What problem were you hoping to solve with our service5?" );

$(document).ready(function(){
	$(".rb-popup").RBPopup({theme:theme, animation_time: 300,  choices: choices1, header_title: header_title_arr[0], pos_right: 80, is_multiple: false, is_open: false});
});

var results = new Array();

function handleAction(){
	var ans = getSelectedAnswer();
	var obj = new Object();
	obj.question = header_title_arr[index];
	obj.answer = ans;
	results.push(obj );
	if ($(".rb-action").html() == "Send" ){
		for (var i = 0; i < results.length; i++ ){
			var url = MAIN_URL + "?q=" + results[i].question + "&a=" + results[i].answer;
			$.get(url);
		}
	}else{
		index = index + 1;
		if (header_title_arr.length < (index + 2) ){
			$(".rb-popup").html("");
			$(".rb-popup").RBPopup({theme:theme, animation_time: 300,  choices: choices3, header_title: header_title_arr[index], pos_right: 80, is_multiple: false, is_final: true, is_open: true });
		}else{
			$(".rb-popup").html("");
			$(".rb-popup").RBPopup({theme:theme, animation_time: 300,  choices: choices2, header_title: header_title_arr[index], pos_right: 80, is_multiple: false, is_open: true });
		}
	}
}
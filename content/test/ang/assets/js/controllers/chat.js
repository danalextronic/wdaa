'use strict';

/**
 * @ngdoc function
 * @name scheduleApp.controller:ChatCtrl
 * @description
 * # ChatCtrl
 * Controller of the scheduleApp
 */

scheduleApp.controller('ChatCtrl', function ($scope, $resource, $timeout, Chathistory, UserList) {
	$scope.chathistory = [];
	$scope.chat_text = "";
	$scope.file_path = "test.png";
	$scope.time_interval = 100;
	$scope.mobile_menu = false;
	$scope.total_messages = [];
	$scope.messages = [];
	$scope.message_count = 10;
	$scope.userlists = [];
	$scope.user_show_count = 3;
	$scope.user_show_list = [];
	$scope.user_hide_list = [];
	$scope.user_hide_string = "";

	Chathistory.query(function(data){
		$scope.total_messages = data.conversation.talk;
		$scope.loadMoreMessage();
	});

	UserList.query(function(data){
		$scope.userlists = data.response.users;
		$scope.user_show_list = [];
		var flag = false;
		if ($scope.userlists.length < $scope.user_show_count ){
			$scope.user_show_count = $scope.userlists.length;
			flag = true;
		}
		for (var i = 0; i < $scope.user_show_count; i++ ){
			$scope.user_show_list.push($scope.userlists[i] );
		}
		if (flag == false ){
			for (var i = $scope.user_show_count; i < $scope.userlists.length; i++){
				$scope.user_hide_list.push($scope.userlists[i] );
				$scope.user_hide_string += $scope.getNameFromEmail($scope.userlists[i].Name ) + "   " ;
			}
		}
	});

	$scope.loadMoreMessage = function(){
		var start = $scope.messages.length;
		if (start >= $scope.total_messages.length ){
			return;
		}
		var end = start + $scope.message_count;
		if (end > $scope.total_messages.length ){
			end = $scope.total_messages.length;
		}
		for (var i = start; i < end; i++ ){
			$scope.messages.push($scope.total_messages[i] );
			$scope.messages[$scope.messages.length - 1].opacity = 0;
		}
		$timeout(function() {
        	for (var i = start; i < end; i++ ){
				$scope.messages[i].opacity = 1;
			}
      	}, $scope.time_interval);
	}

	$scope.convertDate = function(date){
		var tmp_date = new Date(date );
		var month_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", 'Aug', "Sep", "Oct", "Nov", "Dec");
		var str_day = tmp_date.getDate() == 1 ? "first" : tmp_date.getDate() + "th";
		return month_names[tmp_date.getMonth()] + " " + str_day;
	}

	$scope.convertTime = function(time ){
		var regex = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
		var date_arr = regex.exec(time );

		var month_names = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", 'Aug', "Sep", "Oct", "Nov", "Dec");
		var str_day = parseInt(date_arr[3]) == 1 ? "first" : parseInt(date_arr[3]) + "th";
		str_day = month_names[parseInt(date_arr[2])] + " " + str_day;
		var hour = date_arr[4];
		var minute = date_arr[5];
		str_day = str_day + " @ " + hour + ":" + minute;
		return str_day;
	}

	$scope.addChatContent = function(){
		if ($scope.chat_text == "" ){
			return;
		}
		var str = $scope.chat_text.replace(/\n/g, "<br>"); 
		var tmp_obj = new Object();
		tmp_obj.id = $scope.generateId();
		tmp_obj.time = $scope.getNowDate() + " " + $scope.getNowTime();
		tmp_obj.from = "yuval@videocutters.com";
		tmp_obj.from_id = "555";
		tmp_obj.message = str;
		tmp_obj.title = "Message";
		tmp_obj.status = '4';
		tmp_obj.flag = 0;
		tmp_obj.media_type = null;
		tmp_obj.opacity = 0;

		$scope.messages.unshift(tmp_obj );
		$scope.chat_text = "";

		$timeout(function() {
        	return $scope.highlightMessage(tmp_obj.id );
      	}, $scope.time_interval);
	}

	$scope.highlightMessage = function(obj_id ){
		for (var i = 0; i < $scope.messages.length; i++){
			if ($scope.messages[i].id == obj_id ){
				$scope.messages[i].opacity = 1;
				break;
			}
		}
	}

	$scope.getFileName = function(ev){
		$scope.$apply(function(scope) {
      		$scope.file_path = ev.files[0].name;
      });
	}

	$scope.removeUploadFile = function(){
		$scope.file_path = "";
	}

	$scope.getNameFromEmail = function(name){
		var arr = name.split("@");
		return arr[0];
	}

	$scope.generateId = function(){
		return Math.floor(Math.random() * 100 ) + "_" + Math.floor(Math.random() * 100 ) + "_" + Math.floor(Math.random() * 100 );
	}

	$scope.getNowDate = function(){
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		return yyyy + "-" + mm + "-" + dd;
	}

	$scope.getNowTime = function(){
		var today = new Date();
		var hh = today.getHours();
		var mm = today.getMinutes();
		var ss = today.getSeconds();

		return hh + ":" + mm + ":" + ss;
	}	
});

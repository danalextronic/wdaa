'use strict';

/**
 * @ngdoc function
 * @name scheduleApp.controller:MediaCtrl
 * @description
 * # MediaCtrl
 * Controller of the scheduleApp
 */

scheduleApp.controller('MediaCtrl', function ($scope, $resource, $timeout, MediaList, UserList) {
	$scope.file_path = "";
	$scope.medialist = {};
	$scope.medialist.videos = [];
	$scope.medialist.images = [];
	$scope.medialist.audio = [];
	$scope.videoplayble = false;

	$scope.userlists = [];
	$scope.user_show_count = 3;
	$scope.user_show_list = [];
	$scope.user_hide_list = [];
	$scope.user_hide_string = "";
	$scope.avata_hidden_flag = false;

	$scope.getFileName = function(ev){
		$scope.$apply(function(scope) {
      		$scope.file_path = ev.files[0].name;
      });
	}

	MediaList.query(function(data){
		$scope.medialist.videos = data.response.video;
		$scope.medialist.images = data.response.image;
		$scope.medialist.audio  = data.response.audio;

	});

	UserList.query(function(data){
		$scope.userlists = data.response.users;
		$scope.refreshUserLists();
	});
	
	$(window).on("resize", function(){
		$scope.refreshUserLists();
	});

	$scope.refreshUserLists = function(){
		var title_width = $(".project-title").width();
		var left_width = $(".project-title .float-left").width();
		var tmp_width = title_width - left_width;
		var avata_count = parseInt(tmp_width / 50);

		$scope.user_show_list = [];
		$scope.user_hide_list = [];
		$scope.user_hide_string = "";
		$scope.avata_hidden_flag = false;

		if (avata_count < $scope.userlists.length ){
			avata_count = parseInt((tmp_width - 60)/ 50);
			$scope.avata_hidden_flag = true;
		}else{
			avata_count = $scope.userlists.length
			$scope.avata_hidden_flag = false;
		}
		$scope.user_show_count = avata_count;
		
		for (var i = 0; i < $scope.user_show_count; i++ ){
			$scope.user_show_list.push($scope.userlists[i] );
		}
		if ($scope.avata_hidden_flag == true ){
			for (var i = $scope.user_show_count; i < $scope.userlists.length; i++){
				$scope.user_hide_list.push($scope.userlists[i] );
				$scope.user_hide_string += $scope.getNameFromEmail($scope.userlists[i].Name ) + "   " ;
			}
		}
	}

	$scope.getNameFromEmail = function(name){
		var arr = name.split("@");
		return arr[0];
	}

	$scope.playVideo = function(id ){
		if ($scope.videoplayble){
			$("#video" + id)[0].pause();
			$("#img" + id).attr("src", 'assets/img/playbtn.png');
			$scope.videoplayble = false;
		}else{
			$("#video" + id)[0].play();
			$("#img" + id).attr("src", 'assets/img/pausebtn.png');
			$scope.videoplayble = true;
		}
	}

	$scope.onEnterName = function(ev ){
		if (ev.keyCode == 13 ){
			$(ev.currentTarget).blur();
		}
	}
});

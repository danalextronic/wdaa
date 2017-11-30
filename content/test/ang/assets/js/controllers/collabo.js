'use strict';

/**
 * @ngdoc function
 * @name scheduleApp.controller:CollaboCtrl
 * @description
 * # CollaboCtrl
 * Controller of the scheduleApp
 */

scheduleApp.controller('CollaboCtrl', function ($scope, $resource, $timeout, CollaborList, UserList ) {

	$scope.collab_list = [];
	$scope.collab_email = "";
	$scope.userlists = [];
	$scope.user_show_count = 3;
	$scope.user_show_list = [];
	$scope.user_hide_list = [];
	$scope.user_hide_string = "";

	CollaborList.query(function(data){
		for (var i = 0; i < data.response.users.length; i++ ){
			$scope.collab_list.push(data.response.users[i] );
			$scope.collab_list[i].index = i;
		}
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
	
	$scope.refreshCollab = function(){
		for (var i = 0; i < $scope.collab_list.length; i++ ){
			$scope.collab_list[i].index = i;
		}
	}

	$scope.getNameFromEmail = function(name){
		var arr = name.split("@");
		return arr[0];
	}

	$scope.removeCollab = function(index ){
		$scope.collab_list.splice(index, 1 );
		$scope.refreshCollab();
	}

	$scope.addCollab = function(){
		if ($scope.collab_email == "" ){
			return;
		}
		if (!$scope.isValidEmailAddress($scope.collab_email ) ){
			alert("it is invalid email address.");
			return;
		}

		var tmp_obj = new Object();
		tmp_obj.ID = $scope.generateId();
		tmp_obj.Name = $scope.collab_email;
		tmp_obj.Email = $scope.collab_email;

		$scope.collab_list.unshift(tmp_obj );
		$scope.refreshCollab();

		$scope.collab_email = "";
	}

	$scope.generateId = function(){
		return Math.floor(Math.random() * 100 ) + "_" + Math.floor(Math.random() * 100 ) + "_" + Math.floor(Math.random() * 100 );
	}

	$scope.isValidEmailAddress = function(emailAddress) {
    	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    	return pattern.test(emailAddress);
    }

});

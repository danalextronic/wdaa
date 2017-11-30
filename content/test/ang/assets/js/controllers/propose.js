'use strict';

/**
 * @ngdoc function
 * @name scheduleApp.controller:ProposeCtrl
 * @description
 * # ProposeCtrl
 * Controller of the scheduleApp
 */

scheduleApp.controller('ProposeCtrl', function ($scope, $resource, $timeout, SchemeList, MilestoneType, UserList) {
	$scope.mobile_menu = false;
	$scope.scheme_list = {};
	$scope.milestones = {};
	$scope.milestone_type = {};
	$scope.switch_payment = true;


	$scope.userlists = [];
	$scope.user_show_count = 3;
	$scope.user_show_list = [];
	$scope.user_hide_list = [];
	$scope.user_hide_string = "";

	SchemeList.query(function(data){
		$scope.scheme_list = data.response;
	    $scope.scheme_list.unshift(tmp_obj );
	});

	MilestoneType.query(function(data){
		$scope.milestone_type = data.response;
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

	$scope.getNameFromEmail = function(name){
		var arr = name.split("@");
		return arr[0];
	}


	$scope.changeScheme = function(scheme_id ){
		$scope.milestones = $scope.getMilestones(scheme_id );
		for (var i = 0; i < $scope.milestones.length; i++ ){
			$scope.milestones[i].index = i + 1;
			$scope.milestones[i].percent = parseInt($scope.milestones[i].percent );
			$scope.milestones[i].milestone_type_name = $scope.getMilestoneType($scope.milestones[i].milestone_type );
			if (i > ( $scope.milestones.length - 2 ) ){
				$scope.milestones[i].last_flag = true;
			}else{
				$scope.milestones[i].last_flag = false;
			}
		}
	};

	$scope.getMilestones = function(scheme_id ){
		for (var i = 0; i < $scope.scheme_list.length; i++ ){
			if ($scope.scheme_list[i].scheme_id == scheme_id ){
				return $scope.scheme_list[i].milestones;
			}
		}
		return {};
	}

	$scope.getMilestoneType = function(milestone_type ){
		for (var i = 0; i < $scope.milestone_type.length; i++ ){
			if ($scope.milestone_type[i].id == milestone_type ){
				return $scope.milestone_type[i].name;
			}
		}
	}

	$scope.changePercent = function(percent, index ){
		var sum = 0;
		for (var i = 0; i < $scope.milestones.length - 1; i++ ){
			sum = $scope.milestones[i].percent + sum;
		}
		var last_value = 100 - sum;	
		if (last_value < 0 ){
			$scope.milestones[index - 1].percent = $scope.milestones[index - 1].percent - 1;
			$scope.milestones[$scope.milestones.length - 1].percent = 100 - sum + 1;
		}else{
			$scope.milestones[$scope.milestones.length - 1].percent = 100 - sum;	
		}
	}

	$scope.removeMilestone = function(index ){
		$scope.milestones.splice(index - 1, 1 );
		$scope.refreshMilestone();
		var sum = 0;
		for (var i = 0; i < $scope.milestones.length - 1; i++ ){
			sum = $scope.milestones[i].percent + sum;
		}
		$scope.milestones[$scope.milestones.length - 1].percent = 100 - sum;	
	}

	$scope.addMilestone = function(index ){
		index = index - 1;
		var new_obj = new Object();
		new_obj.percent = 0;
		new_obj.name = "";
		new_obj.deliverable = "";
		new_obj.milestone_type = $scope.milestones[index].milestone_type;
		new_obj.milestone_type_name = $scope.getMilestoneType($scope.milestones[index].milestone_type );
		new_obj.last_flag = false;

		$scope.milestones.splice(index, 0, new_obj );
		$scope.refreshMilestone();
	}

	$scope.refreshMilestone = function(){
		for (var i = 0; i < $scope.milestones.length; i++ ){
			$scope.milestones[i].index = i + 1;
		}		
	}

});

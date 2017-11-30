scheduleApp.factory("Chathistory", function($resource){
  return $resource("chat.json", {}, {
    query: { method: "GET", isArray: false }
  });
});

scheduleApp.factory("SchemeList", function($resource){
	return $resource('milestones.json', {}, {
		query: {method: 'GET', isArray: false }
	});
});

scheduleApp.factory("MilestoneType", function($resource){
	return $resource("ms_types.json", {}, {
		query: {method: 'GET', isArray: false }
	});
});

scheduleApp.factory('CollaborList', function($resource){
	return $resource("collab.json", {}, {
		query: {method: 'GET', isArray: false }
	});
});

scheduleApp.factory('MediaList', function($resource){
	return $resource("project.json", {}, {
		query: {method: 'GET', isArray: false }
	});
});

scheduleApp.factory('UserList', function($resource){
	return $resource("users.json", {}, {
		query: {method: 'GET', isArray: false }
	});
});

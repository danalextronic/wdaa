scheduleApp.factory("Chathistory", function($resource) {
  return $resource("chat.json", {}, {
    query: { method: "GET", isArray: false }
  });
});
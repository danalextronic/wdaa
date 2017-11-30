'use strict';

/**
 * @ngdoc overview
 * @name scheduleApp
 * @description
 * # scheduleApp
 *
 * Main module of the application.
 */

angular
  .module('scheduleApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/chat', {
        templateUrl: 'assets/js/views/chat.html',
        controller: 'ChatCtrl'
      })
      .when('/propose', {
        templateUrl: 'assets/js/views/propose.html',
        controller: 'ProposeCtrl'
      })
      .when('/media', {
        templateUrl: 'assets/js/views/media.html',
        controller: 'MediaCtrl'
      })
      .when('/collabo', {
        templateUrl: 'assets/js/views/collabo.html',
        controller: 'CollaboCtrl'
      })
      .otherwise({
        redirectTo: '/chat'
      });
  });


 window.scheduleApp = angular.module('scheduleApp');
(function() {

	'use strict';

	angular
		.module('authApp')
		.controller('UserController', UserController);

	function UserController($http, $auth, $state) {

		var vm = this;

		vm.users;
		vm.teachingPoints;
		vm.error;

		vm.getUsers = function() {

			// This request will hit the index method in the AuthenticateController
			// on the Laravel side and will return the list of users
			$http.get('api/authenticate').success(function(users) {
				vm.users = users;
			}).error(function(error) {
				vm.error = error;
			});
		}

		vm.getTeachingPoint = function() {

			// This request will hit the index method in the AuthenticateController
			// on the Laravel side and will return the list of users
			$http.get('api/teachingPoints').success(function(teachingPoints) {
				vm.teachingPoints = teachingPoints;
			}).error(function(error) {
				vm.error = error;
			});
		}

		vm.logout = function() {

			// Use Satellizer's $auth service to logout
			$auth.logout().then(function(data) {

				// If logout is successful, redirect to the auth state
				$state.go('auth');
			}, function(error) {
				console.log(error);
			});
		}
	}
	
})();
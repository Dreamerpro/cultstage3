angular.module('cultstage')
.controller('BookmarkedEvents', function ($http) {
	var _self=this;
	_self.events=[];

	this.init=function () {
		$http.get('/bookmarkedevents')
		.success(function (argument) {
			console.log(argument);
			_self.events=argument;
		})
		.error(function (argument) {
			console.log(argument);
		})
	}

})

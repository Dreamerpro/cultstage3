angular.module('cultstage')
.controller('MyJobPostings', function ($http) {
	var _self=this;
	_self.myjobs=[];
	this.init=function () {
		$http.get('/myjobpostings')
		.success(function (argument) {
			_self.myjobs=argument;
			console.log(argument);
		})
		.error(function (argument) {
			console.log(argument);
		})

	}
})
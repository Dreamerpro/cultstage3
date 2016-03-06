angular.module('cultstage')
.controller('AppliedJobs', function ($http) {
	var _self=this;
	_self.myjobs=[];
	this.init=function () {
		$http.get('/appliedjobs')
		.success(function (argument) {
			_self.myjobs=argument;
			console.log(argument);
		})
		.error(function (argument) {
			console.log(argument);
		})
	}
})
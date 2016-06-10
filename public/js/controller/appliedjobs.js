angular.module('cultstage')
.controller('AppliedJobs', function ($http, Notification) {
	var _self=this;
	_self.myjobs=[];
	this.init=function () {
		_self.loaded=false;
		$http.get('/appliedjobs')
		.success(function (argument) {
			_self.myjobs=argument;
			_self.loaded=true;
		})
		.error(function (argument) {
			_self.loaded=true;
			console.log(argument);
		})
	}

	this.cancelJob=function(job,index) {
		$http.get('/removeapplication/'+job.id)

		.success(function (argument) {
			_self.myjobs.splice(index,1);
			Notification.success({message: 'Job application canceled.', replaceMessage: true});})
		.error(function (argument) {		console.log(argument);	})
	}
})

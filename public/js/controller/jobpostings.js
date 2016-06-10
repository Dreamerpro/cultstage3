angular.module('cultstage')
.controller('MyJobPostings', function ($http, Notification, $filter, $scope) {
	var _self=this;
	_self.myjobs=[];
	_self.editmode=false;
	_self.available={};
	this.init=function () {
		_self.loaded=false;
		$http.get('/myjobpostings')
		.success(function (argument) {
			_self.myjobs=argument;
			_self.loaded=true;
			console.log(argument);
		})
		.error(function (argument) {
			_self.loaded=true;
			console.log(argument);
		})

		$http.get('/availableroles')
		.success(function (argument) { _self.available.roles=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/myprojects')
		.success(function (argument) {	_self.myprojects=argument;	})
		.error(function() {console.log("pro error!")});

	}

	this.deleteJob=function(job, index) {
		$http.get('/deletejob/'+job.id)
		.success(function(hola) {
			_self.myjobs.splice(index,1);
			 Notification.success({message: 'Job succesfully deleted.', replaceMessage: true});
		})
		.error(function(bola) {

		})
	}
	this.reset=function () {
		_self.job={};
		_self.editmode=false;
	}
	this.editJob=function(job,index) {
		_self.job=job;
		_self.job.projectid=_self.job.project_id;
		_self.job.requirement=_self.job.role.id;
		var datePartials = _self.job.last_date.split("-");
		_self.job.date = new Date(datePartials[0], datePartials[1] - 1, datePartials[2]);
		_self.editmode=true;
	}


this.saveJob=function() {
	$http.post('/newjob',_self.job)
	.success(function (argument) {
		Notification.success({message: 'Job succesfully saved.', replaceMessage: true});
		_self.reset();
	})
	.error(function(d) {
		console.error(d);
	})
}


})

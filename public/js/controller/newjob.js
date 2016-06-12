angular.module("cultstage")
.controller('NewJobCtrl', function ($http, Notification) {

	var _self=this;
	this.available={
		languages:[],
		roles:[],
		locations:[],
		productionstages:[]
	}
	this.myprojects=[];

	this.init=function () {
		$http.get('/availablelocations')
		.success(function (argument) { _self.available.locations=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availablelanguages')
		.success(function (argument) { _self.available.languages=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availableproductionstages')
		.success(function (argument) { _self.available.productionstages=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availableprojecttypes')
		.success(function (argument) { _self.available.projecttypes=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availableroles')
		.success(function (argument) { _self.available.roles=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/myprojects')
		.success(function (argument) {
			_self.myprojects=argument;
		})
	}

	this.createNewJob=function (argument) {
		$http.post('/newjob',_self.post)
		.success(function (argument) {
			_self.flash="."
			_self.post={};
			Notification.success({message:'The job is successfully posted.', replaceMessage:true});
		})
		;
	}

})

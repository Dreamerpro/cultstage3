angular.module('cultstage')
.controller('DashboardCtrl', function  ($http, $location) {
	// body...
	var _self=this;
	this.dashboard={};


	this.init=function () {
		_self.getUserData();
		_self.getconnectionrequests();
	}
	this.getUserData=function(){
		$http.get('/userdetails/self')
		.then(
			function(data){
				return _self.dashboard.datauser=data.data;
			},
			function(err){
	/*			SessionService.clearuser();
				$rootScope.updateUserStatus();*/
				$location.path('/');
			}
		)
	}
	this.getconnectionrequests=function () {
		$http.get('/get_connect_requests')
		.success(function (argument) {
			_self.dashboard.connectionrequest=argument;
		})
		.error(function (argument) {
			//console.log(argument);
		})
	}

	this.accept=function (a) {
		$http.get('/acceptconnect/'+a.id)
		.success(function (argument) {
			console.log(argument);
			_self.dashboard.connectionrequest.splice(_self.dashboard.connectionrequest.indexOf(a),1);
		})
		.error(function (argument) {
			console.log(argument);
		})
	}

})

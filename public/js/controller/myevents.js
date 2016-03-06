angular.module('cultstage')
.controller('MyEvents', function ($http) {
	var _self=this;
	_self.events=[];

	this.init=function (which) {
		_self.events=[];
		if(which==2){//posted
			$http.get('/postedevents')
			.success(function (argument) {
				console.log(argument);
				_self.totalbookmarked=argument.length;
				_self.events=argument;
			})
			.error(function (argument) {
				console.log(argument);
			})
		}
		else if(which==1){//bookmarked
			$http.get('/bookmarkedevents')
			.success(function (argument) {
				_self.totalbookmarked=argument.length;
				_self.events=argument;
				console.log(_self.totalbookmarked);
			})
			.error(function (argument) {
				console.log(argument);
			})
		}
		
	}

})
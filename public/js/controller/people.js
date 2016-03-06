angular.module('cultstage')
.controller('PeopleCtrl', function ($http,$location) {
	var _self=this;

	this.peoplesdata={};
	
	this.init=function(){
		$http.get('/connectedpeople')
		.then(
			function(arg){
				_self.peoplesdata=arg.data;
			},
			function(arg){
				console.log(arg);
			}
		)
	}

	this.apply_filter=function(filteroption){
		console.log(filteroption);
		//$location.search(JSON.stringify(filteroption));
		$http.post('/filteredconnectedpeople',filteroption)
		.success(function(data){
			console.log(data);
			_self.peoplesdata=data;
		})
		.error(function(err){
			console.log(err);
		})
	}
	
})
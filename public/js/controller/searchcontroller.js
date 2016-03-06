angular.module('cultstage')
.controller('SearchCtrl', function ($http, $location, $rootScope) {
	var _self=this;
	this.results=[];
	this.query=$location.search();
	this.init=function () {
		//console.log(_self.query);
		$http.post('/search/'+_self.query.query+"/"+_self.query.category)
		.success(function (data) {
			console.log(data);
			_self.results=data;
		})
		.error(function (msg) {
			console.log(msg);
		})
	}

	this.apply_filter=function(filteroption){
		//console.log(filteroption);
		//$location.search($.param(filteroption));
		//$location.search(JSON.stringify(filteroption));
		$http.post('/search/'+_self.query.query+"/"+_self.query.category,filteroption)
		.success(function(data){
			console.log(data);
			_self.results=data;
		})
		.error(function(err){
			console.log(err);
		})
	}
	this.connect=function (id) {
		if($rootScope.isLoggedIn){
			$http.post('/connect',{uid:id})
			.success(function (argument) {
				console.log(argument);
			})
			.error(function (argument) {
				console.log(argument);
			})
		}
		else{
			alert('You need to log in first!')
		}
		
	}
})
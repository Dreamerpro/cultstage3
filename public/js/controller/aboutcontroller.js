angular.module('cultstage')
.controller('ProfileAboutCtrl', function  ($http, $location,UserService) {
	// body...
	var _self=this;
	this.about={};
	this.avatar=UserService.get().avatar;


	this.init=function () {
		_self.getUserData();
	}
	this.getUserData=function(){
		$http.get('/userdetails/self')
		.then(
			function(data){
				data.data.languages=_self.collectLanguageNames(data.data.languages);
				
				data.data.roles=_self.collectRoleNames(data.data.roles);
				data.data.locations=_self.collectLocationNames(data.data.locations);
				return _self.about=data.data;
			},
			function(err){
				alert(err.data.msg);
	/*			SessionService.clearuser();
				$rootScope.updateUserStatus();*/	
				$location.path('/');
			}
		)
	}
	//in db location and language can be renamed to name
	this.collectLocationNames=function (data) {
		var out=[];	
		for (var i = data.length - 1; i >= 0; i--) {
			out.push(data[i].location);
		}
		return out.join(', ');
	}
	this.collectLanguageNames=function (data) {
		var out=[];	
		for (var i = data.length - 1; i >= 0; i--) {
			out.push(data[i].language);
		}
		return out.join(', ');
	}
	this.collectRoleNames=function (data) {
		var out=[];	
		for (var i = data.length - 1; i >= 0; i--) {
			out.push(data[i].name);
		}
		return out.join(', ');
	}
})
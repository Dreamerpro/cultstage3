angular.module('cultstage')
.factory('Validator', function(){
	return {
		isValid:function(data,isSignup){
			if(data.password===undefined || data.password.length<6 || data.email==undefined || data.email.length<1){
				console.log(data.password);	
				return false;
			}
			if(isSignup===true && data.name.length<1){
				return false;
			}

			return true;
		}
	}
})
.factory('SessionService', function(){
	return {
		set:function(key, val){
			return sessionStorage.setItem(key,val);
		},
		get:function(key){
			return sessionStorage.getItem(key);
		},
		unset:function(key){
			return sessionStorage.removeItem(key);
		},
		clearuser:function(){
			return sessionStorage.removeItem('authenticated');
		}
	}
})
.factory('AuthService', function($http, SessionService,$rootScope,$location){
	var cache=function(userdata){
		SessionService.set('authenticated', true);
		console.log(userdata);
		SessionService.set('name', userdata.name);
		SessionService.set('email', userdata.email);
		SessionService.set('avatar', userdata.avatar);
		
		$rootScope.updateUserStatus();
		$("#sign-modal").modal('hide');
	}
	var uncache=function(){
		SessionService.unset('authenticated');
		SessionService.unset('name');
		SessionService.unset('email');
		SessionService.unset('avatar');
		$rootScope.updateUserStatus();
	}

	return {
		login:function(credentials){
			var prom= $http.post('/login',credentials);
			prom.success(function(resp){
				cache(resp);
				console.log(resp);
			})
			.error(uncache);
			return prom;
		},
		register:function(userdata){
			var prom= $http.post('/register',userdata);
			prom.success(function(resp){
				cache(resp);
			})
			.error(uncache);
			return prom;
		},
		logout:function(){
			prom= $http.get('/logout');
			prom.success(uncache);
			prom.error(function (argument) {
				console.log(argument);
			});
			$location.path('/');
			return prom;
		},
		isloggedin:function(){
			return SessionService.get('authenticated');
		}

	}
})
.factory('UserService', function($http, SessionService){
	return {
		get:function(){
			return {
				name:SessionService.get('name'),
				email:SessionService.get('email'),
				avatar:SessionService.get('avatar')
			}
		}

	}
})
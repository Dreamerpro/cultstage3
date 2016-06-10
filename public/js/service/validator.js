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
.factory('CookieService', function($cookies){
	return {
		set:function(key, val){
			return $cookies.put(key, val);
		},
		get:function(key){
			return $cookies.get(key);
		},
		unset:function(key){
			return $cookies.remove(key);//, { path: '/' ,domain: '.www.cultstage.com'}
		},
		clearuser:function(){
			return $cookies.remove('authenticated', { path: '/' });
		}
	}
})
.factory('AuthService', function($http, CookieService,$rootScope,$location, Notification){
	var cache=function(userdata){
		CookieService.set('authenticated', true);
		console.log(userdata);
		CookieService.set('name', userdata.name);
		CookieService.set('email', userdata.email);
		if(userdata.avatar!=null){CookieService.set('avatar', userdata.avatar);}
		if(userdata.cover!=null){CookieService.set('cover', userdata.cover);}
		$rootScope.updateUserStatus();
		$("#sign-modal").modal('hide');
		Notification.success({message: 'Successfully logged in.', replaceMessage: true});
	}
	var uncache=function(){
		CookieService.unset('authenticated');
		CookieService.unset('name');
		CookieService.unset('email');
		CookieService.unset('avatar');
		CookieService.unset('cover');
		$rootScope.updateUserStatus();
		console.log("uncahced");
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
			return CookieService.get('authenticated');
		}

	}
})
.factory('UserService', function($http, CookieService){
	return {
		get:function(){
			return {
				name:CookieService.get('name'),
				email:CookieService.get('email'),
				avatar:CookieService.get('avatar'),
				cover:CookieService.get('cover')
			}
		}

	}
})

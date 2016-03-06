angular.module('cultstage')
.controller('EditProfileCtrl', function ($http,$location,$rootScope,SessionService,$scope,$filter,SessionService) {
	var _self=this;
	this.profiledata=false;
	this.flashmessage=false;
	/*this.availableroles=[];
*/
	this.available={
		locations:[],
		languages:[],
		roles:[]
	}
	/*if(!this.profiledata){
		console.log('asd');
		
	}*/

	this.getUserData=function(){
		$http.get('/userdetails/self')
		.then(
			function(data){
				_self.profiledata=data.data;
				console.log(data);
				_self.getAvailableLists();
			},
			function(err){
				alert(err.data.msg);
				SessionService.clearuser();
				$rootScope.updateUserStatus();	
				$location.path('/');
			}
		)
	}
	this.getAvailableLists=function () {
		$http.get('/availableroles/')
		.then(
			function (argument) {
				
				//var role_values=_.values(_self.profiledata.roles);
				var roleid=-1;
				for (var i = _self.profiledata.roles.length - 1; i >= 0; i--) {
					roleid=_self.profiledata.roles[i].role_id;
					for (var j = argument.data.length-1; j >=0; j--) {		
						if(roleid==argument.data[j].id){ argument.data.splice(j,1); }
					}
				}
				console.log(argument.data);
				_self.available.roles=argument.data;

			},
			function (argument) {
				console.log(argument);
			}
		)

		$http.get('/availablelocations/')
		.then(
			function (argument) {
				var locationid=-1;
				for (var i = _self.profiledata.locations.length - 1; i >= 0; i--) {
					locationid=_self.profiledata.locations[i].location_id;
					for (var j = argument.data.length-1; j >=0; j--) {		
						if(locationid==argument.data[j].location_id){ argument.data.splice(j,1); }
					}
				}
				_self.available.locations=argument.data;
				console.log(argument.data)				;
			},
			function (argument) {
				console.log(argument);
			}
		)

		$http.get('/availablelanguages/')
		.then(
			function (argument) {
			var languageid=-1;
				for (var i = _self.profiledata.languages.length - 1; i >= 0; i--) {
					languageid=_self.profiledata.languages[i].language_id;
					for (var j = argument.data.length-1; j >=0; j--) {		
						if(languageid==argument.data[j].language_id){ argument.data.splice(j,1); }
					}
				}
				_self.available.languages=argument.data;
			},
			function (argument) {
				console.log(argument);
			}
		)
	}


	this.removelocation=function (arg) {
		var deleted=_self.profiledata.locations.splice(_self.profiledata.locations.indexOf(arg),1);
		_self.available.locations.push(deleted[0]);
	}

	this.removelanguage=function (arg) {
		var deleted=_self.profiledata.languages.splice(_self.profiledata.languages.indexOf(arg),1);
		_self.available.languages.push(deleted[0]);
	}

	this.removerole=function (arg) {
		var deleted=_self.profiledata.roles.splice(_self.profiledata.roles.indexOf(arg),1);
		_self.available.roles.push(deleted[0]);
	}


	this.addlocation=function (arg) {
		var toadd=_self.available.locations.splice(_self.available.locations.indexOf(arg),1);
		_self.profiledata.locations.push(toadd[0]);
	}

	this.addlanguage=function (arg) {
		var toadd=_self.available.languages.splice(_self.available.languages.indexOf(arg),1);
		_self.profiledata.languages.push(toadd[0]);
	}

	this.addrole=function (arg) {
		var toadd=_self.available.roles.splice(_self.available.locations.indexOf(arg),1);
		_self.profiledata.roles.push(toadd[0]);
	}

	this.save=function () {
		console.log(_self.profiledata);	
		$http.post('/post/profiledetails',_self.profiledata)
		.then(
			function (argument) {
				console.log(argument);
				/*AuthService.login({email:_self.profiledata.email,password:_self.profiledata.password}).
				success(function (argument) {
					console.log(argument);
					$rootScope.updateUserStatus();	
				});*/
				SessionService.set('name',_self.profiledata.name);
				SessionService.set('email',_self.profiledata.email);
				$rootScope.updateUserStatus();	
				_self.flashmessage="Details updated succesfully.";
			},
			function (argument) {
				_self.flashmessage="There was error updating data: "+_.values(argument.data);
			}

		)
		;	
	}

	/*$scope.$watch('_self.profiledata.dob',function (newVal, oldVal) {
		if(newVal!=undefined){
			console.log(newVal.getDay());	
		}
		
		//_self.profiledata.dob=$filter('date')(newVal, 'YYYY-MM-DD');

	});*/

})
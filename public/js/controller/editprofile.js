angular.module('cultstage')
.controller('EditProfileCtrl', function ($http,$location,$rootScope,SessionService,$scope,$filter,SessionService, Notification) {
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
	$scope.$watch(function() {return _self.profiledata.phone;}, function(nv,ov) {
		if(nv!==undefined){
			var arr=nv.split(""), i=0;
			//console.log(arr);
				while(i<arr.length){
					//console.log(parseInt(arr[i]));
					if(isNaN(parseInt(arr[i]))){
						//console.log("hola "+parseInt(arr[i]));
						arr.splice(i,1);
						console.log(arr);
						i--;
					}
					i++;
				}
				_self.profiledata.phone=arr.join("");
				if(_self.profiledata.phone.length<10){_self.profiledata.phoneError="Invalid phone number";}
				else if(_self.profiledata.phone.length>10){
					while (_self.profiledata.phone.length!=10) {_self.profiledata.phone=_self.profiledata.phone.substring(0, _self.profiledata.phone.length-1);}
				}
				else{ _self.profiledata.phoneError=false;	}
		}
}) ;

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
			//	console.log(argument.data);
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
			//	console.log(argument.data)				;
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
				//console.log(argument);
			}
		)
	}

	this.removeItem=function(profiledataarray, item, nonselected) {
		var deleted=profiledataarray.splice(profiledataarray.indexOf(item,1));
		nonselected.push(deleted[0]);
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
				// _self.flashmessage="Details updated succesfully.";
				Notification.success({message: 'Your profile succesfully saved.', replaceMessage: true});
			},
			function (argument) {
				Notification.success({message: 'There was error saving data.', replaceMessage: true});
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

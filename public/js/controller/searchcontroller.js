angular.module('cultstage')
.controller('SearchCtrl', function ($http, $location, $rootScope, $scope, Notification) {
	var _self=this;
	this.results=[];

	this.init=function () {
		_self.loaded=false;
		_self.query=$location.search();
		_self.query.category=parseInt(_self.query.category);
		_self.categories=[{id:0,name:'Job'},{id:1,name:'People'},{id:2,name:'Events'}];
		// console.log(_self.query.category);
		$http.post('/search',_self.query)
		.success(function (data) {
			_self.results=data;
			var zz=null;
			for (var i = 0; i < _self.results.length; i++) {
				zz=_self.results[i];
				zz.roles=_.pluck(zz.roles,'name');
				zz.locations=_.pluck(zz.locations,'location');
				zz.languages=_.pluck(zz.languages,'language');
			}
			_self.loaded=true;
			console.log(_self.results);
		})
		.error(function (msg) {
			_self.loaded=true;
			console.log(msg);		})
	}
	this.psub=function(roles,languages) {
		var out=languages.length?languages.join(","):"";
		return out+roles.join(",");
	}
	this.apply_filter=function(filteroption){
		_self.query.languages=_.pluck(filteroption.languages,'id');
		_self.query.locations=_.pluck(filteroption.locations,'id');
		_self.query.roles=_.pluck(filteroption.roles,'id');
		_self.query.eventtypes=_.pluck(filteroption.eventtypes,'id');
		$location.search(_self.query);
		console.log(_self.query);
	}
	this.connect=function (id) {
		if($rootScope.isLoggedIn){
			$http.post('/connect',{uid:id})
			.success(function (argument) {	Notification.success({message:"Connect request has been sent!.",replaceMessage:true}); console.log(argument);	})
			.error(function (argument) {	console.log(argument);		})
		}
		else{	Notification.error({message:"You need to log in first!",replaceMessage:true});	}
	}
	this.bookmarkevent=function (e) {
		if($rootScope.isLoggedIn){
			$http.get('/bookmarkevent/'+e.id)
			.success(function (argument) { Notification.success({message:"Succesfully bookmarked event.",replaceMessage:true});		console.log(argument);	e.bookmarked=true;})
			.error(function (argument) { console.log(argument);		})
		}
		else{	Notification.error({message:"You need to log in first!",replaceMessage:true});	}
	}
	this.applyforjob=function(job) {
		if($rootScope.isLoggedIn){
			$http.get('/applyforjob/'+job.id)
			.success(function (argument) { Notification.success({message:"Succesfully applied for job.",replaceMessage:true});		console.log(argument);	})
			.error(function (argument) { console.log(argument);		})
		}
		else{	Notification.error({message:"You need to log in first!",replaceMessage:true});	}
	}

	$scope.$watch(function() {return _self.query.category;	}, function() {
		$location.search(_self.query);
	})
})

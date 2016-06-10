angular.module('cultstage')
.controller('PeopleCtrl', function ($http,$location) {
	var _self=this;

	this.peoplesdata={};

	this.init=function(){
		_self.query=$location.search();
		_self.loaded=false;
		$http.post('/filteredconnectedpeople',_self.query)
		//$http.get('/connectedpeople')
		.then(
			function(arg){
				_self.peoplesdata=arg.data;
//console.log("bulla",_self.peoplesdata);
				for (var i = 0; i < _self.peoplesdata.connectedpeople.length; i++) {
					zz=_self.peoplesdata.connectedpeople[i];
					zz.roles=_.pluck(zz.roles,'name');
					zz.locations=_.pluck(zz.locations,'location');
					zz.languages=_.pluck(zz.languages,'language');
					console.log("bulla");
				}
				_self.loaded=true;
			},
			function(arg){
				_self.loaded=true;
				console.log(arg);
			}
		)
	}

this.disconnect=function(him,index) {
	$http.get('/disconnect/'+him.id)
	.then(
		function(arg){
			_self.peoplesdata.splice(index,1);
			_self.init();
		},
		function(arg){
			console.log(arg);
		}
	)
}
this.apply_filter=function(filteroption){
	_self.query.languages=_.pluck(filteroption.languages,'id');
	_self.query.locations=_.pluck(filteroption.locations,'id');
	_self.query.roles=_.pluck(filteroption.roles,'id');
	_self.query.eventtypes=_.pluck(filteroption.eventtypes,'id');
	$location.search(_self.query);
	// console.log(_self.query);
}
	// this.apply_filter=function(filteroption){
	// 	_self.query.languages=_.pluck(filteroption.languages,'id');
	// 	_self.query.locations=_.pluck(filteroption.locations,'id');
	// 	_self.query.roles=_.pluck(filteroption.roles,'id');
	// 	_self.query.eventtypes=_.pluck(filteroption.eventtypes,'id');
	// 	$location.search(_self.query);
	//
	// 	$http.post('/filteredconnectedpeople',filteroption)
	// 	.success(function(data){
	// 		console.log(data);
	// 		_self.peoplesdata=data;
	// 	})
	// 	.error(function(err){
	// 		console.log(err);
	// 	})
	// }

})

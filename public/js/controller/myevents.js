angular.module('cultstage')
.controller('MyEvents', function ($http, Notification, Upload) {
	var _self=this;
	_self.loaded=false;


	this.init=function (which) {
		_self.events=[];
		_self.editmode=0;
		_self.available={};
		_self.loaded=false;
		_self.selected={};
		if(which==2){//posted
			$http.get('/postedevents')
			.success(function (argument) {	_self.events=argument;	_self.loaded=true;})
			.error(function (argument) {	console.log(argument);		_self.loaded=true;})
		}
		else if(which==1){//bookmarked
			$http.get('/bookmarkedevents')
			.success(function (argument) { _self.events=argument;		_self.loaded=true;})
			.error(function (argument) { console.log(argument);		_self.loaded=true;})
		}
		$http.get('/availablelocations/')
		.success(function(args){		_self.available.locations=args;		})
		.error(function(err){ console.log(err); })

		$http.get('/availablelanguages/')
		.success(function(args){ 		_self.available.languages=args;		})
		.error(function(err){ console.log(err); })

		$http.get('/availableeventtypes/')
		.success(function(args){			_self.available.types=args;		})
		.error(function(err){ console.log(err); })

		$http.get('/availableroles/')
		.success(function(args){			_self.available.audiences=args;		})
		.error(function(err){ console.log(err); })
	}



		this.addloc=function(locobj){
			_self.selected.locations.push(locobj);
			_self.available.locations.splice(_self.available.locations.indexOf(locobj),1);
		}
		this.addlang=function(langobj){
			_self.selected.languages.push(langobj);
			_self.available.languages.splice(_self.available.languages.indexOf(langobj),1);
		}
		this.addaudience=function(audobj){
			_self.selected.audiences.push(audobj);
			_self.available.audiences.splice(_self.available.audiences.indexOf(audobj),1);
		}
		this.removeloc=function(locobj){
			_self.available.locations.push(locobj);
			_self.selected.locations.splice(_self.selected.locations.indexOf(locobj),1);
		}
		this.removelang=function(langobj){
			_self.available.languages.push(langobj);
			_self.selected.languages.splice(_self.selected.languages.indexOf(langobj),1);
		}
		this.removeaudience=function(audobj){
			_self.available.audiences.push(audobj);
			_self.selected.audiences.splice(_self.selected.audiences.indexOf(audobj),1);
		}

	this.edit=function (event) {
		_self.editmode=1;
		_self.selected=event;

		var stime=_self.selected.starting_time.split(":");
		var etime=_self.selected.closing_time.split(":");


		_self.selected.startingdate=new Date(_self.selected.start_date);
		_self.selected.closingdate=new Date(_self.selected.end_date);
		_self.selected.startingtime=new Date(2011,12,1,stime[0],stime[1],stime[2]);
		_self.selected.closingtime=new Date(2011,12,1,etime[0],etime[1],etime[2]);
		if(_self.selected.image=="0"){_self.selected.image=null;}

		for (var i = 0; i < _self.selected.locations.length; i++) {
			var z=_self.selected.locations[i];
			for (var j = 0; j < _self.available.locations.length; j++) {
				if( z.id==_self.available.locations[j].id){		_self.available.locations.splice(j,1);		}
			}
		}

		for (var i = 0; i < _self.selected.languages.length; i++) {
			var z=_self.selected.languages[i];
			for (var j = 0; j < _self.available.languages.length; j++) {
				if( z.id==_self.available.languages[j].id){		_self.available.languages.splice(j,1);		}
			}
		}

		for (var i = 0; i < _self.selected.audiences.length; i++) {
			var z=_self.selected.audiences[i];
			for (var j = 0; j < _self.available.audiences.length; j++) {
				if( z.id==_self.available.audiences[j].id){		_self.available.audiences.splice(j,1);		}
			}
		}

		// for (var i = 0; i < _self.selected.languages.length; i++) {
		// 	var z=_self.selected.languages[i];
		// 	var i=_self.available.languages.indexOf(z);
		// 	_self.available.languages.splice(i,1);
		// }
		// for (var i = 0; i < _self.selected.audiences.length; i++) {
		// 	var z=_self.selected.audiences[i];
		// 	var i=_self.available.audiences.indexOf(z);
		// 	_self.available.audiences.splice(i,1);
		// }
	}
	this.delete=function(event, index) {
		$http.get('/deleteevent/'+event.id)
		.success(function (argument) {
				_self.events.splice(index,1);
				Notification.success({message:'Successfully deleted event.',replaceMessage:true});
		})
		.error(function (argument) { console.log(argument);	})
	}
	this.deleteImage=function() {
		$http.post('/deleteimage',{filename:_self.selected.image,type:2})
		.success(function (argument) {
			_self.file=null;
			_self.selected.image=null;
		})
		.error(function (argument) {
			console.log('error deleting file. ' +argument);
			_self.file=null;
			_self.selected.image=null;
		});
	}
	this.uploadnow=function(file){
		Upload.upload({
						url: '/uploadeventimage',
						data: {file: file}
				}).then(function (resp) {
						console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
						_self.selected.image=resp.data.name;
						console.log(resp);
				}, function (resp) {
						console.log('Error status: ' + resp.status);
				}, function (evt) {
						var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
						console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
				});
	}
	this.submit=function(){
		$http.post('/postnewevent', _self.selected)//edit
		.success(function(data){
			console.log(data)
			Notification.success({message:'Successfully updated event.',replaceMessage:true});
			_self.init(2);
		})
		.error(function(err){
			console.log(err);
		})
	}

	this.removebookmark=function(x,index) {
		$http.get('/unbookmarkevent/'+x.id)//edit
		.success(function(data){
			Notification.success({message:'Successfully removed bookmark.',replaceMessage:true});
			_self.init(1);
		})
		.error(function(err){		console.log(err);	})

	}
})

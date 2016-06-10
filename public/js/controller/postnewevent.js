angular.module('cultstage')
.controller('PostNewEventCtrl', function ($http,$scope,Upload) {
	var _self=this;
	this.available={
		locations:[],
		types:[],
		languages:[],
		audiences:[]
	}
	this.selected={
		languages:[],
		locations:[],
		audiences:[],
		type:null,
		name:null,
		address:null,
		startingdate:null,
		closingdate:null,
		startingtime:null,
		closingtime:null,
		description:'',
		image:null
	}

	this.resetData=function(){
		_self.selected={
			languages:[],
			locations:[],
			audiences:[],
			type:null,
			name:null,
			address:null,
			startingdate:null,
			closingdate:null,
			startingtime:null,
			closingtime:null,
			description:'',
			image:null
			}
	}
	this.init=function(){
		$http.get('/availablelocations/')
		.success(function(args){		_self.available.locations=args;		})
		.error(function(err){ console.log(err); })

		$http.get('/availablelanguages/')
		.success(function(args){ 		_self.available.languages=args;		})
		.error(function(err){ console.log(err); })

		$http.get('/availableeventtypes/')
		.success(function(args){
			_self.available.types=args;		})
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
	this.submit=function(){
		console.log(_self.selected)
		$http.post('/postnewevent',_self.selected)
		.success(function(data){
			console.log(data)
			_self.flashmsg=data.msg;
			//_self.resetData();
		})
		.error(function(err){
			console.log(err);
			_self.flashmsg='There was an error posting new event!';
		})
	}

	this.setForm=function(scope){
		_self.form=scope;
		console.log(scope);
	}
	// this.uploadimage=function(){
	// 	console.log(_self.form, _self.file.$valid);
	// 	 if (_self.form.file.$valid && _self.file) {
	// 	 	console.log('success');
	//         _self.uploadnow(_self.file);
	//     }
	//     else{
	//     	console.log('failed');
	//     }
	// }
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
})

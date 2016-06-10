angular.module("cultstage")
.controller('ProjectCtrl', function ($http,Upload, Notification) {
	var _self=this;

	this.flash="";
	this.myprojects=[];

	this.available={
		languages:[],
		roles:[],
		locations:[],
		productionstages:[]
	}

	this.entered={
		title:null,
		language:null,
		role:null,
		location:null,
		productionstage:null,
		image:null,
		description:null
	}

	this.init=function () {
		_self.add=false;

		$http.get('/availablelocations')
		.success(function (argument) { _self.available.locations=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availablelanguages')
		.success(function (argument) { _self.available.languages=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availableproductionstages')
		.success(function (argument) { _self.available.productionstages=argument; })
		.error(function (argument) {console.log(argument);})

		$http.get('/availableprojecttypes')
		.success(function (argument) { _self.available.projecttypes=argument; })
		.error(function (argument) {console.log(argument);})


		$http.get('/myprojects')
		.success(function (argument) {
			_self.myprojects=argument;
		})
		.error(function (argument) {
			_self.myprojects=[];
			console.log(argument);
		})

	}
	this.editproject=function(project) {
		_self.entered.id=project.id;
		_self.entered.title=project.name;
		_self.entered.projecttype=project.project_types[0].id;
		_self.entered.description=project.details;
		_self.entered.language=project.languages[0].id;
		_self.entered.location=project.locations[0].id;
		_self.entered.productionstage=project.projectstatus.id;
		_self.entered.image=project.image;
		_self.add=true;
		_self.projectc=project;

	}
	this.toggleadd=function (argument) {
		_self.add=!_self.add;
		_self.entered={};
	}

	this.upload = function (file) {
		_self.file=file;
        Upload.upload({
            url: '/uploadprojectimage',
            data: {file: file}
        }).then(function (resp) {
        	_self.entered.image=resp.data.name;
        	console.log(resp);
            //console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
        }, function (resp) {

            console.log('Error status: ' + resp.status);
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });
    };

    this.deleteImage=function () {
    	console.log(_self.entered.image);
    	$http.post('/deleteimage',{filename:_self.entered.image,type:3})
    	.success(function (argument) {
    		_self.file=null;
				_self.entered.image=null;
    	})
    	.error(function (argument) {
    		console.log('error deleting file. ' +argument);
    	});
			console.log(_self.entered.id);
			if(_self.entered.id){
				$http.get('/deleteprojectimage/'+_self.entered.id)
	    	.success(function (argument) {})
	    	.error(function (argument) {})
			}
    }

    this.postProject=function () {
    	$http.post('/newproject',_self.entered)
    	.success(function (argument) {
    		console.log(argument);

				 if(_self.entered.id){
					 _self.myprojects[_self.myprojects.indexOf(_self.projectc)]=argument.project;
				 }
				 else{
					 _self.myprojects.push(argument.project);
				 }
				 _self.add=false;
				 _self.file=null;
				 _self.entered={};
				 Notification.success({message: 'Your profile succesfully saved.', replaceMessage: true});
    	//	_self.flash="Successfully created Project";
    	})
    	.error(function (argument) {
    		console.log(argument);
    		//_self.flash="Error posting new project!";
    	})
    }

		this.deleteproject=function(item) {
			$http.get('/deleteproject/'+item.id)
			.success(function(val) {
				console.log(val);
				_self.myprojects.splice(_self.myprojects.indexOf(item),1);
				Notification.success({message: val, replaceMessage: true});
			})

			.error(function(msg) {
				console.log(msg);
			});
		}

})

angular.module("cultstage")
.controller('ProjectCtrl', function ($http,Upload) {
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
	this.toggleadd=function (argument) {
		_self.add=!_self.add;
		/*$http.get('/availableroles')
		.success(function (argument) { _self.available.roles=argument; })
		.error(function (argument) {console.log(argument);})*/		
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
    	})
    	.error(function (argument) {
    		console.log('error deleting file. ' +argument);
    	})
    }

    this.createNewProject=function () {
    	$http.post('/newproject',_self.entered)
    	.success(function (argument) {
    		console.log(argument);
    		_self.entered={};
    		_self.flash="Successfully created Project";
    	})
    	.error(function (argument) {
    		console.log(argument);
    		_self.flash="Error posting new project!";
    	})
    }

})
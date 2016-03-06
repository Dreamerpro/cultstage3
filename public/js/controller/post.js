angular.module('cultstage')
.controller('PostController', function ($http) {
	var _self=this;
	this.posts=[];
	this.postbody="";
	this.flash="";
	this.init=function () {
		$http.get('/myposts')
		.success(function (argument) {
			_self.posts=argument;
		})
		.error(function (argument) {
			console.log(argument);
		})
	}

	this.post=function () {
		if(_self.postbody.length>0){
			$http.post('/post',{body:_self.postbody})
			.success(function (argument) {
				console.log(argument);
				_self.posts.unshift(argument);
				_self.postbody="";
			})
			.error(function (argument) {
				
			})
		}
		else{
			_self.flash="Please write something";
			console.log("Please write something");
		}
	}
	this.delete=function (argument) {
		console.log(argument);
		$http.get('/delete_post/'+argument.uuid)
		.success(function (data) {
			_self.posts.splice(_self.posts.indexOf(argument),1);
		})
		.error(function (argument) {
			console.log(argument);
		})
	}
	/*this.edit=function (argument) {
		_self.edited=argument;
		_self.edited.postbody=argument.body;
	}*/
	this.saveedit=function (item,_newval) {
		$http.post('/edit_post',{uuid:item.uuid,body:_newval})
		.success(function (data) {
			_self.posts[_self.posts.indexOf(item)].body=_newval;
		})
		.error(function (argument) {
			console.log(argument);
		})
	}

})
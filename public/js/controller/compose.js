angular.module('cultstage')
.controller('ComposeCtrl', function ($http) {
	var _self=this;
	this.options=[];
	this.connected=[];

	this.init=function () {
		_self.getConnectionList();
	}
	this.getConnectionList=function () {
		$http.get('/connectedpeople')
		.success(function (argument) {
			_self.connected=argument.connectedpeople;
		})
		.error(function (argument) {
			console.log('error getting connection list.');
		})
	}
	
	this.send=function () {
		console.log(_self.data);
		$http.post('/sendmessage',{to:_self.data.to.id,subject:_self.data.subject,msg:_self.data.msg});
	}
})
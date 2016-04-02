angular.module('cultstage')
.controller("HomeSearchCtrl", function($scope, $location){
	
	$scope.t="Search"
	$scope.bools=[false,false,false,false];
	$scope.data={};//0:query,1:cat,2:type,3:location, 4:language 
	$scope.suggestions=[
							[
								["Acting","Singing","Casting"],
								["Script Writer","Singer"],
								["Music Festival"]
							],
							["Delhi","Bangalore","Kolkata"],
							["Kannada","Marathi","Hindi"],
						];

	$scope.setVal=function(x){
		$scope.data[2]=x;
	}
	$scope.show=function(v){
		$scope.bools[v]=true;
	}
	/*$scope.searchText=function(){
		if($scope.data[1]==0){return "Search Job";}
		else if($scope.data[1]==1){return "Search People";}
		else if($scope.data[1]==2){return "Search Event";}
		else{return "Search";}
	}*/
	$scope.submit=function(){

		if($scope.validate()){
			console.log($scope.data);
			$location.path('/search');
			$location.search($scope.data);
		}
		else{
			if($scope.data.category==null){
				alert("Please select a category.")
			}
			else{
				alert("Please type something in seach box.")
			}
			
		}
	}
	$scope.validate=function(){
		if($scope.data.query=="" || $scope.data.query==null ||  $scope.data.category==null){return false;}	
		else return true;
	}

})
.controller('MenuCtrl', function($scope, $rootScope){
	$scope.menu=$rootScope.activeM;
	$scope.isActive=function(v){
		return $scope.menu==v;
	};
})

.controller('subRouteController', function($rootScope,$scope){
	$scope.issma=function(v){
		// console.log(v);
		return $rootScope.SM===v;
	}
})
.controller('AddNewJobCtrl', function($scope){
	$scope.b=false;
	$scope.toggleb=function(){
		$scope.b=!$scope.b;
	};
	$scope.updateLayout=function(){
		if($scope.projectid==""){
			$scope.b=false;
		}else{
			$scope.b=true;
		}
		//get project details
	}
})
.controller('MessageController', function($scope, $routeParams, $location, $http,$rootScope,$route){
	
	$scope.b=false;//
	if($rootScope.SM===1){
		$scope.back='inbox';
	}
	if($rootScope.SM===3){
		$scope.back='sent';
	}

	$scope.messages={
		inbox:[],
		sent:[],
		total:{inbox:0,sent:0},
		checked:[],
		showing:[],//range
		open:{uuid:$routeParams.uuid,pos:-1,data:{}}//current open
	}
	console.log($scope.messages);
	
	$scope.init=function(v){
		$scope.messages.showing=[0,10]; //set init showing to be 0-20 of total
		
		if(v===0){// fetch inbox messages
			if($scope.messages.inbox.length<1){
				//get inbox messages upto 20th  and total no. messages
				$scope.messages.inbox=$http.get('/get_inbox')
				.success(function (argument) {
					$scope.messages.inbox=argument;
					$scope.messages.total.inbox=$scope.messages.inbox.length;
					$scope.messages.showing=[1,$scope.messages.total.inbox];
					
					//set showing initialy from 1-total (if total<20) or 0-20 (if total >20)
					if($scope.messages.total.inbox<10){$scope.messages.showing[1]=$scope.messages.total.inbox;}
					else{$scope.messages.showing[1]=10;}
				});
				
			}
				
///////////////////////////////////////////////////////////////////////////////////////
			if($scope.messages.open.uuid!==undefined || $scope.messages.open.uuid!==''){
					//fetch data accoding to uuid
					

					for (var i = 0; i < $scope.messages.inbox.length; i++) {
						if($scope.messages.open.uuid===$scope.messages.inbox[i].uuid){
							$scope.messages.open.pos=i+1;
							$scope.messages.open.data=$scope.messages.inbox[i];
						}
					}
					$scope.messages.checked=[];
					/*$scope.messages.checked.push($scope.messages.open.pos-1);
					console.log($scope.messages.checked);*/
			}

		}
		else if(v===1){// fetch sent messages
			if($scope.messages.sent.length<1){
				//get sent messages upto 20th  and total no. messages
				/*$scope.messages.sent=[
				 	{to:"Mr. X", subject:"Reply to Offer letter dated 15th Jan",body:"Thanks for giving me the opportunity. blah blah blah.",date:"16th Jan"},
					{to:"Mr. Y", subject:"Reaction to spam letter",body:"Stop spamming my inbox you egghead.**** blah blah blah.",date:"19th Jan"}
				];
*/
				$scope.messages.sent=$http.get('/get_sent')
				.success(function (argument) {
					$scope.messages.sent=argument;
					$scope.messages.total.sent=$scope.messages.sent.length;
					$scope.messages.showing=[1,$scope.messages.total.sent];
					
					//set showing initialy from 1-total (if total<20) or 0-20 (if total >20)
					if($scope.messages.total.sent<10){$scope.messages.showing[1]=$scope.messages.total.sent;}
					else{$scope.messages.showing[1]=10;}
				});
							
							 
			}
		}
		
	}
	$scope.fetchmsg=function () {
		$http.get('/get_msg/'+$routeParams.uuid)
		.success(function (argument) {
			$scope.messages.open.data=argument;
		})
		
	}

	$scope.can=function(){
		return {
			back:function(){
				return $scope.messages.showing[0]>1;
			},
			next:function(){
				return $scope.messages.total.inbox > $scope.messages.showing[1];
			}
		}
	}
	$scope.reload=function(v){
		/*alert("It should fetch message data");*/
		$route.reload()
	}
	$scope.fetch_next=function(b){
		if(!$scope.can().next()){return false;}
		
		$scope.messages.showing[0]+=10;// index will be *-1
		
		 var temp=$scope.messages.total.inbox-$scope.messages.showing[1];
		 if(temp>10){
			$scope.messages.showing[1]+=10; 	
		 }
		 else{
		 	$scope.messages.showing[1]=$scope.messages.total.inbox; 		
		 }
		
		//sent get request for next
		//query will be from  $scope.showing[1] to (total - $scope.showing[1]-1) // nos to be fetched =total - $scope.showing[1]
		//alert("asdsa");
 	}
	$scope.fetch_previous=function(b){
		if(!$scope.can().back()){return false;}
		/*alert($scope.showing);*/
		//no need to send query , if user reloads at pagination 50-70 the pagination will start again from 1-20 or so
		//query will be from  $scope.showing[1] to (total - $scope.showing[1]-1) // nos to be fetched =total - $scope.showing[1]
		
		if($scope.messages.showing[1]===$scope.messages.total.inbox){
			console.log($scope.messages.showing[1])
			$scope.messages.showing[1]-=$scope.messages.showing[1]-$scope.messages.showing[0]+1;
			console.log($scope.messages.showing[1])
		}
		else{$scope.messages.showing[1]-=10;}
		$scope.messages.showing[0]=$scope.messages.showing[0]-10;
	
 	}
 	$scope.checkall=function(){
 		
 		$scope.b=!$scope.b;//toggle check all boolean
 		//console.log("this is not working"+ $scope.messages.checked.length);
 		if($scope.messages.checked.length<10){
 			$scope.messages.checked=[];
 			/*for (var i = $scope.messages.showing[0]-1; i <= $scope.messages.showing[1]-1; i++) {
 				$scope.messages.checked.push(i);	
 			}*/	
 			if($scope.back==="inbox"){
 				for (var i = $scope.messages.inbox.length - 1; i >= 0; i--) {
 				$scope.messages.checked.push($scope.messages.inbox[i].uuid);
 				};
 			}
 			if($scope.back==="sent"){
 				for (var i = $scope.messages.sent.length - 1; i >= 0; i--) {
 				$scope.messages.checked.push($scope.messages.sent[i].uuid);
 				};
 			}
 			
 		}
 		else{
 			console.log("this is not working");
 			$scope.messages.checked=[];
 		}
 		
 	}

	$scope.isChecked=function(v){
		return $scope.messages.checked.indexOf(v)>-1;
	}
	$scope.toggleSelected=function(v){
		var i=$scope.messages.checked.indexOf(v);
		if(i>-1){ $scope.messages.checked.splice(i,1);}
		else{ $scope.messages.checked.push(v); }	
		if($scope.b){$scope.b=false;}

	}
	$scope.setRead=function(v){
		return $scope.messages.inbox[v].unread=false;
	}
	$scope.delete=function(){
		

	/*	debugger;

		for (var i = $scope.messages.checked.length - 1; i >= 0; i--) {
			$scope.messages.inbox.splice($scope.messages.checked[i],1);
	//console.log($scope.messages.inbox[$scope.messages.checked[i]]);
			$scope.messages.checked.splice(i,1);
		}
		debugger;
		$scope.messages.total.inbox-= $scope.messages.checked.length;
	///if delete is done from inside the message delete in sever and then redirect as done below
		if($scope.messages.open.uuid!==undefined){
			console.log($scope.messages.open.uuid+" reloading");
			var path=$location.path();//.lastIndexOf("/");
			$location.path(path.substring(0,path.lastIndexOf("/")))
		}*/
		debugger;
	}
	$scope.delete=function () {
		if($scope.b){$scope.b=false;}
		var path=$location.path();//.lastIndexOf("/");
		if($routeParams.uuid){
			$http.post('/delete_msg',{uuids:[$routeParams.uuid],type:$scope.back==="inbox"?1:2})
			.success(function (argument) {
				console.log(argument);
				$location.path(path.substring(0,path.lastIndexOf("/")))
			})
		}
		else{
			$http.post('/delete_msg',{uuids:$scope.messages.checked,type:$scope.back==="inbox"?1:2})
			.success(function (argument) {
				console.log(argument);
				$location.path(path.substring(0,path.lastIndexOf("/")))	
			})
		}
	}

})
.controller("AuthController", function($rootScope,$scope,$http, Validator, AuthService){
	$scope.userData={in:{},up:{}};
	$scope.error={in:false,up:false};
	$scope.submit=function(){
		return {
			signIn:function(){
				if(!Validator.isValid($scope.userData.in,false)) {$scope.error.in=true; return false;}
				
				console.log($scope.userData.toString()+"\n  all set to go");
				/*$http.post('login',$scope.userData.in).success(function(data){
					console.log('success '+ data);
				});*/
				AuthService.login($scope.userData.in)
				.then(
					function(user){
						console.log(user);
						$scope.error.in=false;
					},
					function(err){
						$scope.error.in=_.values(err.data).join("<br>");
						console.log(err);
					}
				)
			},
			signUp:function(){

				if(!Validator.isValid($scope.userData.up,true)) {$scope.error.up="please fill all the fields"; return false;}
				//console.log(JSON.stringify($scope.userData)+"\n  all set to go");
				$scope.userData.up.password_confirmation=$scope.userData.up.password;
				/*$http.post('register',$scope.userData.up).success(function(data){
					alert('success: '+data);
				});*/
				AuthService.register($scope.userData.up)
				.then(
					function(user){
						console.log(user);
						$scope.error.up=false;
						
					},
					function(err){
						$scope.error.up=_.values(err.data).join("<br>");
						console.log(err);
					}
				)
				//function to parse data
			}
		}
	}
})
.controller('ContentCtrl', function($scope,$http,$location){//mainly filters for people and event
	$scope.bool=[false,false,false];
	$scope.data=$location.search();
	//{types:[["Acting","Singing","Casting"],["Script Writer","Singer"],["DJ Night"]],locations:["Delhi","Bangalore","Kolkata"],languages:['Hindi','Kannada','Assamese']},
	

	$scope.init=function(){
		$http.get('/availableroles')
		.success(function(data){
			$scope.data.roles=data;
		})
		.error(function(error){
			console.log(error);
		})
		$http.get('/availablelocations')
		.success(function(data){
			$scope.data.locations=data;
		})
		.error(function(error){
			console.log(error);
		})
		$http.get('/availablelanguages')
		.success(function(data){
			$scope.data.languages=data;
		})
		.error(function(error){
			console.log(error);
		})
		$http.get('/availableeventtypes')
		.success(function(data){
			$scope.data.eventtypes=data;
		})
		.error(function(error){
			console.log(error);
		})

	}
	/*$scope.results=[{name:'Arijit_Singh',avatar:'http://c.saavncdn.com/artists/Arijit_Singh.jpg',types:['Singer'],locations:['Kolkata'],languages:['Hindi'],membersince:'15th Jan',connections:552,profile_uuid:'12311414'},
					{name:'Remo D\'souza',avatar:'http://eni.news24online.com/wp-content/uploads/2015/07/Remo_D_Souza.jpg',types:['Choreographer','Director'],locations:['Kolkata','Bangalore'],connections:10,membersince:'12th Jan, 2016',languages:[],profile_uuid:'1231142344'}];
	*/
	$scope.results1=[{name:'3D Media Conference',avatar:'//s3.amazonaws.com/images.productionhub.com/banners/878_4130_4709.jpg',types:['DJ Night'],date:['19th Dec,15'],locations:['Kolkata'],languages:['Hindi'],details:'blah blah blah blah blah blahblah blah blah',event_uuid:'12311414'},
					{name:'Sunburn Music Festival',avatar:'data:image/jpeg;base64,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',types:['Music Concert'],date:['19th Dec,15'],locations:['Kolkata','Bangalore'],details:'blah blah blah blah blah blahblah blah blah',languages:[],event_uuid:'1231142344'},
					{name:'Vh1 Supersonic',avatar:'data:image/jpeg;base64,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',types:['DJ Night'],date:['19th Dec,15'],locations:['Mumbai'],languages:['Hindi'],details:'blah blah blah blah blah blahblah blah blah',event_uuid:'12311414'}];
		

	$scope.filter_option={roles:[],locations:[],languages:[]};
	
	$scope.reset_filter=function(a){
		while($scope.filter_option.roles.length>0){
			$scope.data.roles.push($scope.filter_option.roles.pop());
		}
		while($scope.filter_option.languages.length>0){
			$scope.data.languages.push($scope.filter_option.languages.pop());
		}
		while($scope.filter_option.locations.length>0){
			$scope.data.locations.push($scope.filter_option.locations.pop());
		}	
	}
	$scope.addfilter=function(i,j,a){
		if(i==1){
			var k=$scope.data.locations.indexOf(j);
			$scope.data.locations.splice(k,1);
			$scope.filter_option.locations.push(j);	
		}
		else if(i==0){
			var k=$scope.data.roles.indexOf(j);
			$scope.data.roles.splice(k,1);
			$scope.filter_option.roles.push(j);	
		}
		else if(i==2){
			var k=$scope.data.languages.indexOf(j);
			$scope.data.languages.splice(k,1);
			$scope.filter_option.languages.push(j);	
		}		
	}
	$scope.removefilter=function(i,j,a){
		if(i==0){
			var k=$scope.filter_option.roles.indexOf(j);
			$scope.filter_option.roles.splice(k,1);
			console.log(j);
			$scope.data.roles.push(j);	
		}
		if(i==1){
			var k=$scope.filter_option.locations.indexOf(j);
			$scope.filter_option.locations.splice(k,1);
			$scope.data.locations.push(j);	
		}
		if(i==2){
			var k=$scope.filter_option.languages.indexOf(j);
			$scope.filter_option.languages.splice(k,1);
			$scope.data.languages.push(j);	
		}
		
	}
})

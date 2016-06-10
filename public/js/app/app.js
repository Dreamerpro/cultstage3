angular.module('cultstage',['ngRoute','ngFileUpload','textAngular','ngSanitize', 'ui.select','ngCookies','ui-notification'])
.config(['$routeProvider', function($routeProvider) {
	$tu="templates/";
	$routeProvider
	.when("/", { templateUrl:$tu+'home.html' })
	//.when("/home", { templateUrl:$tu+'home/index.html'})
	.when("/aboutus", { templateUrl:$tu+'aboutus/index.html'})
	.when("/ourmission", { templateUrl:$tu+'ourmission/index.html'})
	.when("/advertise", { templateUrl:$tu+'advertise/index.html'})
	.when("/teach", { templateUrl:$tu+'teach/index.html'})

	.when("/dashboard", { templateUrl:$tu+'dashboard/index.html'})

	.when("/message", { redirectTo:"message/inbox"})
	.when("/message/compose", { templateUrl:$tu+'message/compose.html'})
	.when("/message/inbox", { templateUrl:$tu+'message/inbox.html'})
	/*.when("/message/unread", { templateUrl:$tu+'message/unread.html'})*/
	.when("/message/sent", { templateUrl:$tu+'message/sent.html'})
	.when("/message/inbox/:uuid", { templateUrl:$tu+'message/msg-view.html'})
	.when("/message/sent/:uuid", { templateUrl:$tu+'message/msg-view.html'})

	.when("/jobs", { redirectTo:'/jobs/my-applications'})
	.when("/jobs/my-applications", { templateUrl:$tu+'jobs/applications.html'})
	.when("/jobs/my-job-postings", { templateUrl:$tu+'jobs/my-job-postings.html'})
	.when("/jobs/new-job", { templateUrl:$tu+'jobs/new-job.html'})
	.when("/jobs/my-projects", { templateUrl:$tu+'jobs/my-projects.html'})

	.when("/people", { redirectTo:"people/connected" })
	.when("/people/connected", { templateUrl:$tu+'people/index.html'})

	.when("/events", { redirectTo:"events/interested"})
	.when("/events/interested", { templateUrl:$tu+'events/index.html'})
	.when("/events/my-events", { templateUrl:$tu+'events/my-events.html'})
	.when("/events/post-new", { templateUrl:$tu+'events/post-new.html'})

	.when("/profile", { redirectTo:"profile/me/about"})
	.when("/profile/:who/about", { templateUrl:$tu+'profile/about.html'})
	.when("/profile/:who/posts", { templateUrl:$tu+'profile/posts.html'})
	.when("/profile/:who/photos", { templateUrl:$tu+'profile/photos.html'})
	.when("/profile/:who/videos", { templateUrl:$tu+'profile/videos.html'})
	.when("/profile/:who/audios", { templateUrl:$tu+'profile/audios.html'})
	.when("/profile/:who/script-works", { templateUrl:$tu+'profile/script-works.html'})
	.when("/profile/edit", { templateUrl:$tu+"profile/edit.html"})

	.when("/event/:uuid",{ templateUrl:$tu+'events/eventview.html'})
	.when("/search/",{ templateUrl:$tu+'search/index.html'})

	/*.when('/home/project/:uuid',{ templateUrl:$tu+'/project/index.html' })
	.when('/profile/:uuid',{ templateUrl:$tu+'/profile/index.html'})
	.when('/message/',{ templateUrl:$tu+'/message/index.html' })
	.when('/people/',{ templateUrl:$tu+'/people/index.html' })
	*/
	.otherwise({
		redirectTo:"/"
	})
	;
}])
.config(function(NotificationProvider) {
        NotificationProvider.setOptions({
            delay: 4000,
            startTop: 20,
            startRight: 10,
            verticalSpacing: 20,
            horizontalSpacing: 20,
            positionX: 'center',
            positionY: 'top'
  			})
})
.config(function($provide) {
    // this demonstrates how to register a new tool and add it to the default toolbar
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions) { // $delegate is the taOptions we are decorating
        /*taRegisterTool('test', {
        buttontext: 'Test',
        action: function() {
        	alert('Test Pressed')
            }
        });
        taOptions.toolbar[1].push('test');
        taRegisterTool('colourRed', {
        iconclass: "fa fa-square red",
        action: function() {
            this.$editor().wrapSelection('forecolor', 'red');
        }
        });
        // add the button to the default toolbar definition
        taOptions.toolbar[1].push('colourRed');*/
        taOptions.toolbar = [
		      ['h1', 'h2', 'h4', 'h6', 'p'],
		      ['bold', 'italics', 'underline', 'ul', 'ol', 'redo', 'undo', 'clear'],
		      ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent']
	  		];
        return taOptions;
    }]);
})
.run(function($rootScope, $location, AuthService,UserService,Notification){
	$rootScope.loggedin=false;
	$rootScope.data={
					query:"",
					category:null
				};
	// $rootScope.tsb="<a  class='list-group-item' ng-click='search(0)'>Job</a><a  class='list-group-item' ng-click='search(1)'>Poeple</a><a  class='list-group-item' ng-click='search(2)'>Event</a>";
	/*ROUTE HANDLERS*/
	$rootScope.activeM=-1;
	$rootScope.activeSM=-1;

	$rootScope.routes=['/home/',"/dashboard","/people","/events","/jobs","/message","/profile","aboutus","ourmission","advertise","contactus"];
	$rootScope.subRoutes=[
					["jobs/my-applications","events/interested","/message/compose","/people/connected","/profile/.+/about"],
					["events/my-events","/jobs/my-job-postings","/message/inbox","/profile/.+/posts"],
					["events/post-new","/jobs/new-job","/message/unread","/profile/.+/photo"],
					["/jobs/my-projects","/message/sent","/profile/.+/video"],
					["/profile/.+/audio"],
					["/profile/.+/script-works"]
					];

	$rootScope.findSubRoute=function(){
    	var found=false;
		for (var i = $rootScope.subRoutes.length - 1; i >= 0; i--) {
			for (var j = $rootScope.subRoutes[i].length - 1; j >= 0; j--) {
				//if($location.path().indexOf($rootScope.subRoutes[i][j])>-1){

				if($location.path().match($rootScope.subRoutes[i][j])){
					//console.log($location.path().match($rootScope.subRoutes[i][j]), i,j, $rootScope.subRoutes[i],$rootScope.subRoutes[i][j]);
					//$rootScope.SM=$location.path().match($rootScope.subRoutes[i][j]).index;
					$rootScope.SM=i;
					var found=true;
					break;
				}
			}
			if(found){break;}
		};
	}

	// $rootScope.sideMenuClass="hidden-xs";
	// $rootScope.toggleSM=function () {
	// 	if($rootScope.sideMenuClass=="hidden-xs"){$rootScope.sideMenuClass="custom-vxs";}
	// 	else{$rootScope.sideMenuClass="hidden-xs";}
	//
	// }

	$rootScope.$on('$locationChangeSuccess', function(event){
        var url = $location.url()/*,
        params = $location.search()*/;
        if(url=="/"){     	$rootScope.islanding=true;      }
        else{
					if((_.contains(_.flatten($rootScope.subRoutes),url) || url=="/dashboard") && !AuthService.isloggedin()){

							$location.path("/");
							Notification.error({message: 'You must log in first.', replaceMessage: true});
					}
					else{
							$rootScope.islanding=false;

							for(var r=0 ;r<$rootScope.routes.length;r++){
								if($location.path().indexOf($rootScope.routes[r])>-1){
									$rootScope.activeM=r;
									$rootScope.findSubRoute();
									break;
								}
								else{
									if(r==$rootScope.routes.length-1) $rootScope.activeM=-1;
								}
							}
					}

        }
	});
	$rootScope.updateUserStatus=function(){
		$rootScope.isLoggedIn=AuthService.isloggedin();
		if($rootScope.isLoggedIn){ $rootScope.userData=UserService.get(); }
		else{$rootScope.userData==null;}
	}
	$rootScope.updateUserStatus();

	$rootScope.logout=function () {
		AuthService.logout().success(function () {
			$location.path('/');
			$location.search({});
			console.log($rootScope.isLoggedIn);
		})

	}

	$rootScope.showcats=function () {
		if($rootScope.data.query.length>1){
			$rootScope.showcat=true;
		}
		else{
			$rootScope.showcat=false;
		}
	}
	$rootScope.search=function (arg) {
		$rootScope.data.category=arg;
		$location.path('/search');
		$location.search($rootScope.data);
		console.log($rootScope.data.query);
		$rootScope.showcat=false;
	}
	/*OTHER PARAMS*/
	//$rootScope.sign=0;//0 or 1: sign up or sign in
})

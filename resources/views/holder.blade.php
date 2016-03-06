<html ng-app="cultstage">
<head>
	<title>CultStage</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/holder.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
	<link rel="stylesheet" type="text/css" href="css/media-control.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<!-- <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'> -->
	
	<script type="text/javascript" src="js/lib/jquery.min.js"></script>
	<script type="text/javascript" src="js/lib/angular.min.js"></script>
	<script type="text/javascript" src="js/lib/angular.route.min.js"></script>
	<script type="text/javascript" src="js/lib/underscore.js"></script>
	<script type="text/javascript" src="js/lib/bootstrap.min.js"></script>

	

	<script type="text/javascript" src="js/app/app.js"></script>
	<script type="text/javascript" src="js/controller/controller.js"></script>
	<script type="text/javascript" src="js/controller/editprofile.js"></script>
	<script type="text/javascript" src="js/controller/dashboard.js"></script>
	<script type="text/javascript" src="js/controller/people.js"></script>
	<script type="text/javascript" src="js/controller/aboutcontroller.js"></script>
	<script type="text/javascript" src="js/controller/myevents.js"></script>
	<script type="text/javascript" src="js/controller/postnewevent.js"></script>
	<script type="text/javascript" src="js/controller/newjob.js"></script>
	<script type="text/javascript" src="js/controller/project.js"></script>
	<script type="text/javascript" src="js/controller/jobpostings.js"></script>
	<script type="text/javascript" src="js/controller/appliedjobs.js"></script>
	<script type="text/javascript" src="js/controller/compose.js"></script>
	<script type="text/javascript" src="js/controller/post.js"></script>
	<script type="text/javascript" src="js/controller/searchcontroller.js"></script>
	<!--script type="text/javascript" src="js/controller/sent.js"></script>
	<script type="text/javascript" src="js/controller/inbox.js"></script-->

	<script type="text/javascript" src="js/directive/directive.js"></script>
	<script type="text/javascript" src="js/filters/filters.js"></script>
	<script type="text/javascript" src="js/service/validator.js"></script>

</head>
<body style="min-width:700px">
	<sign-modal></sign-modal>
	<div ng-class="{'header-bar':true,'clearfix':true,'th':islanding}">
		<a href="#/"  class="pull-left"><i class="fa fa-modx"></i> CultStage</a>
		<div ng-hide="islanding" class="search-bar-top col-md-4">
			<div class="form-group"><i class="fa fa-search"></i> 
				<input 
				class="form-control" 
				ng-model="data.query" 
				type="text" 
				placeholder="What are you searching?" 
				ng-change="showcats()"></input> 
				<div class="categories list-group" style="position: fixed;z-index: 10;min-width: 400px;" ng-show="showcat">
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(0)">Job</a>
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(1)">Poeple</a>
					<a style="border-radius: 0;" class="list-group-item" ng-click="search(2)">Event</a>
				</div>
			</div>
		</div>
		<div class="pull-right">
		<a href="#/jobs/new-job" class="post-header-btn">Post a Job</a>
		<ul class="header-menu-bar pull-right">
			<li ng-hide="isLoggedIn"> <a href="" data-toggle="modal" data-target="#sign-modal" ng-click="sign=0" >Sign Up</a></li><li ng-hide="isLoggedIn"><a href="" data-toggle="modal" data-target="#sign-modal" ng-click="sign=1" >Log In</a></li>
			<li ng-show="isLoggedIn" class="top-msg"><a href="">Messages <i class="fa fa-inbox pull-right"></i></a>
				<div class="list-group dropdown-list-menu">
					<div class="list-group-item" ng-class="{'nocaret':!islanding}">
						<div class="item-heading">Inbox (0)<a class="pull-right mt10lh20" href="#/message/inbox">View Inbox</a></div>
						<!-- <div class="item-content"> <a href="">X y z</a></div> -->
					</div>
					<div class="list-group-item">
						<div class="item-heading"> Notification<a class="pull-right mt10lh20" href="#/dashboard">View Notifications</a></div>
						<!-- <div class="item-content"> You have 1 notification in dashboard<a class="pull-right" href=""></a></div>	 -->			
					</div>
				</div>
			</li><li class="top-menu" ng-show="isLoggedIn"> 
			<a class="accountsettings" href="#/dashboard" ng-click="sign=0" >@{{userData.name}}<div class="img-holder"><img ng-src="@{{userData.avatar==null?userData.avatar:'images/avatar-default.jpg'}}"></div></a>
				<div class="list-group dropdown-list-menu">
					<div class="list-group-item" ng-class="{'nocaret':!islanding}" style=""><a class="clearfix" href="#/jobs/my-applications"><div class="item">Your Jobs</div></a></div>
					<div class="list-group-item"><a  class="clearfix" href="#/profile/edit"><div class="item">Edit Profile</div></a></div>
					<div class="list-group-item"><a class="clearfix" href=""><div class="item">Invite Friends</div></a></div>
					<div class="list-group-item"><a class="clearfix" href="" ng-click="logout()"><div class="item">Logout</div></a></div>
				</div>
			</li>
		</ul>
		</div>
	</div>


	<div ng-view >

	</div>

	<footer>

			<div class="footer-contents">
				<div class="container">
					<div class="col-md-4">
						<a class="logo">CultStage</a>
						<span></span>
					</div>
					<div class="col-md-8">
						<ul class="f-menu" class="col-md-6">
							<li><a href="">Terms of Use</a></li>
							<li><a href="">DCMA notice</a></li>
							<li><a href="">Privacy Policy</a></li>
							<li><a href="">Contact Us</a></li>
						</ul>
						<ul class="f-menu" class="col-md-6">
							<li><a href="">Press Enquiries</a></li>
							<li><a href="">Business Development</a></li>
							<li><a href="">Technical Support</a></li>
							<li><a href="">Investors Section</a></li>
						</ul>
						<ul class="f-menu" class="col-md-6">
							<li><a href="#/aboutus">About Us</a></li>
							<li><a href="#/ourmission">Our Mission</a></li>
							<li><a href="#/advertise">Advertise on CultStage</a></li>
							<li><a href="#/teach">Teach with CultStage</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-social">
				<div class="container">
					<span>©2010-2015 CultStage.</span>
				 	<div class="pull-right socials">
				 	<div><a href="" class="fa fa-twitter"></a> </div>
				 	<div><a href="" class="fa fa-youtube"></a> </div>
				 	<div><a href="" class="fa fa-facebook"></a> </div>
				 	<div><a href="" class="fa fa-pinterest"></a> </div>
				 	<div><a href="" class="fa fa-instagram"></a> </div>
				 </div>
				</div>
				 
			</div>
		
	</footer>

</body>
<script src="/bower_components/ng-file-upload/ng-file-upload.min.js"></script>

	<script src='/bower_components/textAngular/dist/textAngular-rangy.min.js'></script>
	<script src='/bower_components/textAngular/dist/textAngular-sanitize.min.js'></script>
	<script src='/bower_components/textAngular/dist/textAngular.min.js'></script>
	<script src='/bower_components/ui-select/dist/select.js'></script>
	
	<link rel='stylesheet' href='/bower_components/textAngular/dist/textAngular.css'>
	<link rel='stylesheet' href='/bower_components/ui-select/dist/select.css'>

</html>